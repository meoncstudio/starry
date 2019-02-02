<?php


	
	require('database.php');
	require('method.php');
	require('ini.php');

$content = $_REQUEST['content'];

$line = explode("\n", $content);


for($t = 0; $t < count($line); $t++){
	
	$part = explode('	', $line[$t]);
	
		$username = $part[0];
		$name = $part[1];
		$teacher = $part[3];
		$section = $part[2] . ' - ' . $part[4];
		
		$ret = SQL("INSERT INTO `graduation_prom_2018_free_list`(`username`, `name`, `teacher`, `section`) VALUES ('$username','$name','$teacher','$section')");
	
		
	}
	
	
	
	

?>