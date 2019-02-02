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
		
	//$cid = $_REQUEST['cid'];
		
	$un = $_SESSION['un'];
	
	//$ret = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `username` = '$un'");
	
	$ret1 = SQL("SELECT * FROM `graduation_prom_2018_voting_couple`");
	
	$arr = array();
	
	for($t = 0; $t < count($ret1); $t++){
		//echo '{"' . $ret1[$t]['cid'] . '": "' . $ret1[$t]['votes'] . '"}';
		$arr['cid' . $ret1[$t]['cid']] = $ret1[$t]['votes'];
		
	}

	print(json_encode($arr));












?>