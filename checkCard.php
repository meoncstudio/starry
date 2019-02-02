<?php
	
	ini_set('display_errors', '1'); 
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	
	require('database.php');
	require('method.php');
	
	
	session_start();
	
	$username = 'NOT_EXIST';
	@$username = $_SESSION['un'];
	
	
	$ret = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `username` = '$username'");
	$identity = 'NONE';
	@$identity = $ret[0]['identity'];
	
	if(empty($ret)){
		die();
	}
	
	if($identity == 'ADM'){
		//echo '3';
		//die();
	}
	
	
	
	$ip = $_SERVER["REMOTE_ADDR"];
	$ip = '192.' . rand(100, 999) . '.' . rand(10,99) . '.' . rand(10,99);
	
	$no = $_REQUEST['no'];
	
	$url = 'http://k.1ka123.com/querystatus';
	
	
	$post = array(
		'no' => $no
	);
	$options = array(
		CURLOPT_RETURNTRANSFER =>true,
		CURLOPT_HEADER =>false,
		CURLOPT_POST =>true,
		CURLOPT_POSTFIELDS => $post,
	);
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	//curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0)');
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (iPhone; CPU iPhone OS 11_1_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/11.1.1 Mobile/14E304 Safari/602.1');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:' . $ip, 'CLIENT-IP:' . $ip));
	curl_setopt ($ch, CURLOPT_REFERER, $url);
	curl_setopt_array($ch, $options);
	$html = curl_exec($ch);
	curl_close($ch);
	
	
	
	echo $html;
	
?>