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
	
	$ret = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `username` = '$un'");
	
	if ($ret[0]['vote'] <= 0){
		echo '{"code":-2}';
		die();
	}	
	
	$cid = $_REQUEST['cid'];
	$vote = $_REQUEST['vote'];
	
	$ret1 = SQL("UPDATE `graduation_prom_2018_voting_best` SET `votes` = `votes` + $vote  WHERE `cid` = '$cid'  " );
	
	echo '{"code": 0}';
	


?>