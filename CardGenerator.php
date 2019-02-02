<?php
	
	require('database.php');
	require('method.php');
	
	
	$count = $_REQUEST['count'];
	
	for($t = 0; $t < $count; $t++){
		
		$serialCode = rand(10,99) . rand(10,99) . date('dH', time()) . rand(10,99) . date('is', time()) . rand(10,99);
		$serialKey = md5("WH MAPLE LEAF GRADUATION PROM 2018 - " . $serialCode);
		
		//SQL("INSERT INTO `graduation_prom_2018_tickets`(`serialCode`, `serialKey`, `username`, `type`, `tradeNo`, `status`) VALUES ('$serialCode','$serialKey',0, '', '', '')");
		//不要现在就加入数据库
		
		echo $serialCode . ' ' . $serialKey;
		if($t != $count - 1) echo ',';
	
	}
	
	
?>