<?php
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
	
	return $tweet_count;
}
?>