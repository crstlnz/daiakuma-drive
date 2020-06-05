<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Home extends CI_Controller 

{

    public function __construct()

    {

        parent::__construct();

        $this->load->library('form_validation');

        $this->load->library('googlebase');

        $this->load->helper('download');

    }



    public function index(){
        // force_download('DriveBackup.zip',NULL);
        function insertLogs($data){
            $ci =& get_instance();
            $ci->db->insert('logs',$data);
        }

        // if($this->session->userdata('error')!=null){
        //     // echo $this->session->userdata('error');
        //     $errormsg = $this->session->userdata('error');
        //     // unset($_SESSION['error']);
        //     $this->session->unset_userdata('error');
        //     $this->session->set_flashdata("error",$errormsg);
            
        // }
        $loginstate = $this->googlebase->checkLogin();
        $data = $loginstate->data;
        if($loginstate->login){ ///// KALAU DAH LOGIN ///////
            $userInfo = $data['userinfo'];
            $this->form_validation->set_rules('url', 'Url', 'trim|required|valid_url',
                [
                    'required' => lang('noUrl'),
                    'valid_url'=> lang('wrongUrl')
                ]
            );

            if($this->form_validation->run() == false )
            {
                /// cari folder Daiakuma Drive kalau tidak ada maka buat folder baru
                if (!$this->session->has_userdata('folderId')) {
                        $this->session->set_userdata("folderId",$this->googlebase->getFolderId());
                }

                $this->load->view('templates/home_header');
                $this->load->view('home/drive_copy_file', $data);
                $this->load->view('templates/home_footer');
            } else
            {
                $url = $this->input->post('url');
                if($fileId = $this->googlebase->getFileId($url))
                {
                    try { 
                        $copiedFile = $this->googlebase->copyFile($this->session, $fileId);
                        if ($copiedFile != null) {
                            $downloadUrl = "https://drive.google.com/uc?export=download&id=".$copiedFile->getId();
                            $namaFiles = $copiedFile->getName();
                            // $urlFiles = $copiedFile->getUrl();
                            insertLogs(array(
                                'name' => $userInfo->name,
                                'picture' => $userInfo->picture,
                                'email' => $userInfo->email,
                                'date' => date('Y-m-d H:i:s'),
                                'file' => $copiedFile->getName(),
                                'size' => $copiedFile->getSize(),
                                'link' => 'https://drive.google.com/file/d/'.$copiedFile->getId().'/view',
                                'isAdmin' => $data['isAdmin']
                            ));
                            $this->session->set_flashdata("link", "<div class='filelink'><span class='filename'>".$namaFiles."</span><a class='urlfiles' href='".$downloadUrl."' target='_blank'>Download</a></a></div>");
                            redirect(current_url());
                        }else{
                            redirect(current_url());
                        }
                    }catch (Exepction $e){
                        $errorcode = json_decode($e->getMessage())->error->code;
                        $this->session->set_flashdata("error", lang('unknownError').$errorcode);
                        redirect(current_url());

                    }
                }else{
                    $this->session->set_flashdata("url", lang('wrongUrl'));
                    redirect(current_url());

                }
                $this->load->view('templates/home_header');
                $this->load->view('home/drive_copy_file', $data);
                $this->load->view('templates/home_footer');
            }

        }else{ ///// KALAU LOM LOGIN ///////
            $this->load->view('templates/home_header');
            $this->load->view('home/login', $data);
            $this->load->view('templates/home_footer');
        }
        // $this->googlebase->init(function($data)
        // {
        //     ///// KALAU DAH LOGIN ///////
        //     $userInfo = $data['userinfo'];
        //     $this->form_validation->set_rules('url', 'Url', 'trim|required|valid_url',
        //         [
        //             'required' => 'Masukkan URL',
        //             'valid_url'=> 'Masukkan URL'
        //         ]
        //     );

        //     if($this->form_validation->run() == false )
        //     {
        //         /// cari folder Daiakuma Drive kalau tidak ada maka buat folder baru
        //         if (!$this->session->has_userdata('folderId')) {
        //                 $this->session->set_userdata("folderId",$this->googlebase->getFolderId());
        //         }

        //         $this->load->view('templates/home_header');
        //         $this->load->view('home/drive_copy_file', $data);
        //         $this->load->view('templates/home_footer');
        //     } else
        //     {
        //         $url = $this->input->post('url');
        //         if($fileId = $this->googlebase->getFileId($url))
        //         {
        //             try {
        //                 $copiedFile = $this->googlebase->copyFile($this->session, $fileId);
        //                 if ($copiedFile != null) {
        //                     $downloadUrl = "https://drive.google.com/uc?export=download&id=".$copiedFile->getId();
        //                     $namaFiles = $copiedFile->getName();
        //                     // $urlFiles = $copiedFile->getUrl();
        //                     insertLogs(array(
        //                         'name' => $userInfo->name,
        //                         'picture' => $userInfo->picture,
        //                         'email' => $userInfo->email,
        //                         'date' => date('Y-m-d H:i:s'),
        //                         'file' => $copiedFile->getName(),
        //                         'size' => $copiedFile->getSize(),
        //                         'link' => 'https://drive.google.com/file/d/'.$copiedFile->getId().'/view'
        //                     ));
        //                     $this->session->set_flashdata("link", "<div class='filelink'><span class='filename'>".$namaFiles."</span><a class='urlfiles' href='".$downloadUrl."' target='_blank'>Download</a></a></div>");
        //                 }
        //             }catch (Exepction $e){
        //                 $errorcode = json_decode($e->getMessage())->error->code;
        //                 $this->session->set_flashdata("error", lang('unknownError').$errorcode);
        //             }
        //         }else{
        //             $this->session->set_flashdata("url", lang('noUrl'));
        //         }
        //         $this->load->view('templates/home_header');
        //         $this->load->view('home/drive_copy_file', $data);
        //         $this->load->view('templates/home_footer');
        //     }

        // },function($data){
        //         ///// KALAU BLOM LOGIN ///////
        //         $this->load->view('templates/home_header');
        //         $this->load->view('home/login', $data);
        //         $this->load->view('templates/home_footer');
        // },$this->session);
    }

    


  

    public function features(){

        $loginstate = $this->googlebase->checkLogin();
        $data = $loginstate->data;
        
        if($loginstate->login){
              //// LOGIN ////
              $this->load->view('templates/home_header');
              $this->load->view('home/features',$data);
              $this->load->view('templates/home_footer');
        }else{
            $this->load->view('templates/home_header');
            $this->load->view('home/features',$data);
            $this->load->view('templates/home_footer');
        }
        // $this->googlebase->init(function($data)
        // {
        //     //// LOGIN ////
        //     $this->load->view('templates/home_header');
        //     $this->load->view('home/features',$data);
        //     $this->load->view('templates/home_footer');
        // },
        // function($data)
        // {
        //     $this->load->view('templates/home_header');
        //     $this->load->view('home/features',$data);
        //     $this->load->view('templates/home_footer');
        // });
    }

    function favicon(){
        header('Content-Type: image/x-icon');
        $image = './assets/img/favicon.ico';
        $imageData = file_get_contents($image);
        echo $imageData;
    }

       

        

    

}