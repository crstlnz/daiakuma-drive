<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class File extends CI_Controller {
 


    public function __construct ()

    {

        parent::__construct(); 
        $this->load->library('googlebase');

    }

    public function index(){
        // var_dump($this->googlebase->checklogin());
        function insertLogs($data){
            $ci =& get_instance();
            $ci->db->insert('logs',$data);
        }
        $code = $this->uri->segment(1);
        // $this->googlebase->setDebug(true);
        $this->googlebase->setRedirectLogout(current_url());
        // $this->googlebase->setRedirectUri("https://drive.daiakuma.me/file");
        $this->googlebase->setState(false,current_url());
        $this->googlebase->setRedirect(false);

        // $create = $this->googlebase->createLink("");
        if($code!=null){
            if($code=="file"){
                show_404();
                die();
            }
            $res = $this->db->get_where('file' ,array('linkId'=> $code))->result();
      
            if(count($res)<1){
                show_404();
            }else{
                $loginstate = $this->googlebase->checkLogin();
                $data = $loginstate->data;
                $data['file'] = $res[0];
                $fileid = $res[0]->fileId;
                $linkId = $res[0]->linkId;
                // echo $fileid;
                if($loginstate->login){
                    $userInfo = $data['userinfo'];
                    if($this->input->post("download")){
                        // echo "downloading";
                        $copyFile = $this->googlebase->copyFileNew($this->session, $fileid);
                        if(!$copyFile->error){
                            $this->googlebase->updateChecked(true,$linkId);
                            $copiedFile = $copyFile->filecopy;
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
                            redirect($copyFile->filecopy->webContentLink);
                            die(); 
                        }else{
                            if($copyFile->code == 404){
                                $this->googlebase->updateChecked(false,$linkId);
                            }else{
                                $this->googlebase->updateChecked(true,$linkId);
                            }
                            
                            $data['error'] = $copyFile->message;
                        }
                    }else if(isset($_REQUEST['download'])){
                        $copyFile = $this->googlebase->copyFileNew($this->session, $fileid);
                        if(!$copyFile->error){
                            $this->googlebase->updateChecked(true,$linkId);
                            $copiedFile = $copyFile->filecopy;
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
                            redirect($copyFile->filecopy->webContentLink);
                            die();
                        }else{
                            if($copyFile->code == 404){
                                $this->googlebase->updateChecked(false,$linkId);
                            }else{
                                $this->googlebase->updateChecked(true,$linkId);
                            }

                            $data['error'] = $copyFile->message;
                        }
                    }
    
                }else{
                    if($this->input->post("download")){
                        // $state = new stdClass();
                        // // $state->download = true;
                        // $state->url = current_url();
                        $this->googlebase->setState(true, current_url()); 
                        redirect($this->googlebase->getAuthUrl());
                    }     
                }
    
                
                $this->load->view('file/header');
                $this->load->view('file/main', $data);
                $this->load->view('templates/home_footer');
            }
        }else{
            show_404();
        }
        
        // echo json_encode($res);
        // mimeType
        // name
        // size
        // createdTime
        // iconLink
        // id

        // if(!$create->error){
        //     echo json_encode($create->file);
        // }else{
        //     echo $create->message;
        // }

        // echo date("Y-m-d H:i:s",strtotime("2018-03-03T01:17:22.608Z"));
        // if($code!=null){
        //     $decode = $this->googlebase->decrypt($code);
        //     if($code==$this->googlebase->encrypt($decode)){
        //         echo "benar";
        //     }else{
        //         echo "salah";
        //     }
        //     echo "<br>";
        //     $loginstate = $this->googlebase->checkLogin();
        //     // var_dump($loginstate);
        //     if($loginstate->login){
        //         echo $loginstate->data["username"];
        //         echo "<br>dah login";
        //     }else{
        //         /// arg 1 buat download true atau false
        //         /// arg 2 url redirect
        //         $this->googlebase->setState(false,base_url()."file/".$code);
        //         echo "<a href='".$this->googlebase->getAuthUrl()."'>Login</a>";
        //     }
     
        // }else{
        //     show_404();
        // }

    }

}