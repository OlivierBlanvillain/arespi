<?
// arespiwebsite
// arespiwebsitearespiwebsite

// List of google groups members:
// https://docs.google.com/spreadsheets/d/1NPSvH2itaTkOpEYHRoTYoZdgoEKiGFOtWsrTOinr3vg/export?format=csv

$rooturl = 'http://localhost:80';

// Show errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Include two files from google-php-client library in controller
require_once "./google-api-php-client/src/Google/Client.php";
require_once "./google-api-php-client/src/Google/Service/Oauth2.php";

// Store values in variables from project created in Google Developer Console
$client_id = '834497997783-7l4hdqqbjc79phkrl9s1k1ra7h032poc.apps.googleusercontent.com';
$client_secret = 'W0M4bsbKxmIYfBethxy52mzp';
$redirect_uri = $rooturl . '/authentication.php';
$simple_api_key = 'AIzaSyBUK5qxC5DULFTHej2xRfGhoJDX7QbeYLc';

// Create Client Request to access Google API
$client = new Google_Client();
$client->setApplicationName("PHP Google OAuth Login Example");
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setDeveloperKey($simple_api_key);
$client->addScope("https://www.googleapis.com/auth/userinfo.email");

// Send Client Request
$objOAuthService = new Google_Service_Oauth2($client);

// Add Access Token to Session
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

// Set Access Token to make Request
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
}

// Get User Data from Google and store them in $data
if ($client->getAccessToken()) {
  $userData = $objOAuthService->userinfo->get();
  $data['userData'] = $userData; // TODO remove
  $_SESSION['access_token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
  $data['authUrl'] = $authUrl; // TODO remove
}

?>

<html>
  <head></head>
  <body>
    <? echo ".-" . $client->getAccessToken() . "-." ?>
    <? echo $client->getAccessToken() ?>
    <div id="main">
      <? if (isset($authUrl)) { ?>
        <h2>CodeIgniter Login With Google Oauth PHP</h2>
        <a href="<? echo $authUrl; ?>">Login</a>
      <? }else{ ?>
        <header id="info">
          <a target="_blank" class="user_name" href="<? echo $userData->link; ?>" /><img class="user_img" src="<? echo $userData->picture; ?>" width="15%" />
          <? echo '<p class="welcome"><i>Welcome ! </i>' . $userData->name . "</p>"; ?></a><a class='logout' href='https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=<? echo $rooturl ?>/logout.php'>Logout</a>
        </header>
      <?
      echo "<p class='profile'>Profile :-</p>";
      echo "<p><b> First Name : </b>" . $userData->given_name . "</p>";
      echo "<p><b> Last Name : </b>" . $userData->family_name . "</p>";
      echo "<p><b> Gender : </b>" . $userData->gender . "</p>";
      echo "<p><b>Email : </b>" . $userData->email . "</p>";
      ?>
      <? }?>
    </div>
  </body>
</html>
