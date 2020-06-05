<?php 



class Googlebase 

{


  /////////////////////////////////////////////////////////////////////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////////////////////////
  function __construct($redirect = "https://drive.daiakuma.me"){

      if (!$this->oauth_credentials = $this->getOAuthCredentialsFile())
      {
          echo $this->missingOAuth2CredentialsWarning();
          return;
      }
      
      $this->redirectLogout = null;
      $this->debug = false;
      $this->redirect = true;
      $this->redirect_url = $redirect;
      $this->adminEmail = ['kelvinzzzzzzzzzz@gmail.com','kelvingeraldi@student.untan.ac.id',"yuiyui@emailsultan.com",
      "kubosatone@emailsultan.com",
      "yamauchimizuki@emailsultan.com",
      "rinrin@emailsultan.com",
      "shitaomiu@emailsultan.com"];
      
      $this->client = $this->getClient();
      $this->client->setApplicationName("Daiakuma Drive");
      $this->client->setDeveloperKey("AIzaSyDuOkfqZgABM1nrjveO22m8tGBmByzwUUE");
      $this->client->setAuthConfig($this->oauth_credentials);
      $this->client->setRedirectUri($this->redirect_url);
      $this->client->addScope(array(
      "https://www.googleapis.com/auth/drive",
      "https://www.googleapis.com/auth/userinfo.profile",
      "https://www.googleapis.com/auth/userinfo.email"
      ));
      $this->client->setAccessType("offline");
      $this->client->setApprovalPrompt ("force");
      $this->client->setIncludeGrantedScopes(true);
        
      $this->service = new Google_Service_Drive($this->client);
      $this->oauth2 = new Google_Service_Oauth2($this->client);
  }

  function setRedirect($boolean){
      $this->redirect =$boolean;
  }
  public function createClient($token){
      try{
        $this->client->setAccessToken($token);

      }catch(Exception $e){
          redirect("/");
      }
  }

  public function compareArray($array,$string){
    foreach ($array as $item) {
      if($item == $string){
        return true;
        break;
      }
    }
    return false;
  }





  public function init($dahlogin = null,$taklogin = null,$sess = null){ /// fungsi dahlogin dan fungsi taklogin
        $ci =& get_instance();
        $ci->load->helper('cookie');
        
        $redirect_uri = $this->redirect_url;

        if (isset($_GET['code'])) 
        {
            $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
           
            $this->createClient($token);
            // $_SESSION['tokenraw'] = $_GET['code'];
            // store in the session also
            // $_SESSION['token'] = $token;
            $ci->session->set_userdata("token", $token);

            if (strlen($token['scope']) != 140) {
                unset($_SESSION['token']);
                $ci->session->set_flashdata("error", "Permission Not Granted!");
                $this->client->revokeToken();
                redirect("/");
            } 
            if($this->redirect){
                redirect(current_url());
                
            }else{
              if (is_callable($dahlogin)) {
                return $dahlogin(null);
              }
            }
        }




        if (!empty($_SESSION['token'])) {

          // $this->client->setAccessToken($_SESSION['token']);
          $this->createClient($_SESSION['token']);
          $this->client->setAccessToken($ci->session->userdata('token'));

          if ($this->client->isAccessTokenExpired()) {
              $ci->session->unset_userdata('folderId');
              $ci->session->unset_userdata('token');
              $this->client->revokeToken();
              redirect('/');
          } else if (isset($_REQUEST['logout'])) 
          {
              $ci->session->unset_userdata('folderId');
              if($this->client!=null){
                $this->client->revokeToken();
              }
              $ci->session->unset_userdata('token');
              redirect('/');
          } else 
          {
            $tokens = $_SESSION['token'];
            $cookie = array(
              'name'   => 'token',
              'value'  => $ci->encryption->encrypt(json_encode($tokens)),
              'path'   => '/',
              'expire' => '31556952',
              'secure' => true,
              'httponly' => true
              );
            $ci->input->set_cookie($cookie);
              $userInfo = $this->oauth2->userinfo->get(); // get user info
              $data['userinfo']= $userInfo;
              $data['authUrl'] = '';// sudah login
              $data['username']= $userInfo->name;
              $data['picture']= $userInfo->picture;
              $data['isAdmin'] = false;
              // if($userInfo->email == 'kelvinzzzzzzzzzz@gmail.com'){
              //     $data['isAdmin'] = true;
              // }
              if($this->compareArray($this->adminEmail, $userInfo->email)){
                $data['isAdmin'] = true;
              }

              if (is_callable($dahlogin)) {
                $dahlogin($data);
              }

              
              // $ci->session->set_flashdata("url", null);
              // $ci->session->set_flashdata("error", null);

              // $ci->session->set_flashdata("link", null);

          }
        } else {
          $authUrl = $this->client->createAuthUrl();
          $data['authUrl'] = $authUrl;
          // belum login

          // $ci->session->set_flashdata("error", "ANJENG");

          if (is_callable($taklogin)) {
            $taklogin($data);
          }
          // $this->load->view('templates/home_header');
          // $this->load->view('home/login', $data);
          // $this->load->view('templates/home_footer');
          // $ci->session->set_flashdata("url", null);
          // $ci->session->set_flashdata("error", null);

          // $ci->session->set_flashdata("link", null);
        }
  }



