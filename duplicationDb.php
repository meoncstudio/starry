<?php


	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	
	Session_Start();
	
	
	require('database.php');
	require('method.php');
	require('ini.php');

	
	if (empty($_SESSION['un'])){
		echo 'die';
		die();
	}

	echo '1';
	$ret = SQL("SELECT `username`, `gender` FROM `graduation_prom_2018_account`");
	echo '2';
	for($t = 0; $t < count($ret); $t++){
		$username = $ret[$t]['username'];
		$gender = $ret[$t]['gender'];
		echo $username;
		SQL("UPDATE `graduation_prom_2018_voting_best` SET `gender`= '$gender' WHERE `username` ='$username'" );
		
	}
	
	echo 'end';


?>