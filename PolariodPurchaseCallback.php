<?php

	ini_set('display_errors', '1'); 
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	
	require('database.php');
	require('method.php');
	
	
	session_start();
	
	
	$goodsId = $_REQUEST['goods_id'];
	$tradeNo = $_REQUEST['trade_no'];
	$cardPwd = $_REQUEST['card_password'];
	$username = $_REQUEST['contact'];
	
	
	$txt = '';
	
	
	$ret = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `username` = '$username'");
	$identity = 'NONE';
	@$identity = $ret[0]['identity'];
	
	if(empty($ret) || $ret[0]['grade'] != '12'){
		die();
	}
	
	
	$purchaseTime = date('Y-m-d H:i:s', time());
	$cards = explode('|', $cardPwd);
	
	$amount = count($cards);
	
	if($goodsId == '44563'){
		$item = 'Polariod';
	}
	
	$time = date('Y-m-d H:i:s');
	
	
	SQL("INSERT INTO `graduation_prom_2018_gift`(`username`, `item`, `amount`, `trade_no`, `time`) VALUES ('$username','$item','$amount','$tradeNo','$time')");
	
	
	
	
	
	
?>