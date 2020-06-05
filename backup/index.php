<?php
require_once 'google-api-php-client-2.4.0/vendor/autoload.php';


function copyFile($service, $originFileId, $copyTitle) {
  $copiedFile = new Google_Service_Drive_DriveFile();
  $copiedFile->setName($copyTitle);
  try {
    return $service->files->copy($originFileId, $copiedFile);
  } catch (Exception $e) {
    print '<div class="alert alert-danger" role="alert"> An error occurred: ' . $e->getMessage() . "</div>";
  }
  return NULL;
}




include 'header.php';
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
include_once "base.php";
echo pageHeader("Daiakuma Drive");
/*************************************************
 * Ensure you've downloaded your oauth credentials
 ************************************************/
if (!$oauth_credentials = getOAuthCredentialsFile()) {
  echo missingOAuth2CredentialsWarning();
  return;
}
/************************************************
 * The redirect URI is to the current page, e.g:
 * http://localhost:8080/simple-file-upload.php
 ************************************************/
$redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$client = new Google_Client();
$client->setAuthConfig($oauth_credentials);
$client->setRedirectUri($redirect_uri);
$client->addScope(array(
  "https://www.googleapis.com/auth/drive",
  "https://www.googleapis.com/auth/userinfo.profile",
  "https://www.googleapis.com/auth/userinfo.email"
));
$service = new Google_Service_Drive($client);
$oauth2 = new Google_Service_Oauth2($client);
// add "?logout" to the URL to remove a token from the session


if (!empty($_POST['url'])) {
  copyFile($service, $_POST['url'],"wew");
}


if (isset($_REQUEST['logout'])) {
  unset($_SESSION['upload_token']);
}
/************************************************
 * If we have a code back from the OAuth 2.0 flow,
 * we need to exchange that with the
 * Google_Client::fetchAccessTokenWithAuthCode()
 * function. We store the resultant access token
 * bundle in the session, and redirect to ourself.
 ************************************************/
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token);
 
  
  // store in the session also
  $_SESSION['upload_token'] = $token;
  // redirect back to the example
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
// set the access token as part of the client
if (!empty($_SESSION['upload_token'])) {
  $client->setAccessToken($_SESSION['upload_token']);
  $userInfo = $oauth2->userinfo->get(); // get user info
  if ($client->isAccessTokenExpired()) {
    unset($_SESSION['upload_token']);
  }
} else {
  $authUrl = $client->createAuthUrl();
}
/************************************************
 * If we're signed in then lets try to upload our
 * file. For larger files, see fileupload.php.
 ************************************************/
// if ($_SERVER['REQUEST_METHOD'] == 'POST' && $client->getAccessToken()) {
//   // We'll setup an empty 1MB file to upload.
//   DEFINE("TESTFILE", 'testfile-small.txt');
//   if (!file_exists(TESTFILE)) {
//     $fh = fopen(TESTFILE, 'w');
//     fseek($fh, 1024 * 1024);
//     fwrite($fh, "!", 1);
//     fclose($fh);
//   }
//   // This is uploading a file directly, with no metadata associated.
//   $file = new Google_Service_Drive_DriveFile();
//   $result = $service->files->create(
//       $file,
//       array(
//         'data' => file_get_contents(TESTFILE),
//         'mimeType' => 'application/octet-stream',
//         'uploadType' => 'media'
//       )
//   );
//   // Now lets try and send the metadata as well using multipart!
//   $file = new Google_Service_Drive_DriveFile();
//   $file->setName("Hello World!");
//   $result2 = $service->files->create(
//       $file,
//       array(
//         'data' => file_get_contents(TESTFILE),
//         'mimeType' => 'application/octet-stream',
//         'uploadType' => 'multipart'
//       )
//   );
// }
?>

<?php if (isset($authUrl)): ?>
  <div class="text-center">
    <?php 
  include "template/user_page.php";

  ?>
  </div>
<?php else: ?>
<?php 
include "template/user_page.php";

?>

  <!-- <form method="POST">
    <input type="submit" value="Click here to upload two small (1MB) test files" />
  </form> -->
<?php endif ?>
