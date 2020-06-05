<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Admin extends CI_Controller 

{

    
    public function __construct()

    {

        parent::__construct();

        $this->load->library('googlebase');
     
    }



    public function index ()
    {
        $this->load->library('form_validation');
        $this->googlebase->setDebug(true);
        $loginstate = $this->googlebase->checkLogin();

        if($loginstate->login){
            $data= $loginstate->data;
            $data['link'] = null;
            $data['error'] = false;

            if($data['isAdmin']){
                $this->form_validation->set_rules('url', 'Url', 'trim|required|valid_url',
                [
                    'required' => lang('noUrl'),
                    'valid_url'=> lang('wrongUrl')
                ]
                );
    
                if($this->form_validation->run()){
                    $url = $this->input->post('url');
                    $createLink = $this->googlebase->createLink($url);
                    if(!$createLink->error){
                        $data['link'] = $createLink->link;
                        $data['filename'] = $createLink->fileName;
                        $this->session->set_flashdata("link", $createLink->link);
                        $this->session->set_flashdata("filename",$createLink->fileName);


                    }else{
                        $this->session->set_flashdata("error", $createLink->message);

                        $data['error'] = $createLink->message;
                    }

                    $this->load->view('templates/home_header');
                    // $data['loginlogs'] = $this->db->get('loginlogs')->result();
                    $this->load->view('admin/admin', $data);
                    $this->load->view('templates/home_footer');
                }else{
                    $this->load->view('templates/home_header');
                    // $data['loginlogs'] = $this->db->get('loginlogs')->result();
                    $this->load->view('admin/admin', $data);
                    $this->load->view('templates/home_footer');
                }
                // $userInfo = $data['userinfo'];
                // $data['username']= $userInfo->name;

                // $data['picture']= $userInfo->picture;
                
                // $this->load->view('templates/home_header');
                // // $data['loginlogs'] = $this->db->get('loginlogs')->result();
                // $this->load->view('admin/admin', $data);
                // $this->load->view('templates/home_footer');
            }else{
                show_404();
            }
        }else{
            show_404();
        }
     
        // $this->googlebase->init(function($data)
        // {
          
        // },function(){
          
        // });  

    }


    public function loginlogs(){
        $this->googlebase->setDebug(true);
        $loginstate = $this->googlebase->checkLogin();

        if($loginstate->login){
            $data= $loginstate->data;
            if($data['isAdmin']){
                $userInfo = $data['userinfo'];
                $data['username']= $userInfo->name;

                $data['picture']= $userInfo->picture;
                
                $this->load->view('templates/home_header');
                if(isset($_REQUEST['showadmin'])){
                    $data['loginlogs'] = $this->db->get_where('loginlogs' ,array('isAdmin'=> 1))->result();
                }else{
                    $data['loginlogs'] = $this->db->get_where('loginlogs' ,array('isAdmin'=> 0))->result();
                    // $data['loginlogs'] = $this->db->get('loginlogs')->result();
                }
                $this->load->view('admin/loginlogs', $data);
                $this->load->view('templates/home_footer');
            }else{
                show_404();
            }
        }else{
            show_404();
        }
    }


    function logs(){
        $this->googlebase->setDebug(true);

        $loginstate = $this->googlebase->checkLogin();

        if($loginstate->login){
            $data= $loginstate->data;
            if($data['isAdmin']){
                if(isset($_REQUEST['showadmin'])){
                    $data['logs'] =  $this->db->get_where('logs' ,array('isAdmin'=> 1))->result();
                }else{
                    $data['logs'] =  $this->db->get_where('logs' ,array('isAdmin'=> 0))->result();
                }
                $userInfo = $data['userinfo'];
                $data['username']= $userInfo->name;

                $data['picture']= $userInfo->picture;
                
                $this->load->view('templates/home_header');
               
                $this->load->view('admin/logs', $data);
                $this->load->view('templates/home_footer');
            }else{
                show_404();
            }
        }else{
            show_404();
        }
    }


    function listfile(){
        $loginstate = $this->googlebase->checkLogin();

        $data = $loginstate->data;
        if($loginstate->login){
            if($data['isAdmin']){
                if(isset($_GET['delete'])){
                    $where = array('linkId' => $_GET['delete']);
                    $this->db->where($where);
                    $this->db->delete('file');
                    redirect(current_url());
                }

                $userInfo = $data['userinfo'];
                $data['username']= $userInfo->name;

                $data['picture']= $userInfo->picture;
                
                $this->load->view('templates/home_header');
                $data['logs'] = $this->db->get('file')->result();
                $this->load->view('admin/listfile', $data);
                $this->load->view('templates/home_footer');
            }else{
                show_404();
            }
        }else{
            show_404();
        }
    }

}