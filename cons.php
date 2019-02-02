<?php

ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	
	Session_Start();
	
	
	require('database.php');
	require('method.php');
	require('ini.php');

$ret = SQL('SELECT `conselorFirstName`, `conselorLastName` FROM `graduation_prom_2018_account`  ');
			
			$names = array();
			for($t = 0; $t < count($ret); $t ++){
				$names[$t] = $ret[$t]['conselorFirstName'] . ' ' . $ret[$t]['conselorLastName'];
			}
			
			$names[count($names)] = 'Business Department';
			$names = array_unique($names);
			$names = array_merge($names);
			
			
			for($t = 0; $t < count($names); $t ++){
				$temp = substr(base64_encode(md5($names[$t])), 10, 5);
				echo $names[$t] . ' -> ' . $temp . '<br>';
			}

?>