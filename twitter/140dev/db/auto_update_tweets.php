<?php
	require_once('db_lib.php');
	require_once('tweet_functions.php');
	
	$oDB = new db;
	$fp = fopen("auto_update_logs.txt", "a");
	$iteration = 0;
	while(true){
	$query = "SELECT * FROM users";
	$result_rows = $oDB->select($query);
	
	fwrite($fp, date('h:i:s')."Iteration: ".++$iteration."  ::   ");
	$tweet_count = 0;
	while(($row = mysqli_fetch_array($result_rows))){
		
		$screen_name = $row['screen_name'];
		
		$tweet_count += store_user_tweets($screen_name, $oDB);
	}
	fwrite($fp, "Users:  ".mysqli_num_rows($result_rows));
	fwrite($fp, "Tweets:  ".$tweet_count."\n");
	
	sleep(10);
	
	}
	fclose($fp);
	sleep(1);
