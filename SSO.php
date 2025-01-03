<?php
require_once 'vendor/autoload.php';
 
$client = new Google_Client();
$client->setClientId('CLIENTID');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/google_signin.php');
$client->addScope('email');
 
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);
 
    $oauth2 = new Google_Service_Oauth2($client);
    $userinfo = $oauth2->userinfo->get();
 
    $email = $userinfo->email;
    $emailDomain = explode('@', $email)[1];
 
    if ($emailDomain === 'stu.ssc.edu.hk') {
        // User is authorized, do something with the email
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Google Sign-In Website</title>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f2f2f2;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .container {
                    background-color: white;
                    padding: 20px;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>Welcome, " . $email . "!</h2>
                <p>You have successfully signed in.</p>
            </div>
        </body>
        </html>";
    } else {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Google Sign-In Website</title>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f2f2f2;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .container {
                    background-color: white;
                    padding: 20px;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>Access Denied</h2>
                <p>Sorry, you are not authorized to access this website. Only users using SSC School google accounts are allowed.</p>
            </div>
        </body>
        </html>";
    }
} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . $authUrl);
    exit;
}
?>
