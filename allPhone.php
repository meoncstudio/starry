<?php
	
	require('database.php');
	require('method.php');
	require('ini.php');
	
	$ret = SQL("SELECT `phone` FROM  `graduation_prom_2018_account`  ");
	
	for($t = 0; $t < count($ret); $t ++){
		
		echo $ret[$t]['phone'] . '<br>';
		
	}
	
?>