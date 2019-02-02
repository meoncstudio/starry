<?php

	ini_set('display_errors', '1'); 
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	
	require('database.php');
	require('method.php');
	
	
	session_start();
	
	
	$lang = 'zh_CN';
	@$_COOKIE['lang'] = $lang;
	
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
	
	
	$inviter = $ret[0]['inviter'];
	$ret2 = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `username` = '$inviter'");
	
	
	if($goodsId == '998'){
		
		$type = 'ACADEMY';
		
		$card = explode(',', $cards[0]);
		$serialCode = $card[0];
		$serialKey = $card[1];
		SQL("INSERT INTO `graduation_prom_2018_tickets`(`serialCode`, `serialKey`, `username`, `type`, `tradeNo`, `status`, `purchaseTime`) VALUES ('$serialCode','$serialKey','$username', '$type', '$tradeNo', '', '$purchaseTime')");
		
		if(!empty($inviter)){
			SQL("UPDATE `graduation_prom_2018_account` SET `inviter`='' WHERE `username` = '$username' ");
		}
		
	}else if(!empty($ret2) && count($cards) >= 2){
		
		$type = 'COUPLE';
		
		$card1 = explode(',', $cards[0]);
		$serialCode1 = $card1[0];
		$serialKey1 = $card1[1];
		SQL("INSERT INTO `graduation_prom_2018_tickets`(`serialCode`, `serialKey`, `username`, `type`, `tradeNo`, `status`, `purchaseTime`) VALUES ('$serialCode1','$serialKey1','$username', '$type', '$tradeNo', '', '$purchaseTime')");
		
		$card2 = explode(',', $cards[1]);
		$serialCode2 = $card2[0];
		$serialKey2 = $card2[1];
		SQL("INSERT INTO `graduation_prom_2018_tickets`(`serialCode`, `serialKey`, `username`, `type`, `tradeNo`, `status`, `purchaseTime`) VALUES ('$serialCode2','$serialKey2','$inviter', '$type', '$tradeNo', '', '$purchaseTime')");
		
		$txt .= "INSERT INTO `graduation_prom_2018_tickets`(`serialCode`, `serialKey`, `username`, `type`, `tradeNo`, `status`, `purchaseTime`) VALUES ('$serialCode2','$serialKey2','$inviter', '$type', '$tradeNo', '', '$purchaseTime')";
		
	}else{
		
		$type = 'SINGLE';
		
		$card = explode(',', $cards[0]);
		$serialCode = $card[0];
		$serialKey = $card[1];
		SQL("INSERT INTO `graduation_prom_2018_tickets`(`serialCode`, `serialKey`, `username`, `type`, `tradeNo`, `status`, `purchaseTime`) VALUES ('$serialCode','$serialKey','$username', '$type', '$tradeNo', '', '$purchaseTime')");
		
		if(!empty($inviter)){
			SQL("UPDATE `graduation_prom_2018_account` SET `inviter`='' WHERE `username` = '$username' ");
		}
		
	}
	
	
	$var = array();
	
	if($lang == 'zh_CN'){
		$template = 'wjyhh3';
		if($type == 'SINGLE'){
			$var[1]['key'] = 'type';
			$var[1]['value'] = '【单人 SINGLE】';
		}else if($type == 'COUPLE'){
			$var[1]['key'] = 'type';
			$var[1]['value'] = '【邀请 INVITATION】';
		}else if($type == 'ACADEMY'){
			$var[1]['key'] = 'type';
			$var[1]['value'] = '【学术 ACADEMY】';
		}else if($type == 'VOLUNTEER'){
			$var[1]['key'] = 'type';
			$var[1]['value'] = '【工作 VOLUNTEER】';
		}
	}else if($lang == 'en_US'){
		$template = 'mLYQe';
		if($type == 'SINGLE'){
			$var[1]['key'] = 'type';
			$var[1]['value'] = '【SINGLE】';
		}else if($type == 'COUPLE'){
			$var[1]['key'] = 'type';
			$var[1]['value'] = '【INVITATION】';
		}else if($type == 'ACADEMY'){
			$var[1]['key'] = 'type';
			$var[1]['value'] = '【ACADEMY】';
		}else if($type == 'VOLUNTEER'){
			$var[1]['key'] = 'type';
			$var[1]['value'] = '【VOLUNTEER】';
		}
	}
	
	
	
	$var[0]['key'] = 'name';
	$var[0]['value'] = $ret[0]['firstName'] . ' ' . $ret[0]['lastName'];
	
	$phone1 = $ret[0]['phone'];
	echo $phone1;
	sendSMS($phone1, $template, $var);
	
	
	if($type == 'COUPLE'){
		$inviter = $ret[0]['inviter'];
		$ret2 = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `username` = '$inviter'");
		$phone2 = $ret2[0]['phone'];
		echo $phone2;
		$var[0]['key'] = 'name';
		$var[0]['value'] = $ret2[0]['firstName'] . ' ' . $ret2[0]['lastName'];
		sendSMS($phone2, $template, $var);
	}
	
	
	
	$myfile = fopen("callback.txt", "w");
	$txt .= $goodsId . ', ' . $cardPwd . ', ' . $username;
	fwrite($myfile, $txt);
	fclose($myfile);
	
	
	
	
?>