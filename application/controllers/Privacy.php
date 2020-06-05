<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Privacy extends CI_Controller {



    public function __construct()

    {

        parent::__construct();

        $this->load->library('googlebase');



    }



    public function index ()

    {



         // require_once 'vendor/google-api/vendor/autoload.php';

        //  if (!$oauth_credentials = $this->googlebase->getOAuthCredentialsFile())

        //  {

        //      echo $this->googlebase->missingOAuth2CredentialsWarning();

        //      return;

        //  }

 

        //  $this->session->set_flashdata("url", null);

        //  $this->session->set_flashdata("link", null);

 

        //  $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

        //  $client = $this->googlebase->getClient();

        //  $client->setAuthConfig($oauth_credentials);

        //  $client->setRedirectUri($redirect_uri);

        //  $client->addScope(array(

        //  "https://www.googleapis.com/auth/drive",

        //  "https://www.googleapis.com/auth/userinfo.profile",

        //  "https://www.googleapis.com/auth/userinfo.email"

        //  ));

        //  $service = new Google_Service_Drive($client);

        //  $oauth2 = new Google_Service_Oauth2($client);

 

        //  if (isset($_REQUEST['logout'])) 

        //  {

        //      $this->session->unset_userdata('folderId');

        //      $client->revokeToken();

        //      unset($_SESSION['token']);

        //      redirect('/');




        //  }

 



        //     if (!empty($_SESSION['token'])) {

        //         $client->setAccessToken($_SESSION['token']);

               

        //         if ($client->isAccessTokenExpired()) {

        //             $this->session->unset_userdata('folderId');

        //             unset($_SESSION['token']);

        //             redirect('/');


                   

        //         }else{

        //             $userInfo = $oauth2->userinfo->get(); // get user info

        //             $data['authUrl'] = '';

        //             // sudah login

        //             $data['username']= $userInfo->name;

        //             $data['picture']= $userInfo->picture;

        //             $data['isAdmin'] = false;

        //             if($userInfo->email == 'kelvinzzzzzzzzzz@gmail.com'){
        //                 $data['isAdmin'] = true;
        //             }


        //             $this->load->view('templates/home_header');

        //             $this->load->view('policy/privacy',$data);

        //             $this->load->view('templates/home_footer');

        //         }



        //     }else{

        //         $authUrl = $client->createAuthUrl();

        //         $data['authUrl'] = $authUrl;

        //         $this->load->view('templates/home_header');

        //         $this->load->view('policy/privacy', $data);

        //         $this->load->view('templates/home_footer');

        //     }


            $loginstate = $this->googlebase->checkLogin();
            $data = $loginstate->data;

            if($loginstate->login){
                $this->load->view('templates/home_header');

                $this->load->view('policy/privacy',$data);

                $this->load->view('templates/home_footer');
            }else{
                $this->load->view('templates/home_header');

                $this->load->view('policy/privacy', $data);

                $this->load->view('templates/home_footer');
            }
    
     

    }



    public function terms()

    {

        // require_once 'vendor/google-api/vendor/autoload.php';

    //     if (!$oauth_credentials = $this->googlebase->getOAuthCredentialsFile())

    //     {

    //         echo $this->googlebase->missingOAuth2CredentialsWarning();

    //         return;

    //     }



    //     $this->session->set_flashdata("url", null);

    //     $this->session->set_flashdata("link", null);

    //     $this->session->set_flashdata("error", null);



    //     $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

    //     $client = $this->googlebase->getClient();

    //     $client->setAuthConfig($oauth_credentials);

    //     $client->setRedirectUri($redirect_uri);

    //     $client->addScope(array(

    //     "https://www.googleapis.com/auth/drive",

    //     "https://www.googleapis.com/auth/userinfo.profile",

    //     "https://www.googleapis.com/auth/userinfo.email"

    //     ));

    //     $service = new Google_Service_Drive($client);

    //     $oauth2 = new Google_Service_Oauth2($client);



    //     if (isset($_REQUEST['logout'])) 

    //     {

    //         $this->session->unset_userdata('folderId');

    //         $client->revokeToken();

    //         unset($_SESSION['token']);

    //         redirect('/');






    //     }





    //        if (!empty($_SESSION['token'])) {

    //            $client->setAccessToken($_SESSION['token']);

              

    //            if ($client->isAccessTokenExpired()) {

    //                 $this->session->unset_userdata('folderId');

    //                 unset($_SESSION['token']);

    //                 redirect('/');


    //            }else{

    //                $userInfo = $oauth2->userinfo->get(); // get user info

    //                $data['authUrl'] = '';

    //                // sudah login

    //                $data['username']= $userInfo->name;

    //                $data['picture']= $userInfo->picture;

    //                $data['isAdmin'] = false;

    //                if($userInfo->email == 'kelvinzzzzzzzzzz@gmail.com'){
    //                    $data['isAdmin'] = true;
    //                }
    

    //                $this->load->view('templates/home_header');

    //                $this->load->view('policy/terms',$data);

    //                $this->load->view('templates/home_footer');

    //            }



    //        }else{

    //            $authUrl = $client->createAuthUrl();

    //            $data['authUrl'] = $authUrl;

    //            $this->load->view('templates/home_header');

    //            $this->load->view('policy/terms', $data);

    //            $this->load->view('templates/home_footer');

    //        }



    // }
    $loginstate = $this->googlebase->checkLogin();
    $data = $loginstate->data;

    if($loginstate->login){
        $this->load->view('templates/home_header');

        $this->load->view('policy/terms',$data);

        $this->load->view('templates/home_footer');
    }else{
        $this->load->view('templates/home_header');

        $this->load->view('policy/terms', $data);

        $this->load->view('templates/home_footer');
    }
}
}