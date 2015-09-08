<?php
ini_set('display_errors', 1);
require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "141488104-TdZGwXMgGBSHVHeLor2k6jpsii67XaGM56h5OoeA",
    'oauth_access_token_secret' => "8UuEj5CaQfBI2nhA4sxfgH6QF89gZJaNkQeWswSYbzNyY",
    'consumer_key' => "AJk0vlZ69oNmPuL8MjVYIzekq",
    'consumer_secret' => "NNesDHpOJoWtNQ5Qj2GNGQSF0zZjwCi3R1PYMPyfnSje2exGhV"
);

/** URL for REST request, see: https://dev.twitter.com/docs/api/1.1/ **/
$url = 'https://api.twitter.com/1.1/blocks/create.json';
$requestMethod = 'POST';

/** POST fields required by the URL above. See relevant docs as above **/
$postfields = array(
    'screen_name' => 'usernameToBlock', 
    'skip_status' => '1'
);

/** Perform a POST request and echo the response **/
$twitter = new TwitterAPIExchange($settings);
echo $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest();

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfield = '?count=5&exclude_replies=1&user_id=TechCrunch&screen_name=TechCrunch';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
echo $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();