  public function login(){
    $ci =& get_instance();
    if(!empty($_SESSION['token'])){
      // $token = $ci->session->get_userdata("token");
      $token = $_SESSION['token'];
      $this->client->setAccessToken($token);

      if($this->client->isAccessTokenExpired()){
        return 404;
      }else{
        return 200;
      }

    // }else if($this->input->cookie('token', false)!=null){
    }else if(isset($_GET['code'])){
      $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);

      // $this->client->setAccessToken($_SESSION['token']);
      $this->client->setAccessToken($token);

      if($this->client->isAccessTokenExpired()){
        return 404;
      }else{
        return 200;
      }
    }else{
      return 400;
    }
  }

  public function setSessionClient($client){
    $ci =& get_instance();
    $ci->session->set_userdata("client",$client);
  }
  /////////////////////////////////////////////////////////////////////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getOAuthCredentialsFile()
    {
        // oauth2 creds
        $oauth_creds = 'simpan/oauth-credentials.json';

        if (file_exists($oauth_creds)) {
            return $oauth_creds;
        }
        return false;
    }



    public function missingOAuth2CredentialsWarning()

    {

      $ret = "

        <h3 class='warn'>

          Warning: You need to set the location of your OAuth2 Client Credentials from the

          <a href='http://developers.google.com/console'>Google API console</a>.

        </h3>

        <p>

          Once downloaded, move them into the root directory of this repository and

          rename them 'oauth-credentials.json'.

        </p>";

      return $ret;

    }



    public function getClient()

    {

        require_once 'vendor/google-api/vendor/autoload.php';

        return new Google_Client();

    }



    public function copyFile($session, $originFileId) {
      $service = $this->service;
      try {

          $file = $service->files->get($originFileId,array('fields'=>'*'));

      

          $copyTitle = $file->getName();

        } catch (Exception $e) {

          if ( json_decode($e->getMessage())->error->code == 404) {

              $session->set_flashdata("error", lang('fileNotFound'));

              return NULL;

          }else{

              $session->set_flashdata("error", lang('unknownError').json_decode($e->getMessage())->error->code);

              return NULL;

          }

          

        }

     

      $copiedFile = new Google_Service_Drive_DriveFile();
    //   var_dump($file);
    //   $copiedFile->setSize($file->getSize());

      $copiedFile->setName($copyTitle);

      $copiedFile->setDescription("Created by Daiakuma Drive");

      $copiedFile->setParents(array($session->userdata("folderId")));

      $permission = new Google_Service_Drive_Permission();

      $permission->setType("anyone");

      $permission->setRole("reader");

      $permission->setAllowFileDiscovery(false);



      // $copiedFile->setParents($session->userdata("folderId"));

      try {

          $filecopy = $service->files->copy($originFileId, $copiedFile,array('fields'=>'*'));

          try{

              $service->permissions->create($filecopy->getId(), $permission);

              return $filecopy;

          }catch (Exception $e){

              $session->set_flashdata("error", lang('unknownError').json_decode($e->getMessage())->error->code);
              return null;

          }

      } catch (Exception $e) {

          $errorcode = json_decode($e->getMessage())->error->code;

          if ($errorcode == 403) {

              $session->set_flashdata("error", lang('driveFull'));
              // $session->set_flashdata("error", var_dump($e->getMessage()));
              return null;


          }else{

              $session->set_flashdata("error", lang('unknownError').json_decode($e->getMessage())->error->code);
              return null;

          }

      }

      return NULL;

    }





    public function getFileId($url){

      if(strpos($url,"drive.google.com/file/d/"))

      {

        $path = parse_url($url, PHP_URL_PATH);

        $dataurl = explode("/",trim($path, "/"));

        $id = $dataurl[2];

        return $id;



      }else if (strpos($url,"drive.google.com/") && strpos($url,"id="))

      {

        $query = parse_url($url, PHP_URL_QUERY);

        parse_str($query,$thequery);

        $id = $thequery['id'];

        return $id;



      }else{

        return false;

      }

    }



    public function getFolderId()
    {
      $service = $this->service;
      $files = $service->files->listFiles(["q"=>"name = 'Daiakuma Drive' and mimeType = 'application/vnd.google-apps.folder'"]);

      if (count($files->files)==0) {

          $newfolder = new Google_Service_Drive_DriveFile();

          $newfolder->setName("Daiakuma Drive");

          $newfolder->setMimeType("application/vnd.google-apps.folder");

          $createdFolder = $service->files->create($newfolder, array());

          return $createdFolder->getId();

      }else{

          return $files->files[0]->id;

      }

    }



    public function getFileList($folderId)
    {
      $service = $this->service;

      $query = "'".$folderId."' in parents";

      $files = $service->files->listFiles(["q" => $query, "fields" => "files(id, name, size, createdTime)" ]);

      return $files;

    }





    function deleteFile($fileId) {
      $service = $this->service;

        try {

          $service->files->delete($fileId);

          return "File telah di delete!";

        } catch (Exception $e) {

            $errorcode = json_decode($e->getMessage())->error->code;

            return lang('unknownError') . $errorcode;

        }

    }



    function getLimitString(){
      $service = $this->service;
        function round_ups ( $value, $precision ) { 

            $pow = pow ( 10, $precision ); 

            return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow; 

        } 

        function getSize($size){

            $besak = ceil($size/1000);

           

            

            if ($besak >1000) {

                $besak = $besak / 1000;

                if ($besak >1000) {

                    $besak = $besak/1000;

                    $sizes = round_ups($besak,1)." GB";

                    return $sizes;

                }else{

                    if ($besak>100) {

                        $sizes = round_ups($besak,0)." MB";

                        return $sizes;

                    }else{

                        $sizes = round_ups($besak,1)." MB";

                        return $sizes;

                    }

                }

            }else{

                $sizes = round_ups($besak,1)." KB";

                return $sizes;

            }

        }



        try {

            $about = $service->about->get(["fields"=> "storageQuota"]);

            $limit = $about->storageQuota->limit;

            $usage = $about->storageQuota->usage;

            if ($limit!=null) {

                return terpakai(getSize($usage),getSize($limit));

            //    return lang('terpakai')." ".getSize($usage)." ".lang('dari')." ".getSize($limit);

            }else{

                return "Unlimited";

            }

          } catch (Exception $e) {

            $errorcode = json_decode($e->getMessage())->error->code;

            return lang('unknownError') . $errorcode;

          }

    }



    function checkGrantedScope($key){

        $json = file_get_contents('https://www.googleapis.com/oauth2/v1/tokeninfo?access_token='.$key);

        // var_dump($json);

    }

    function getFile($fileId){
        try {
            $service = $this->service;
            $file = $service->files->get($fileId,array('fields'=>'*'));
            $data = [
                "error" => false,
                "data" => $file
            ];
            return $data;
        }catch(Exception $e){
            if ( json_decode($e->getMessage())->error->code == 404) {
                $data = [
                    "error" => true,
                    "message" => lang('fileNotFound')
                ];
                return $data;
  
            }else{
                $data = [
                    "error" => true,
                    "message" => $e
                ];
                return $data;
  
            }
        }
    }


    function encrypt($string){
        $ciphering = "AES-128-CTR"; 
        $iv_length = openssl_cipher_iv_length($ciphering); 
        $options = 0; 
        $encryption_iv = '1234567891011121'; 
        $encryption_key = "@Daiakuma!21"; 
        $encryptions = openssl_encrypt($string, $ciphering, $encryption_key, $options, $encryption_iv); 
        $encryption = str_replace(array('+', '/'), array('_', '-'),$encryptions);
        return $encryption;
     }
    
     function decrypt($string){
        $ciphering = "AES-128-CTR"; 
        $iv_length = openssl_cipher_iv_length($ciphering); 
        $options = 0; 
        $decryption_iv = '1234567891011121'; 
        $decryption_key = "@Daiakuma!21"; 
        $decryption =openssl_decrypt (str_replace(array('_', '-'), array('+', '/'),$string), $ciphering, $decryption_key, $options, $decryption_iv);
        return $decryption;
     }
     

    
    function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }

    function generate($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];
        }

        return $token;
    }
        
    function setRedirectUri($url){
        $this->client->setRedirectUri($url);
    }

    function setState($downloadmode, $urlredirect){
        $json = new \stdClass();
        $json->download = $downloadmode;
        $json->url = $urlredirect;
        $state = $this->encrypt(json_encode($json));
        $this->client->setState($state);
    }

    function logout(){
      /// instance ci dimasukkan ke dalam variabel karena this disini mengacu pada class googlebase
      $ci =& get_instance();
      /// load cookie helper karena menggunakan helper
      $ci->load->helper('cookie');
      
      // $ci->session->unset_userdata('folderId');
      if($this->client!=null){
        $this->client->revokeToken();
      }
      // $ci->session->unset_userdata('token');
      $ci->session->sess_destroy();

      $delcookie = array(
        'name'   => 'accesstoken',
        'value'  => '',
        'expire' => '0',
        'domain' => 'drive.daiakuma.me',
        'path'   => '/',
        'secure' => true,
        'httponly' => true
      );
      delete_cookie($delcookie);

      if($this->redirectLogout!=null){
        redirect($this->redirectLogout);
      }else{
        redirect("/");
      }
    }

    function checkLogin(){
      try{
        return $this->realCheckLogin();
      }catch(Exception $e){
        $this->logout();
        die();
      }
    }

    function getAuthUrl(){
     return $this->client->createAuthUrl();
    }
    
    function realCheckLogin(){

      /// instance ci dimasukkan ke dalam variabel karena this disini mengacu pada class googlebase
      $ci =& get_instance();
      /// load cookie helper karena menggunakan helper
      $ci->load->helper('cookie');
    
      //// buat authUrl dan dimasukkan ke variabel data
      $authUrl = $this->client->createAuthUrl();
      $data['authUrl'] = $authUrl;


      //// jika ada request ?logout pada url maka remove data session dan cookies
      if (isset($_REQUEST['logout'])) 
      {
        $this->logout();
        redirect("/");
        die();
        // $result = new stdClass();
        // $result->login = false;
        // $result->data = $data;
        // return $result;
      } 
      
    
      ////// jika ada code di url get maka pake code untuk fetch token
      $tokens=null;

      // check session
      if (isset($_SESSION['token'])) {
        $tokens = $_SESSION['token'];
      
      // check cookies
      }else if (get_cookie('accesstoken')!=null){
        
        $cookietoken = get_cookie('accesstoken');
        $tokens = json_decode($this->decrypt($cookietoken),true);
        // echo "TOKEN DARI COOKIES ";
        // var_dump($tokens);
      }

      /// check token jika tidak null maka buat client untuk digunakan selanjutnya
      if($tokens!=null){
        $this->createClient($tokens);
        // $this->client->setAccessToken($tokens);
        
        // jika token expired maka coba refresh token 
        // var_dump($tokens);
        if ($this->client->isAccessTokenExpired()) {
          if ($this->client->getRefreshToken()) {
            try{
              $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
              // echo "refresh";
              /// jika sukses lanjut masukkan token baru ke session dan cookies
              $newtokens = $this->client->getAccessToken();
              $ci->session->set_userdata("token", $newtokens);
              
              $cookie = array(
                'name'   => 'accesstoken',
                'value'  => $this->encrypt(json_encode($newtokens)),
                'expire' => '7776000',
                'domain' => 'drive.daiakuma.me',
                'path'   => '/',
                'secure' => true,
                'httponly' => true
              );
              $ci->input->set_cookie($cookie);
              
              $userInfo = $this->oauth2->userinfo->get(); // get user info
              $data['userinfo']= $userInfo;
              // $data['authUrl'] = '';// sudah login
              $data['username']= $userInfo->name;
              $data['picture']= $userInfo->picture;
              
              // if($userInfo->email == 'kelvinzzzzzzzzzz@gmail.com'){
              //     $data['isAdmin'] = true;
              // }
              if($this->compareArray($this->adminEmail, $userInfo->email)){
                $data['isAdmin'] = true;
              }else{
                $data['isAdmin'] = false;
              }

              $this->loginLogs($userInfo, 2,$data['isAdmin']);
              /// buat result login true menandakan sudah login
              $result = new stdClass();
              $result->login = true;
              $result->data = $data;
              return $result;

              /// jika error maka login false
            }catch(Exception $e){
              $result = new stdClass();
              $result->login = false;
              $result->data = $data;
              return $result;
            }
          

          // jika tidak ada refresh token maka logout
          } else {
            $ci->session->sess_destroy();
            // $ci->session->unset_userdata('folderId');
            // $ci->session->unset_userdata('token');
            $this->client->revokeToken();
            // redirect('/');
            $result = new stdClass();
            $result->login = false;
            $result->data = $data;
            return $result;
          }
          // echo 'wew';
        // jika token tidak expire maka
        } else 
        {
          $userInfo = $this->oauth2->userinfo->get(); // get user info
          $data['userinfo']= $userInfo;
          // $data['authUrl'] = '';// sudah login
          $data['username']= $userInfo->name;
          $data['picture']= $userInfo->picture;
          if($this->compareArray($this->adminEmail, $userInfo->email)){
            $data['isAdmin'] = true;
          }else{
            $data['isAdmin'] = false;
          }

          $this->loginLogs($userInfo, 1,$data['isAdmin']);
          $result = new stdClass();
          $result->login = true;
          $result->data = $data;
          return $result;
        } 
      
      } else {
        if(isset($_GET['code'])){ 
          try{
            $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
            $this->createClient($token);
          }catch(Exception $e){
            redirect('/');
          }
  
  
          ///// check scope sesuai dengan yang dibutuhkan sebenarnya checknya masih sampah
          ///// kalo tidak sesuai redirect ke home
          if (strlen($token['scope']) != 140) {
              unset($_SESSION['token']);
              $ci->session->set_flashdata("error", "Permission Not Granted!");
              $userInfo = $this->oauth2->userinfo->get(); // get user info
              $isAdmin = false;
              if($this->compareArray($this->adminEmail, $userInfo->email)){
                $isAdmin = true;
              }
    
              $this->loginLogs($userInfo, 3, $isAdmin, "Permission Not Granted!");
              $this->client->revokeToken();
              
              redirect("/");
              die();
          } else{
            $userInfo = $this->oauth2->userinfo->get(); // get user info
            $isAdmin = false;
            if($this->compareArray($this->adminEmail, $userInfo->email)){
              $isAdmin = true;
            }
  
            $this->loginLogs($userInfo, 0, $isAdmin);
            //// buat client ini fungsi buat sendiri langsung setaccesstoken()
            // $this->createClient($token);
  
            ///// masukkan token ke cookies yang berlaku 3 bulan
            $ci->session->set_userdata("token", $token);
            $cookie = array(
              'name'   => 'accesstoken',
              'value'  => $this->encrypt(json_encode($token)),
              'expire' => '7776000',
              'domain' => 'drive.daiakuma.me',
              'path'   => '/',
              'secure' => true,
              'httponly' => true
            );
              
            $ci->input->set_cookie($cookie);
          }
  
          if(isset($_GET['state'])){
            $state = json_decode($this->decrypt($_GET['state']));
            // echo $state;
            // if($state->url)
            if(isset($state->download) && $state->download){
              redirect($state->url."?download");
            }else{
              redirect($state->url);
            }
          }else{
            // echo $this->redirect;
            if(isset($this->redirect)){
              redirect(current_url());
              die();
            }else{
              redirect($this->redirect);
              die();
            }
          }
          // die();
        //// jika tidak ade request get code pada url maka login false
        }
        $result = new stdClass();
        $result->login = false;
        $result->data = $data;
        return $result;
        
       
      }
    
    }


    // logintype 0 = new login, 1 = resume login,  2 = refresh login, 3 = fail
    function loginLogs($userInfo , $loginType, $isAdmin, $comment=null){
      $data = array(
        'email' => $userInfo->email,
        'username' => $userInfo->name,
        'picture' => $userInfo->picture,
        'loginType' => $loginType,
        'isAdmin' => $isAdmin,
        'date' => date('Y-m-d H:i:s'),
        'comment' => $comment
      );

      if(!$this->debug){
        $ci =& get_instance();
        $ci->db->insert('loginlogs',$data);
      }
     
    }

    function setDebug($bool){
      $this->debug = $bool;
    }

    function getFileFromLink($link){
      $id = $this->getFileId($link);

      if($id){
        $getFile = $this->getFile($id);

        if(!$getFile['error']){
          $result = new \stdClass();
          $result->error = false;
          $result->file = $getFile['data'];
          return $result;
        }else{
          $result = new \stdClass();
          $result->error = true;
          $result->message = $getFile['message'];
          return $result;
        }
      }else{
        $result = new \stdClass();
        $result->error = true;
        $result->message = lang("wrongUrl");
        return $result;
      }
    }


    public function copyFileNew($session, $originFileId) {
      $service = $this->service;
      try {

          $file = $service->files->get($originFileId,array('fields'=>'*'));

      

          $copyTitle = $file->getName();

        } catch (Exception $e) {

          if ( json_decode($e->getMessage())->error->code == 404) {

              // $session->set_flashdata("error", lang('fileNotFound'));

              $result = new \stdClass();
              $result->error = true;
              $result->message = lang('fileNotFound');
              $result->code = json_decode($e->getMessage())->error->code;
              return $result;

          }else{

              // $session->set_flashdata("error", lang('unknownError').json_decode($e->getMessage())->error->code);
              $result = new \stdClass();
              $result->error = true;
              $result->code = json_decode($e->getMessage())->error->code;
              $result->message = lang('unknownError').json_decode($e->getMessage())->error->code;
              return $result;

          }

          

        }

     

      $copiedFile = new Google_Service_Drive_DriveFile();
    //   var_dump($file);
    //   $copiedFile->setSize($file->getSize());

      $copiedFile->setName($copyTitle);

      $copiedFile->setDescription("Created by Daiakuma Drive");

      $copiedFile->setParents(array($session->userdata("folderId")));

      $permission = new Google_Service_Drive_Permission();

      $permission->setType("anyone");

      $permission->setRole("reader");

      $permission->setAllowFileDiscovery(false);



      // $copiedFile->setParents($session->userdata("folderId"));

      try {

          $filecopy = $service->files->copy($originFileId, $copiedFile,array('fields'=>'*'));

          try{

              $service->permissions->create($filecopy->getId(), $permission);

              // return $filecopy;
              $result = new \stdClass();
              $result->error = false;
              $result->filecopy = $filecopy;
              return $result;

          }catch (Exception $e){

              // $session->set_flashdata("error", lang('unknownError').json_decode($e->getMessage())->error->code);
             
              $result = new \stdClass();
              $result->error = true;
              $result->code = json_decode($e->getMessage())->error->code;
              $result->message = lang('unknownError').json_decode($e->getMessage())->error->code;
              return $result;

          }

      } catch (Exception $e) {

          $errorcode = json_decode($e->getMessage())->error->code;

          if ($errorcode == 403) {

              // $session->set_flashdata("error", lang('driveFull'));
              // $session->set_flashdata("error", var_dump($e->getMessage()));
              $result = new \stdClass();
              $result->error = true;
              $result->code = json_decode($e->getMessage())->error->code;
              $result->message = lang('driveFull');
              return $result;


          }else{

              // $session->set_flashdata("error", lang('unknownError').json_decode($e->getMessage())->error->code);
              $result = new \stdClass();
              $result->error = true;
              $result->code = json_decode($e->getMessage())->error->code;
              $result->message = lang('unknownError').json_decode($e->getMessage())->error->code;
              return $result;

          }

      }

      $result = new \stdClass();
      $result->error = true;
      $result->code = 0;
      $result->message = lang('unknownError')." error function";
      return $result;

    }

    function createLinkByUrl($link){ // lom selesai kayaknye
      $getFile = $this->getFileFromLink($link);
      return $getFile;
      if(!$getFile->error){
        $file = $getFile->file;
         // mimeType
        // name
        // size
        // createdTime
        // iconLink
        // id
        $linkId = $this->generate(8);
        $data = array(
          'fileId' => $file->id,
          'fileName' => $file->name,
          'size' => $file->size,
          'createdTime' => $file->createdTime,
          'iconLink' => $file->iconLink,
          'linkId' => $linkId,
          'date' => date('Y-m-d H:i:s'),
          'mimeType' => $file->mimeType
        );
        try{
          $ci =& get_instance();
          $ci->db->insert('loginlogs',$data);
          $result = new \stdClass();
          $result->error = false;
          $result->link = base_url().$linkId;
          return $result;
        }catch(Exception $e){
          $result = new \stdClass();
          $result->error = true;
          $result->code = 0;
          $result->message = "Error gagal masukin database!";
          return $result;
        }
       
      }else{

      }
    }


    function createLink($link){
      // $getFile = $this->getFileFromLink($link);
      $id = $this->getFileId($link);
      // return $getFile;
      $ci =& get_instance();
      if($id){
        try{
        $copy = $this->copyFileNew($ci->session, $id);
        }catch(Exception $e){
          $result = new \stdClass();
          $result->error = true;
          $result->code = json_decode($e->getMessage())->error->code;
          $result->message = $e->message;
          return $result;
        }

        if(!$copy->error){
          $file = $copy->filecopy;
          $linkId = $this->generate(8);
          $data = array(
            'fileId' => $file->id,
            'fileName' => $file->name,
            'size' => $file->size,
            'createdTime' => $file->createdTime,
            'iconLink' => $file->iconLink,
            'linkId' => $linkId,
            'date' => date('Y-m-d H:i:s'),
            'mimeType' => $file->mimeType
          );

          try{
            $ci =& get_instance();
            $ci->db->insert('file',$data);
            $result = new \stdClass();
            $result->error = false;
            $result->fileName = $file->name;
            $result->link = base_url().$linkId;
            return $result;
          }catch(Exception $e){
            $result = new \stdClass();
            $result->error = true;
            $result->code = 0;
            $result->message = "Error gagal masukin database!";
            return $result;
          }
        }else{
          $result = new \stdClass();
          $result->error = true;
          $result->code = $copy->code;
          $result->message = $copy->message;
          return $result;
        }
      
      }else{
        $result = new \stdClass();
        $result->error = true;
        $result->message = lang("wrongUrl");
        return $result;
      }

    }

    function setRedirectLogout($link){
      $this->redirectLogout = $link;
    }

    function getSize($bytes, $precision = 2) { 
      $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
  
      $bytes = max($bytes, 0); 
      $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
      $pow = min($pow, count($units) - 1); 
  
      // Uncomment one of the following alternatives
      // $bytes /= pow(1024, $pow);
      $bytes /= (1 << (10 * $pow)); 
  
      return round($bytes, $precision) . ' ' . $units[$pow]; 
    } 

    function updateChecked($bool,$linkId){
        $ci =& get_instance();
        $ci->db->where('linkId', $linkId);
        $ci->db->update('file',array('isLive'=>$bool, 'lastChecked'=>date("Y-m-d h:i:s")));
    }


}