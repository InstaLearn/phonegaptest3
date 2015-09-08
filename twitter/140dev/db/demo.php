
<html>
<head></head>
<body>
<?php

require_once('tweet_functions.php');

//echo store_user_tweets('FarOutAkhtar');
//echo delete_user('TechCrunch');

echo add_new_user('narendramodi', 50);

//echo update_tweets();
echo "compiled";

/* /**
* parse_tweets.php
* Populate the database with new tweet data from the json_cache table
* Latest copy of this code: http://140dev.com/free-twitter-api-source-code-library/
* @author Adam Green <140dev@gmail.com>
* @license GNU Public License
* @version BETA 0.30
*/


// require_once('TwitterAPIExchange.php');

// /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
// $settings = array(
    // 'oauth_access_token' => "141488104-TdZGwXMgGBSHVHeLor2k6jpsii67XaGM56h5OoeA",
    // 'oauth_access_token_secret' => "8UuEj5CaQfBI2nhA4sxfgH6QF89gZJaNkQeWswSYbzNyY",
    // 'consumer_key' => "AJk0vlZ69oNmPuL8MjVYIzekq",
    // 'consumer_secret' => "NNesDHpOJoWtNQ5Qj2GNGQSF0zZjwCi3R1PYMPyfnSje2exGhV"
// );


// //require_once('140dev_config.php');
// require_once('db_lib.php');
// $oDB = new db;

// $screenName = "FarOutAkhtar";
// $query = 'SELECT MAX(tweet_id) FROM tweets WHERE screen_name="'.$screenName.'" ';

// $MaxId_Result = $oDB->select($query);
// $MaxId = 0;

// while(($row = mysqli_fetch_array($MaxId_Result))){
	// $MaxId = $row['MAX(tweet_id)'];

// }
// //echo $MaxId;

// /** Perform a GET request and echo the response **/
// /** Note: Set the GET field BEFORE calling buildOauth(); **/
// $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';

// if($MaxId != 0 )
		// $getfield = '?exclude_replies=1&user_id='.$screenName.'&screen_name='.$screenName.'&since_id='.$MaxId.'&include_entities=true';
	// else 
		// $getfield = '?count=5&exclude_replies=1&user_id='.$screenName.'&screen_name='.$screenName.'&include_entities=true';

