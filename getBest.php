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
		
		
	$un = $_SESSION['un'];
	
	//getting_queen
	$ret1 = SQL("SELECT `cid`, `username`, `votes`, `gender` FROM `graduation_prom_2018_voting_best` WHERE `gender` = 'F'");
	
	$arr = array();
	
	$best = 0;
	$queencid = 0;
	
	for($t = 0; $t < count($ret1); $t++){
	
		if($ret1[$t]['votes'] > $best){
			
			$best = $ret1[$t]['votes'];
			$queencid = $t;
			
		}
		
	}
	
	
	
	//getting_king
	$ret2 = SQL("SELECT `cid`, `username`, `votes`, `gender` FROM `graduation_prom_2018_voting_best` WHERE `gender` = 'M'");
	
	$best = 0;
	$kingcid = 0;	
	
	for($t = 0; $t < count($ret2); $t++){
	
		if($ret2[$t]['votes'] > $best){
			
			$best = $ret2[$t]['votes'];
			$kingcid = $t;
			
		}
		
	}
	
	
	//getting_couple
	$ret3 = SQL("SELECT `cid`, `username1`, `username2`, `votes` FROM `graduation_prom_2018_voting_couple`");
	
	$best = 0;
	$couplecid = 0;
	
	for($t = 0; $t < count($ret3); $t ++){
		if($ret3[$t]['votes'] > $best){
			$best = $ret3[$t]['votes'];
			$couplecid = $t;
		}
	}
	
	
	
	$queenun = $ret1[$queencid]['username'];
	$kingun = $ret2[$kingcid]['username'];
	$couple1 = $ret3[$couplecid]['username1'];
	$couple2 = $ret3[$couplecid]['username2'];
	
	
	
	$retq = SQL("SELECT `username`,`firstName`, `middleName`, `lastName` FROM `graduation_prom_2018_account` WHERE `username` = '$queenun' ");
	$retk = SQL("SELECT `username`,`firstName`, `middleName`, `lastName` FROM `graduation_prom_2018_account` WHERE `username` = '$kingun' ");
	$retc1 = SQL("SELECT `username`,`firstName`, `middleName`, `lastName` FROM `graduation_prom_2018_account` WHERE `username` = '$couple1' ");
	$retc2 = SQL("SELECT `username`,`firstName`, `middleName`, `lastName` FROM `graduation_prom_2018_account` WHERE `username` = '$couple2' ");
	
	$arr['QueenName'] = $retq[0]['lastName'] . ' ' . $retq[0]['firstName'];
	$arr['QueenEname'] = $retq[0]['middleName'];
	$arr['QueenVote'] = $ret1[$queencid]['votes'];
	
	$arr['KingName'] = $retk[0]['lastName'] . ' ' . $retk[0]['firstName'];
	$arr['KingEname'] = $retk[0]['middleName'];
	$arr['KingVote'] = $ret2[$kingcid]['votes'];

	
	$arr['Couple1Name'] = $retc1[0]['lastName'] . ' ' . $retc1[0]['firstName'];
	$arr['Couple2Name'] = $retc2[0]['lastName'] . ' ' . $retc2[0]['firstName'];
	$arr['CoupleName'] = $retc1[0]['lastName'] . ' ' . $retc1[0]['firstName'] . '<br>' . $retc2[0]['lastName'] . ' ' . $retc2[0]['firstName'];
	$arr['CoupleVote'] =  $ret3[$couplecid]['votes'];

	
	
	
	print(json_encode($arr));
	
	
	
	
	/*
	echo $queencid . 'best' . $best;

	echo 'best' . $ret1[$queencid]['username'] . $ret1[$queencid]['votes'] . 'cid' .  $ret1[$queencid]['cid']; 
	*/





?>
