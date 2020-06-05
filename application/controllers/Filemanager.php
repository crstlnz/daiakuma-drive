<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Filemanager extends CI_Controller
{



    public function __construct()

    {

        parent::__construct();

        $this->load->library('googlebase');
    }



    public function index()
    {

        // $this->lang->load('home','english');

        // require_once 'vendor/google-api/vendor/autoload.php';
        $loginstate = $this->googlebase->checkLogin();
        $data = $loginstate->data;
        // $this->googlebase->setDebug(true);

        if ($loginstate->login) {
            $data['limitString'] = $this->googlebase->getLimitString();
            $this->load->view('templates/filemanager_header');
            $this->load->view('filemanager/filemanager', $data);
            $this->load->view('templates/filemanager_footer');
        } else {
            redirect('/');
        }
        // $this->googlebase->init(function($data)
        // {
        //     $data['limitString']= $this->googlebase->getLimitString();
        //     $this->load->view('templates/filemanager_header');
        //     $this->load->view('filemanager/filemanager',$data);
        //     $this->load->view('templates/filemanager_footer');
        // },
        // function()
        // {
        //     redirect('/');
        // });
    }





    public function filedata()
    {

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {



            function round_ups($value, $precision)
            {

                $pow = pow(10, $precision);

                return (ceil($pow * $value) + ceil($pow * $value - ceil($pow * $value))) / $pow;
            }

            // function getSize($size){

            //     $besak = ceil($size/1000);





            //     if ($besak >1000) {

            //         $besak = $besak / 1000;

            //         if ($besak >1000) {

            //             $besak = $besak/1000;

            //             $sizes = round_ups($besak,2)." GB";

            //             return $sizes;

            //         }else{

            //             if ($besak>100) {

            //                 $sizes = round_ups($besak,0)." MB";

            //                 return $sizes;

            //             }else{

            //                 $sizes = round_ups($besak,2)." MB";

            //                 return $sizes;

            //             }

            //         }

            //     }else{

            //         $sizes = round_ups($besak,2)." KB";

            //         return $sizes;

            //     }

            // }

            function getSize($bytes, $precision = 2)
            {
                $units = array('B', 'KB', 'MB', 'GB', 'TB');

                $bytes = max($bytes, 0);
                $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
                $pow = min($pow, count($units) - 1);

                // Uncomment one of the following alternatives
                // $bytes /= pow(1024, $pow);
                $bytes /= (1 << (10 * $pow));

                return round($bytes, $precision) . ' ' . $units[$pow];
            }



            $array = [];

            // require_once 'vendor/google-api/vendor/autoload.php';

            $loginstate = $this->googlebase->checkLogin();
            $data = $loginstate->data;

            if ($loginstate->login) {
                if (!$this->session->has_userdata('folderId')) {

                    try {

                        $this->session->set_userdata("folderId", $this->googlebase->getFolderId());
                    } catch (Exception $e) {

                        echo $e->getMessage();
                    }
                }



                try {

                    $filelist =  $this->googlebase->getFileList($this->session->userdata("folderId"));

                    $count = count($filelist);

                    if ($count != 0) {

                        // echo json_encode($filelist);

                        $data = [];


                        foreach ($filelist as $item) {
                            array_push($data, array(

                                "id" => $item->id,

                                "name" => $item->name,

                                "createdTime" => $item->createdTime,

                                "size" => getSize($item->size)

                            ));
                        }
                        // for ($i=0; $i < $count; $i++) { 

                        //     array_push($data, array(

                        //         "id" => $filelist[$i]->id,

                        //         "name" => $filelist[$i]->name,

                        //         "createdTime" => $filelist[$i]->createdTime,

                        //         "size" => getSize($filelist[$i]->size)

                        //     ));
                        // }
                        echo json_encode(array("data" => $data));
                    } else {
                        echo json_encode(array("data" => []));
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                redirect('/');
            }

            // $this->googlebase->init(function($data)
            // {

            //         if (!$this->session->has_userdata('folderId')) {

            //             try {

            //                 $this->session->set_userdata("folderId",$this->googlebase->getFolderId());

            //             } catch (Exception $e){

            //                 echo $e->getMessage();

            //             }

            //         } 



            //         try{

            //             $filelist =  $this->googlebase->getFileList($this->session->userdata("folderId"));

            //             $count = count($filelist->files);

            //             if ($count != 0) {

            //                 // echo json_encode($filelist);

            //                 $data = [];



            //                 for ($i=0; $i < $count; $i++) { 

            //                     array_push($data, array(

            //                         "id" => $filelist[$i]->id,

            //                         "name" => $filelist[$i]->name,

            //                         "createdTime" => $filelist[$i]->createdTime,

            //                         "size" => getSize($filelist[$i]->size)

            //                     ));
            //                 }
            //                 echo json_encode(array("data"=> $data));
            //             }else{
            //                 echo json_encode(array("data"=> []));
            //             }
            //         } catch (Exception $e){
            //             echo $e->getMessage();             
            //         }

            // },function($data)
            // {
            //     $this->session->unset_userdata('folderId');
            //     unset($_SESSION['token']);
            //     redirect('/');
            // });

        } else {

            show_404();
        }

        // for ($i=1; $i <= 50 ; $i++) { 

        //     array_push($array, array(

        //         $i, "File ".$i, "Waktu ".$i, "Ukuran ".$i." MB", "Delete" 

        //     ));

        // }



        // $data = [ 

        //     "status"=> array(

        //         "message" => "Sukses",

        //         "code"    => 200

        //     ),

        //     "data" => $array ];



        // echo json_encode($data);

    }



    public function delete()
    {



        if ($_SERVER["REQUEST_METHOD"] === 'POST') {

            $login = $this->googlebase->login();

            if ($login == 200) {
                if (isset($_POST['ids'])) {

                    $delete = $this->googlebase->deleteFile($_POST['ids']);

                    if ($delete == "File telah di delete!") {

                        echo lang('deleted');
                    } else {

                        echo $delete;
                    }
                } else {

                    echo "Internal Error code : 91";
                }
            } else if ($login == 404) {
                $this->session->unset_userdata('folderId');

                $this->session->unset_userdata('token');

                echo "Token Expired";
            } else if ($login == 400) {
                echo "User not logged in";
            }


            // if (!empty($_SESSION['token'])) {

            //     $client->setAccessToken($_SESSION['token']);



            //     if ($client->isAccessTokenExpired()) {

            //         $this->session->unset_userdata('folderId');

            //         unset($_SESSION['token']);

            //         echo "User not logged in";

            //     } else

            //     {

            //         if (isset($_POST['ids'])) {

            //             $delete = $this->googlebase->deleteFile($_POST['ids']);

            //             if( $delete == "File telah di delete!"){

            //                 echo lang('deleted');

            //             }else{

            //                 echo $delete;

            //             }

            //         }else{

            //             echo "Internal Error code : 91";

            //         }

            //     }

            // }else {

            //     echo "Internal Error code : 92";

            // }





        } else {

            show_404();
        }
    }



    public function getlimit()
    {

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {

            $login = $this->googlebase->login();

            if ($login == 200) {
                echo $this->googlebase->getLimitString();
            } else if ($login == 404) {
                $this->session->unset_userdata('folderId');

                unset($_SESSION['token']);

                echo "Token Expired";
            } else if ($login == 400) {
                echo "Belum Login";
            }
            // if (!empty($_SESSION['token'])) {

            //     $client->setAccessToken($_SESSION['token']);



            //     if ($client->isAccessTokenExpired()) {

            //         $this->session->unset_userdata('folderId');

            //         unset($_SESSION['token']);

            //         echo "Token Expired";

            //     } else

            //     {

            //         echo $this->googlebase->getLimitString();

            //     }

            // }else {

            //     echo "Belum Login";

            // }





        } else {

            show_404();
        }
    }
}
