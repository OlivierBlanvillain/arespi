<?

// arespiwebsitearespiwebsite
// arespiwebsitearespiwebsite

require_once "google-api-php-client/autoload.php";

// https://developers.google.com/admin-sdk/directory/v1/guides/authorizing
$groupScope = "https://www.googleapis.com/auth/admin.directory.group
";


// https://developers.google.com/api-client-library/php/auth/service-accounts#authorizingrequests
$clientEmail = "834497997783-bd9ob1q5fmqgmifrhbqsroum9vn8i55o@developer.gserviceaccount.com";
// $clientEmail = "188015446997-8h4hmqrit90tadoks1trk19pair6gmm8@developer.gserviceaccount.com";
// $privateKey = file_get_contents("arespi-2464555a3bba.p12");
$privateKey = file_get_contents("client_secrets.p12");
$scopes = array($groupScope);
$credentials = new Google_Auth_AssertionCredentials($clientEmail, $scopes, $privateKey);

$client = new Google_Client();
$client->setAssertionCredentials($credentials);
if ($client->getAuth()->isAccessTokenExpired()) {
  $client->getAuth()->refreshTokenWithAssertion();
}

// https://github.com/google/google-api-php-client/blob/master/src/Google/Service/Directory.php
$service = new Google_Service_Directory($client);
// $optParams = array('filter' => 'free-ebooks');


$group = new Google_Service_Directory_Group();
$group->setDescription("The Arespi Forum.");
$group->setEmail("arespi_forum@example.com");
$group->setName("Arespi Forum");
$results = $service->groups->insert($group);

echo $results;

// $results = $service->members->listMembers("arespi@googlegroups.com");

// foreach ($results as $item) {
//   echo $item, "<br /> \n";
// }

// Google_Service_Directory_Members_Resource
// listMembers($groupKey, $optParams = array())

// session_start();

// $client = new Google_Client();
// $client->setAuthConfigFile("client_secrets.json");
// $client->setRedirectUri("http://" . $_SERVER["HTTP_HOST"] . "/oauth2callback.php");
// $client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);

// if (! isset($_GET["code"])) {
//   $auth_url = $client->createAuthUrl();
//   header("Location: " . filter_var($auth_url, FILTER_SANITIZE_URL));
// } else {
//   $client->authenticate($_GET["code"]);
//   $_SESSION["access_token"] = $client->getAccessToken();
//   $redirect_uri = "http://" . $_SERVER["HTTP_HOST"] . "/";
//   header("Location: " . filter_var($redirect_uri, FILTER_SANITIZE_URL));
// }

// $curl = curl_init();
// curl_setopt($curl, CURLOPT_URL, "example.com");
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// $output = curl_exec($curl);
// curl_close($curl);

// echo $output

?>


