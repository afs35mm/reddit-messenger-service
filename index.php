<?php

define('__ROOT__', dirname(__FILE__)); 

require_once (__ROOT__ . '/db.class.php');
require_once (__ROOT__ . '/RedditConnect.class.php');

require_once (__ROOT__ . '/config.class.php');

$config = new Config();

// config sets all passwords, and should not be committed 
require_once (__ROOT__ . '/config.php'); 

// Connect to DB to find stored token 
$db = new DB('localhost:3306', 'root', 'root', 'reddit_messenger');
$token = $db->read_token();

$reddit_username = Config::get('reddit_username');
$reddit_password = Config::get('reddit_password');
$client_id       = Config::get('client_id');
$client_secret   = Config::get('client_secret');

// Connect to reddit API
$reddit_conn = new RedditConnect($reddit_username, $reddit_password, $client_id, $client_secret);
$myinfo_json = $reddit_conn->get_my_info($token);

$myinfo = json_decode($myinfo_json);

if (array_key_exists('error', $myinfo)) {
    //echo 'error';
    $reddit_token = $reddit_conn->get_token();
    $new_reddit_token = json_decode($reddit_token)->{'access_token'};
    
    // write new token to db
    $db->write_token($new_reddit_token);

    // and use that token above to get the jsob from reddit obj
    $myinfo_json = $reddit_conn->get_my_info($new_reddit_token);
    print_r(json_decode($myinfo_json));
} else  {
    //echo 'werks';
    $db->conn->close();
    print_r($myinfo);
}


