<?php
	
	Session_Start();
	
	
	require('database.php');
	require('method.php');
	require('ini.php');
	
	if(STARRY_UPDATE){
		echo '{"code": -99, "message": "updating"}';
		die();
	}
	
	$username = 'NOT_EXIST';
	@$username = $_SESSION['un'];
	
	$lang = 'zh_CN';
	@$_COOKIE['lang'] = $lang;
	
	$ret = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `username` = '$username'");
	
	if(empty($ret) || !empty($ret[0]['phone'])){
		echo '{"code": -1, "message": "bind-phone-fail"}';
		die();
	}
	
	$phone = $_REQUEST['phone'];
	
	SQL("UPDATE `graduation_prom_2018_account` SET `phone`='$phone'  WHERE `username` = '$username'  ");
	
	$var = array();
	$var[0]['key'] = 'name';
	$var[0]['value'] = $ret[0]['firstName'] . ' ' . $ret[0]['lastName'];
	
	if($lang == 'zh_CN'){
		$template = 'sWibt';
	}else if($lang == 'en_US'){
		$template = 'At22Y1';
	}
	
	sendSMS($phone, $template, $var);
	
	echo '{"code": 0, "message": "bind-phone-success"}';
	
	
?>