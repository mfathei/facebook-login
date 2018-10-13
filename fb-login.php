<?php

require_once __DIR__ . '/vendor/autoload.php';
session_start();

$fb = new Facebook\Facebook(
    [
    'app_id' => '239835103554248',
    'app_secret' => '46ef0ce252cbaf53912e9a33ea19784b',
    'defaul_graph_version' => 'v2.10',
    // 'default_access_token' => {access_token}
    ]
);

$helper = $fb->getRedirectLoginHelper();
$login_url = $helper->getLoginUrl('http://localhost:8989/');

// print_r($login_url);

try {
    $accessToken = $helper->getAccessToken();
    if (isset($accessToken)) {
        $_SESSION['access_token'] = (string)$accessToken;

        // Redirect if login success
        header('location: index.php');
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

// Get user data username, email and lastname
try {
    if (isset($_SESSION['access_token'])) {
        $fb->setDefaultAccessToken($_SESSION['access_token']);
        $res = $fb->get('/me?locale=en_US&fields=email,name');
        $user = $res->getGraphUser();
        echo $user->getField('name');
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
