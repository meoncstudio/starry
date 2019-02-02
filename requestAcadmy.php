<?php

	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	
	Session_Start();
	
	
	require('database.php');
	require('method.php');
	require('ini.php');
	
	$un = $_REQUEST['un'];
	
	$ret = SQL("SELECT * FROM `graduation_prom_2018_free_list` WHERE `username` = '$un'   ");
	
	if(empty($ret)){
		die('No match');
	}
	
	$serialCode = rand(10,99) . rand(10,99) . date('dH', time()) . rand(10,99) . date('is', time()) . rand(10,99);
	$serialKey = md5("WH MAPLE LEAF GRADUATION PROM 2018 - " . $serialCode);
	$time = date('Y-m-d H:i:s');
	
	SQL("INSERT INTO `graduation_prom_2018_tickets`(`serialCode`, `serialKey`, `username`, `type`, `createTime`, `purchaseTime`, `tradeNo`, `status`) VALUES ('$serialCode','$serialKey','$un','ACADEMY','$time','$time','0','')");
	
	die('OK');

?>