<?php

function add_new_user($screenName, $tweetsRequired){
	require_once('TwitterAPIExchange.php');
	///require_once('140dev_config.php');
	require_once('db_lib.php');

	/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
	$settings = array(
		'oauth_access_token' => "141488104-TdZGwXMgGBSHVHeLor2k6jpsii67XaGM56h5OoeA",
		'oauth_access_token_secret' => "8UuEj5CaQfBI2nhA4sxfgH6QF89gZJaNkQeWswSYbzNyY",
		'consumer_key' => "AJk0vlZ69oNmPuL8MjVYIzekq",
		'consumer_secret' => "NNesDHpOJoWtNQ5Qj2GNGQSF0zZjwCi3R1PYMPyfnSje2exGhV"
	);

	
	$oDB = new db;
	
	
	/** Perform a GET request and echo the response **/
	/** Note: Set the GET field BEFORE calling buildOauth(); **/
	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
	
	$getfield = '?count='.$tweetsRequired.'&exclude_replies=1&user_id='.$screenName.'&screen_name='.$screenName.'&include_entities=true';
	
	$requestMethod = 'GET';
	$twitter = new TwitterAPIExchange($settings);
	$twit_response_json =  $twitter->setGetfield($getfield)
				 ->buildOauth($url, $requestMethod)
				 ->performRequest();

	$twit_response = json_decode($twit_response_json);
	//echo $twit_response_json;
	$tweet_count = 0;
	foreach($twit_response as $tweet_object){
			// check if the tweet_id already exists before inserting
		$tweet_id = $tweet_object->id_str;
		if ($oDB->in_table('tweets','tweet_id=' . $tweet_id )) {continue;}
		$tweet_count++;
		// Gather tweet data from the JSON object
		// $oDB->escape() escapes ' and " characters, and blocks characters that
		// could be used in a SQL injection attempt
		
		if (isset($tweet_object->retweeted_status)) {
		  // This is a retweet
		  // Use the original tweet's entities, they are more complete
		  $entities = $tweet_object->retweeted_status->entities;
				$is_rt = 1;
		} 
		else {
			  $entities = $tweet_object->entities;
			  $is_rt = 0;
		}
			
		$tweet_text = $oDB->escape($tweet_object->text);	
		$created_at = $oDB->date($tweet_object->created_at);
		if (isset($tweet_object->geo)) {
		  $geo_lat = $tweet_object->geo->coordinates[0];
		  $geo_long = $tweet_object->geo->coordinates[1];
		}
		else {
		  $geo_lat = $geo_long = 0;
		} 
		
		$user_object = $tweet_object->user;
		$user_id = $user_object->id_str;
		$screen_name = $oDB->escape($user_object->screen_name);
		$name = $oDB->escape($user_object->name);
		$profile_image_url = $user_object->profile_image_url;

			
		// Add a new user row or update an existing one
		$field_values = 'screen_name = "' . $screen_name . '", ' .
		  'profile_image_url = "' . $profile_image_url . '", ' .
		  'user_id = ' . $user_id . ', ' .
		  'name = "' . $name . '", ' .
		  'location = "' . $oDB->escape($user_object->location) . '", ' . 
		  'url = "' . $user_object->url . '", ' .
		  'description = "' . $oDB->escape($user_object->description) . '", ' .
		  'created_at = "' . $oDB->date($user_object->created_at) . '", ' .
		  'followers_count = ' . $user_object->followers_count . ', ' .
		  'friends_count = ' . $user_object->friends_count . ', ' .
		  'statuses_count = ' . $user_object->statuses_count . ', ' . 
		  'time_zone = "' . $user_object->time_zone . '", ' .
		  'last_update = "' . $oDB->date($tweet_object->created_at) . '"' ;			

		if ($oDB->in_table('users','user_id="' . $user_id . '"')) {
		  $oDB->update('users',$field_values,'user_id = "' .$user_id . '"');
		} 
		else {			
		  $oDB->insert('users',$field_values);
		}
			
		// Add the new tweet
		
		$field_values = 'tweet_id = ' . $tweet_id . ', ' .
			'tweet_text = "' . $tweet_text . '", ' .
			'created_at = "' . $created_at . '", ' .
			'geo_lat = ' . $geo_lat . ', ' .
			'geo_long = ' . $geo_long . ', ' .
			'user_id = ' . $user_id . ', ' .				
			'screen_name = "' . $screen_name . '", ' .
			'name = "' . $name . '", ' .
			'profile_image_url = "' . $profile_image_url . '", ' .
			'is_rt = ' . $is_rt;
				
		$oDB->insert('tweets',$field_values);
			
		// The mentions, tags, and URLs from the entities object are also
		// parsed into separate tables so they can be data mined later
		foreach ($entities->user_mentions as $user_mention) {
			
		  $where = 'tweet_id=' . $tweet_id . ' ' .
			'AND source_user_id=' . $user_id . ' ' .
			'AND target_user_id=' . $user_mention->id;		
						 
		  if(! $oDB->in_table('tweet_mentions',$where)) {
				
			$field_values = 'tweet_id=' . $tweet_id . ', ' .
			'source_user_id=' . $user_id . ', ' .
			'target_user_id=' . $user_mention->id;	
					
			$oDB->insert('tweet_mentions',$field_values);
		  }
		}
		foreach ($entities->hashtags as $hashtag) {
				
		  $where = 'tweet_id=' . $tweet_id . ' ' .
			'AND tag="' . $hashtag->text . '"';		
						
		  if(! $oDB->in_table('tweet_tags',$where)) {
				
			$field_values = 'tweet_id=' . $tweet_id . ', ' .
			  'tag="' . $hashtag->text . '"';	
					
			$oDB->insert('tweet_tags',$field_values);
		  }
		}
		foreach ($entities->urls as $url) {
			
		  if (empty($url->expanded_url)) {
			$url = $url->url;
		  } else {
			$url = $url->expanded_url;
		  }
				
		  $where = 'tweet_id=' . $tweet_id . ' ' .
			'AND url="' . $url . '"';		
						
		  if(! $oDB->in_table('tweet_urls',$where)) {
			$field_values = 'tweet_id=' . $tweet_id . ', ' .
			  'url="' . $url . '"';	
					
			$oDB->insert('tweet_urls',$field_values);
		  }
		}
		
		foreach($entities->media as $media_item){
			
			if($media_item->type == 'photo'){
				$media_id = $media_item->id;
				$media_url = $media_item->media_url;
				//echo $media_url;
				
				
				$where = 'media_id="' . $media_id . '" ';
				
				if(! $oDB->in_table('tweet_media',$where)) {
					$field_values = 'tweet_id = ' . $tweet_id . ', media_id = '.$media_id.', media_url = "'.$media_url.'"';	
					echo $field_values."\n";		
					$oDB->insert('tweet_media',$field_values);
					//$query = "INSERT INTO tweet_media (tweet_id, media_id, media_url) values ('".$tweet_id."', '".$media_id."', '".$media_url."')";
					//echo $query;
					
				}
			}
		}
	}
	
	//echo 'tweet count : '.$tweet_count;
	return $tweet_count;

}

