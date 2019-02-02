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

	$op = $_REQUEST['op'];
	
	if ($op = 'clear'){
			SQL("UPDATE `graduation_prom_2018_voting_couple` SET `votes`= 0" );
	
			echo '{"code":1}';

			SQL("UPDATE `graduation_prom_2018_voting_best` SET `votes`= 0" );

			echo '{"code":1}';

	}else if{
			echo '{"code":-1}';
	}



?>