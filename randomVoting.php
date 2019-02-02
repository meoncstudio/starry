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
	
	$start = $_REQUEST['start'];
	$end = $_REQUEST['end'];
		
		
	$ret = SQL("SELECT * FROM  `graduation_prom_2018_voting_couple`");
		
	for($t = 0; $t < count($ret); $t++){
		$cid = $ret[$t]['cid'];
		$ran = RAND($start, $end);
		SQL("UPDATE `graduation_prom_2018_voting_couple` SET `votes`= '$ran'WHERE `cid` = $cid");
		
		
	}
		
	echo $start . '-'.$end;
		
	
	
	//$ret = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `username` = '$un'");
	








?>