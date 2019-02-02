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
		echo '{"code":-1}';
		die();
	}
		
		
	$un = $_SESSION['un'];

	
	//getting_king
	$ret2 = SQL("SELECT `cid`, `username`, `votes`, `gender` FROM `graduation_prom_2018_voting_best` WHERE `gender` = 'M'");
	
	$best = 0;
	$kingcid = -1;	
	
	$arr= array();
	
	for($t = 0; $t < count($ret2); $t++){
	
		
		$arr['cid' . $ret2[$t]['cid']] = $ret2[$t]['votes'];
		
	}
	

	

	
	print(json_encode($arr));
	
	
	
	
	/*
	echo $queencid . 'best' . $best;

	echo 'best' . $ret1[$queencid]['username'] . $ret1[$queencid]['votes'] . 'cid' .  $ret1[$queencid]['cid']; 
	*/





?>
