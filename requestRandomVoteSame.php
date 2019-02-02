<?php

	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	
	
	require('database.php');
	require('method.php');
	require('ini.php');
	

	$ran = rand(10,99);
	SQL("UPDATE `graduation_prom_2018_voting_couple` SET `votes`= `votes` + $ran    ");
	
	
	
		
	

?>