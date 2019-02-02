<?php
	
	Session_Start();
	
	
	require('database.php');
	require('method.php');
	require('ini.php');
	
	
	$username = 'NOT_EXIST';
	@$username = $_SESSION['un'];
	$username = '18020054';
	
	$ret = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `username` = '$username'");
	
	
	header('Content-type: image/jpg');
	
	echo base64ToPic(getPhoto($ret[0]));
	
	function showPhoto($ret){
		
		echo base64ToPic(getPhoto($ret));
		
	}
	
	
	
	
	
?>