function store_user_tweets($screenName, $oDB){
	
	require_once('TwitterAPIExchange.php');
	///require_once('140dev_config.php');
	//require_once('db_lib.php');

	/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
	$settings = array(
		'oauth_access_token' => "141488104-TdZGwXMgGBSHVHeLor2k6jpsii67XaGM56h5OoeA",
		'oauth_access_token_secret' => "8UuEj5CaQfBI2nhA4sxfgH6QF89gZJaNkQeWswSYbzNyY",
		'consumer_key' => "AJk0vlZ69oNmPuL8MjVYIzekq",
		'consumer_secret' => "NNesDHpOJoWtNQ5Qj2GNGQSF0zZjwCi3R1PYMPyfnSje2exGhV"
	);

	
	//$oDB = new db;
	
	//$screenName = "TechCrunch";
	/** Getting the most recent tweet id of the person stored in our database **/
	$query = 'SELECT MAX(tweet_id) FROM tweets WHERE screen_name="'.$screenName.'" ';

	$MaxId_Result = $oDB->select($query);
	
	$MaxId = 0;
	
	while(($row = mysqli_fetch_array($MaxId_Result))){
		$MaxId = $row['MAX(tweet_id)'];

	}
	
	/** Perform a GET request and echo the response **/
	/** Note: Set the GET field BEFORE calling buildOauth(); **/
	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
	
	if($MaxId != 0 )
		$getfield = '?exclude_replies=1&user_id='.$screenName.'&screen_name='.$screenName.'&since_id='.$MaxId.'&include_entities=true';
	else 
		$getfield = '?count=50&exclude_replies=1&user_id='.$screenName.'&screen_name='.$screenName.'&include_entities=true';
		
	//echo $url.$getfield;
	
	$requestMethod = 'GET';
	$twitter = new TwitterAPIExchange($settings);
	$twit_response_json =  $twitter->setGetfield($getfield)
				 ->buildOauth($url, $requestMethod)
				 ->performRequest();

	$twit_response = json_decode($twit_response_json);
	//echo $twit_response_json;
	$tweet_count = 0;
	foreach($twit_response as $tweet_object){
			// check if the tweet_id already exists before inserting
		$tweet_id = $tweet_object->id_str;
		if ($oDB->in_table('tweets','tweet_id=' . $tweet_id )) {continue;}
		$tweet_count++;
		// Gather tweet data from the JSON object
		// $oDB->escape() escapes ' and " characters, and blocks characters that
		// could be used in a SQL injection attempt
		
		if (isset($tweet_object->retweeted_status)) {
		  // This is a retweet
		  // Use the original tweet's entities, they are more complete
		  $entities = $tweet_object->retweeted_status->entities;
				$is_rt = 1;
		} 
		else {
			  $entities = $tweet_object->entities;
			  $is_rt = 0;
		}
			
		$tweet_text = $oDB->escape($tweet_object->text);	
		$created_at = $oDB->date($tweet_object->created_at);
		if (isset($tweet_object->geo)) {
		  $geo_lat = $tweet_object->geo->coordinates[0];
		  $geo_long = $tweet_object->geo->coordinates[1];
		}
		else {
		  $geo_lat = $geo_long = 0;
		} 
		
		$user_object = $tweet_object->user;
		$user_id = $user_object->id_str;
		$screen_name = $oDB->escape($user_object->screen_name);
		$name = $oDB->escape($user_object->name);
		$profile_image_url = $user_object->profile_image_url;

			
		// Add a new user row or update an existing one
		$field_values = 'screen_name = "' . $screen_name . '", ' .
		  'profile_image_url = "' . $profile_image_url . '", ' .
		  'user_id = ' . $user_id . ', ' .
		  'name = "' . $name . '", ' .
		  'location = "' . $oDB->escape($user_object->location) . '", ' . 
		  'url = "' . $user_object->url . '", ' .
		  'description = "' . $oDB->escape($user_object->description) . '", ' .
		  'created_at = "' . $oDB->date($user_object->created_at) . '", ' .
		  'followers_count = ' . $user_object->followers_count . ', ' .
		  'friends_count = ' . $user_object->friends_count . ', ' .
		  'statuses_count = ' . $user_object->statuses_count . ', ' . 
		  'time_zone = "' . $user_object->time_zone . '", ' .
		  'last_update = "' . $oDB->date($tweet_object->created_at) . '"' ;			

		if ($oDB->in_table('users','user_id="' . $user_id . '"')) {
		  $oDB->update('users',$field_values,'user_id = "' .$user_id . '"');
		} 
		else {			
		  $oDB->insert('users',$field_values);
		}
			
		// Add the new tweet
		
		$field_values = 'tweet_id = ' . $tweet_id . ', ' .
			'tweet_text = "' . $tweet_text . '", ' .
			'created_at = "' . $created_at . '", ' .
			'geo_lat = ' . $geo_lat . ', ' .
			'geo_long = ' . $geo_long . ', ' .
			'user_id = ' . $user_id . ', ' .				
			'screen_name = "' . $screen_name . '", ' .
			'name = "' . $name . '", ' .
			'profile_image_url = "' . $profile_image_url . '", ' .
			'is_rt = ' . $is_rt;
				
		$oDB->insert('tweets',$field_values);
			
		// The mentions, tags, and URLs from the entities object are also
		// parsed into separate tables so they can be data mined later
		foreach ($entities->user_mentions as $user_mention) {
			
		  $where = 'tweet_id=' . $tweet_id . ' ' .
			'AND source_user_id=' . $user_id . ' ' .
			'AND target_user_id=' . $user_mention->id;		
						 
		  if(! $oDB->in_table('tweet_mentions',$where)) {
				
			$field_values = 'tweet_id=' . $tweet_id . ', ' .
			'source_user_id=' . $user_id . ', ' .
			'target_user_id=' . $user_mention->id;	
					
			$oDB->insert('tweet_mentions',$field_values);
		  }
		}
		foreach ($entities->hashtags as $hashtag) {
				
		  $where = 'tweet_id=' . $tweet_id . ' ' .
			'AND tag="' . $hashtag->text . '"';		
						
		  if(! $oDB->in_table('tweet_tags',$where)) {
				
			$field_values = 'tweet_id=' . $tweet_id . ', ' .
			  'tag="' . $hashtag->text . '"';	
					
			$oDB->insert('tweet_tags',$field_values);
		  }
		}
		foreach ($entities->urls as $url) {
			
		  if (empty($url->expanded_url)) {
			$url = $url->url;
		  } else {
			$url = $url->expanded_url;
		  }
				
		  $where = 'tweet_id=' . $tweet_id . ' ' .
			'AND url="' . $url . '"';		
						
		  if(! $oDB->in_table('tweet_urls',$where)) {
			$field_values = 'tweet_id=' . $tweet_id . ', ' .
			  'url="' . $url . '"';	
					
			$oDB->insert('tweet_urls',$field_values);
		  }
		}
		
		foreach($entities->media as $media_item){
			
			if($media_item->type == 'photo'){
				$media_id = $media_item->id;
				$media_url = $media_item->media_url;
				//echo $media_url;
				
				
				$where = 'media_id="' . $media_id . '" ';
				
				
				if(! $oDB->in_table('tweet_media',$where)) {
					$field_values = 'tweet_id = ' . $tweet_id . ', media_id = '.$media_id.', media_url = "'.$media_url.'"';	
					//echo $field_values."\n";		
					$oDB->insert('tweet_media',$field_values);
					//$query = "INSERT INTO tweet_media (tweet_id, media_id, media_url) values ('".$tweet_id."', '".$media_id."', '".$media_url."')";
					//echo $query;
					
				}
			}
		}
	}
	
	//echo 'tweet count : '.$tweet_count;
	return $tweet_count;
}

