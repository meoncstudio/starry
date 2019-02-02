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
	
	$ret = SQL("SELECT * FROM `graduation_prom_2018_voting_couple` WHERE `username1` = '$username' OR `username2` = '$username' ");
	
	if(!empty($ret)){
		echo '{"code": -1, "message": "invalid-couple-code"}';
		die();
	}
	
	$code = $_REQUEST['code'];
	
	if(empty($code)){
		echo '{"code": -1, "message": "invalid-couple-code"}';
		die();
	}
	
	$ret = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `coupleCode` = '$code'  ");
	
	if(empty($ret) || empty($code)){
		echo '{"code": -1, "message": "invalid-couple-code"}';
		die();
	}
	
	$couple = $ret[0]['username'];
	
	$ret = SQL("SELECT * FROM `graduation_prom_2018_voting_couple` WHERE `username1` = '$couple' OR `username2` = '$couple'  ");
	if(!empty($ret)){
		echo '{"code": -1, "message": "invalid-couple-code"}';
		die();
	}
	
	SQL("INSERT INTO `graduation_prom_2018_voting_couple`(`username1`, `username2`, `votes`) VALUES ('$username','$couple','0')");
	
	echo '{"code": 0, "message": "binding-couple-successfully"}';
	
	
	
?>