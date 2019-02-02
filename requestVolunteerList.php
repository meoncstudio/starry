<?php


	
	require('database.php');
	require('method.php');
	require('ini.php');

$content = $_REQUEST['content'];

$line = explode("\n", $content);


for($t = 0; $t < count($line); $t++){
	
	$un = $line[$t];
	$serialCode = rand(10,99) . rand(10,99) . date('dH', time()) . rand(10,99) . date('is', time()) . rand(10,99);
	$serialKey = md5("WH MAPLE LEAF GRADUATION PROM 2018 - " . $serialCode);
	$time = date('Y-m-d H:i:s');
	
	$ret = SQL("INSERT INTO `graduation_prom_2018_tickets`(`serialCode`, `serialKey`, `username`, `type`, `createTime`, `purchaseTime`, `tradeNo`, `status`) VALUES ('$serialCode','$serialKey','$un','VOLUNTEER','$time','$time','0','')");
		
	}
	
	
	
	

?>