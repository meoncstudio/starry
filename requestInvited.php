<?php
	
	ini_set('display_errors', '1'); 
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	
	require('database.php');
	require('method.php');
	require('ini.php');
	
	if(STARRY_UPDATE){
		echo '{"code": -99, "message": "updating"}';
		die();
	}
	
	session_start();
	
	
	$username = 'NOT_EXIST';
	@$username = $_SESSION['un'];
	
	$ret = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `username` = '$username'");
	$identity = 'NONE';
	@$identity = $ret[0]['identity'];
	
	if(empty($ret) || $ret[0]['grade'] == '12'){
		echo '{"code": -1, "message": "cannot-invite-account"}';
		die();
	}
	
	$invitationCode = $_REQUEST['code'];
	
	if(empty($invitationCode)){
		echo '{"code": -2, "message": "invalid-invitation-code"}';
		die();
	}
	
	$ret = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `invitationCode` = '$invitationCode'  ");
	
	if(!empty($ret)){
		$inviterTemp = $ret[0]['inviter'];
		$ret2 = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `username` = '$inviterTemp'  ");
	}
	
	if(empty($ret) || $ret[0]['grade'] != '12' || !empty($ret2) || checkTicketPurchase($ret[0]['username']) == true){
		echo '{"code": -2, "message": "invalid-invitation-code"}';
		die();
	}
	
	$inv = $ret[0]['username'];
	$name = $ret[0]['firstName'] . ' ' . $ret[0]['lastName'];
	
	SQL("UPDATE `graduation_prom_2018_account` SET `inviter`='$username' WHERE `username` = '$inv' ");
	
	echo '{"code": 0, "message": "binding-invitation-successfully", "name": "' . $name . '"}';
	
	
?>