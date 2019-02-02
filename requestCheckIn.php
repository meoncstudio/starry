<?php
	
	

	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	
	Session_Start();
	
	
	require('database.php');
	require('method.php');
	require('ini.php');
	
	$ADM = false;
	@$ADM = $_SESSION['ADM'];
	if($ADM != true){
		echo '{"code": -2, "message": "No enough authority"}';
		die();
	}
	
	
	$lang = 'zh_CN';
	@$lang = $_REQUEST['lang'];
	@$_COOKIE['lang'] = $lang;

	$serialCode = $_REQUEST['serialCode'];
	
	$ret = SQL("SELECT * FROM `graduation_prom_2018_tickets` WHERE  `serialCode` = '$serialCode'    ");
	
	if($ret[0]['status'] != 'ACTIVATED'){
		echo '{"code": -3, "message": "Incorrect status"}';
		die();
	}
	
	$username = $ret[0]['username'];
	$ret3 = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE  `username` = '$username'  ");
	
	$ret2 = SQL("UPDATE `graduation_prom_2018_tickets` SET `status`='ENTERED'  WHERE `serialCode` = '$serialCode'     ");
	
	if(!$ret2){
		echo '{"code": -1, "message": "Invalid QR Entrance Ticket"}';
		die();
	}
	
	$phone = $ret3[0]['phone'];
	
	$var = array();
	$var[0]['key'] = 'name';
	$var[0]['value'] = $ret3[0]['firstName'] . ' ' . $ret3[0]['lastName'];
	
	if($lang == 'zh_CN'){
		$template = 'Aj1Wl';
	}else if($lang == 'en_US'){
		$template = 'nB39T2';
	}else{
		$template = 'Aj1Wl';
	}
	
	
	sendSMS($phone, $template, $var);
	
	echo '{"code": 0, "message": "Entered"}';
	
	
	
	
?>