// //echo $url.$getfield;
// $requestMethod = 'GET';
// $twitter = new TwitterAPIExchange($settings);
// $twit_response_json =  $twitter->setGetfield($getfield)
             // ->buildOauth($url, $requestMethod)
             // ->performRequest();

	// $twit_response = json_decode($twit_response_json);
	// echo $twit_response_json;
	
	// foreach($twit_response as $tweet_object){
		// // Test the tweet_id before inserting
    // $tweet_id = $tweet_object->id_str;
    // if ($oDB->in_table('tweets','tweet_id=' . $tweet_id )) {continue;}
		
    // // Gather tweet data from the JSON object
    // // $oDB->escape() escapes ' and " characters, and blocks characters that
    // // could be used in a SQL injection attempt
   
		// if (isset($tweet_object->retweeted_status)) {
      // // This is a retweet
      // // Use the original tweet's entities, they are more complete
      // $entities = $tweet_object->retweeted_status->entities;
			// $is_rt = 1;
	  // } else {
	 	  // $entities = $tweet_object->entities;
		  // $is_rt = 0;
	  // }
		
		// $tweet_text = $oDB->escape($tweet_object->text);	
    // $created_at = $oDB->date($tweet_object->created_at);
    // if (isset($tweet_object->geo)) {
      // $geo_lat = $tweet_object->geo->coordinates[0];
      // $geo_long = $tweet_object->geo->coordinates[1];
    // } else {
      // $geo_lat = $geo_long = 0;
    // } 
    // $user_object = $tweet_object->user;
    // $user_id = $user_object->id_str;
    // $screen_name = $oDB->escape($user_object->screen_name);
    // $name = $oDB->escape($user_object->name);
    // $profile_image_url = $user_object->profile_image_url;

		
    // // Add a new user row or update an existing one
    // $field_values = 'screen_name = "' . $screen_name . '", ' .
      // 'profile_image_url = "' . $profile_image_url . '", ' .
      // 'user_id = ' . $user_id . ', ' .
      // 'name = "' . $name . '", ' .
      // 'location = "' . $oDB->escape($user_object->location) . '", ' . 
      // 'url = "' . $user_object->url . '", ' .
      // 'description = "' . $oDB->escape($user_object->description) . '", ' .
      // 'created_at = "' . $oDB->date($user_object->created_at) . '", ' .
      // 'followers_count = ' . $user_object->followers_count . ', ' .
      // 'friends_count = ' . $user_object->friends_count . ', ' .
      // 'statuses_count = ' . $user_object->statuses_count . ', ' . 
      // 'time_zone = "' . $user_object->time_zone . '", ' .
      // 'last_update = "' . $oDB->date($tweet_object->created_at) . '"' ;			

    // if ($oDB->in_table('users','user_id="' . $user_id . '"')) {
      // $oDB->update('users',$field_values,'user_id = "' .$user_id . '"');
    // } else {			
      // $oDB->insert('users',$field_values);
    // }
		
    // // Add the new tweet
	
    // $field_values = 'tweet_id = ' . $tweet_id . ', ' .
        // 'tweet_text = "' . $tweet_text . '", ' .
        // 'created_at = "' . $created_at . '", ' .
        // 'geo_lat = ' . $geo_lat . ', ' .
        // 'geo_long = ' . $geo_long . ', ' .
        // 'user_id = ' . $user_id . ', ' .				
        // 'screen_name = "' . $screen_name . '", ' .
        // 'name = "' . $name . '", ' .
        // 'profile_image_url = "' . $profile_image_url . '", ' .
        // 'is_rt = ' . $is_rt;
			
    // $oDB->insert('tweets',$field_values);
		
    // // The mentions, tags, and URLs from the entities object are also
    // // parsed into separate tables so they can be data mined later
    // foreach ($entities->user_mentions as $user_mention) {
		
      // $where = 'tweet_id=' . $tweet_id . ' ' .
        // 'AND source_user_id=' . $user_id . ' ' .
        // 'AND target_user_id=' . $user_mention->id;		
					 
      // if(! $oDB->in_table('tweet_mentions',$where)) {
			
        // $field_values = 'tweet_id=' . $tweet_id . ', ' .
        // 'source_user_id=' . $user_id . ', ' .
        // 'target_user_id=' . $user_mention->id;	
				
        // $oDB->insert('tweet_mentions',$field_values);
      // }
    // }
    // foreach ($entities->hashtags as $hashtag) {
			
      // $where = 'tweet_id=' . $tweet_id . ' ' .
        // 'AND tag="' . $hashtag->text . '"';		
					
      // if(! $oDB->in_table('tweet_tags',$where)) {
			
        // $field_values = 'tweet_id=' . $tweet_id . ', ' .
          // 'tag="' . $hashtag->text . '"';	
				
        // $oDB->insert('tweet_tags',$field_values);
      // }
    // }
    // foreach ($entities->urls as $url) {
		
      // if (empty($url->expanded_url)) {
        // $url = $url->url;
      // } else {
        // $url = $url->expanded_url;
      // }
			
      // $where = 'tweet_id=' . $tweet_id . ' ' .
        // 'AND url="' . $url . '"';		
					
      // if(! $oDB->in_table('tweet_urls',$where)) {
        // $field_values = 'tweet_id=' . $tweet_id . ', ' .
          // 'url="' . $url . '"';	
				
        // $oDB->insert('tweet_urls',$field_values);
      // }
    // }		
  // }
	
	
	
  // // Process all new tweets
  // //$query = 'SELECT cache_id, raw_tweet ' .
    // //'FROM json_cache';
  // //$result = $oDB->select($query);
  // /*
  // while($row = mysqli_fetch_assoc($result)) {
		
    // $cache_id = $row['cache_id'];
    // // Each JSON payload for a tweet from the API was stored in the database  
    // // by serializing it as text and saving it as base64 raw data
    // //$tweet_object = unserialize(base64_decode($row['raw_tweet']));
    // //echo $row['cache_id'];
    // //echo $tweet_object->lang;
    // //echo serialize($tweet_object);
    // echo base64_decode($row['raw_tweet']);
  // }
  // */
	// echo "success"; 
    
?>
</body>
</html>