// function delete_tweet($tweet_id){
	
	// require_once('db_lib.php');
	// $oDB = new db;
	// /*
	// if(!($oDB->in_table('tweets','tweet_id = ' . $tweet_id ))){
		// echo "Tweet with given tweet id doesn't exist in our database";
		// return 0;
	// }*/
	
	// $where = 'tweet_id = '.$tweet_id;
	// //Deleting tweet media
	// $oDB->delete('tweet_media', $where);
	
	// //Deleting tweet Mentions
	// $oDB->delete('tweet_mentions', $where);
	
	// //Deleting tweet Tags
	// $oDB->delete('tweet_tags', $where);
	
	// //Deleting tweet URLs
	// $oDB->delete('tweet_urls', $where);
	
	// //Deleting the tweet 
	// $oDB->delete('tweets', $where);
	
	// return 1;
// }

function delete_user($screen_name){
	
	require_once('db_lib.php');
	$oDB = new db;
	
	if(!$oDB->in_table('users', 'screen_name = "'.$screen_name.'"')){
		return "0: The Screen Name doesn't exist in our database";
	}
	$tweet_count = 0;
	
	$query = 'SELECT * FROM tweets WHERE screen_name = "'.$screen_name.'"';
	
	$result_row = $oDB->select($query);
		
	while(($row = mysqli_fetch_array($result_row))){
		$tweet_id = $row['tweet_id'];
		
		// /*if(delete_tweet($tweet_id) == 1){
			// $tweet_count++;
		// }*/
		
		$where = 'tweet_id = '.$tweet_id;
		
		//Deleting tweet media
		
		$oDB->delete1('tweet_media', $where);
		
		//Deleting tweet Mentions
		$oDB->delete1('tweet_mentions', $where);
		
		//Deleting tweet Tags
		$oDB->delete1('tweet_tags', $where);
		
		//Deleting tweet URLs
		$oDB->delete1('tweet_urls', $where);
		
		// //Deleting the tweet 
		$oDB->delete1('tweets', $where);
		$tweet_count++;
	}
	$where = 'screen_name = "'.$screen_name.'" ';
	$oDB->delete1('users', $where);
	return $tweet_count;
}

//updates the tweets of existing users
function update_tweets(){
	
	require_once('db_lib.php');
	$oDB = new db;
	
	$query = "SELECT * FROM users";
	$result_rows = $oDB->select($query);
	
	$tweet_count = 0;
	while(($row = mysqli_fetch_array($result_rows))){
		$screen_name = $row['screen_name'];
		$tweet_count += store_user_tweets($screen_name, $oDB);
	}
	return $tweet_count;
}

?>