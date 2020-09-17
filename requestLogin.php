<?php
	
	Session_Start();
	
	require('database.php');
	require('method.php');
	require('ini.php');
	
	
	ini_set("error_reporting","E_ALL & ~E_NOTICE & ~E_WARNING");
	
	if(!STARRY_ENTRANCE_Login){
		echo '{"code": -999, "message": "login-function-disabled"}';
		die();
	}

	
	$un = $_REQUEST['un'];
	
	if(!empty($_COOKIE['auth'])){
		$pw = $_COOKIE['auth'];
		setcookie('auth', '', time() - 3600);
	}else if(!empty($_REQUEST['pw'])){
		$pw = $_REQUEST['pw'];
	}
	
	
	$retu = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `username` = '$un'");

	
	if(empty($retu)){

		require('PowerSchoolAPI/gp_access.php');

		$reta = PowerSchoolAccess($un, $pw);
		$ret = JSON_decode($reta, true);

		$_SESSION['ps'] = $ret;


		if ($ret['code'] != 0 && ($un != 'annyhaha' && $un != 'grade1101' && $un != 'grade1102' && $un != 'grade12')) {
			echo '{"code": -1, "message": "login-fail"}';
			die();
		}
		
		$username = $un;
		$firstName = $ret['account']['information']['firstName'];
		$middleName = $ret['account']['information']['middleName'];
		$lastName = $ret['account']['information']['lastName'];
		$grade = $ret['account']['information']['gradeLevel'];
		$gender = $ret['account']['information']['gender'];
		$photo = getPhoto($ret['account']['information']);
		
		if($grade < 10){
			echo '{"code": -2, "message": "login-grade-match"}';
			die();
		}
		
		
		$sections = $ret['account']['sections'];
		for($t = 0; $t < count($sections); $t ++){
			if($sections[$t]['expression'] == 'N(1-2)'){
				$conselorFirstName = $sections[$t]['teacher']['firstName'];
				$conselorLastName = $sections[$t]['teacher']['lastName'];
			}
		}
		
		$invitationCode = substr(base64_encode(md5(rand(100000,999999) . $username . $firstName . $lastName . $grade . $gender . $photo . rand(100000,999999))), 10, 5);
		$coupleCode = substr(base64_encode(md5(rand(100000,999999) . $username . $firstName . $lastName . $grade . $gender . $photo . rand(100000,999999))), 20, 5);
		$retu = SQL("INSERT INTO `graduation_prom_2018_account`(`username`, `firstName`, `lastName`, `gender`, `grade`, `conselorFirstName`, `conselorLastName`, `photo`, `invitationCode`, `inviter`, `middleName`, `coupleCode`) VALUES ('$username','$firstName','$lastName','$gender','$grade','$conselorFirstName','$conselorLastName', '$photo', '$invitationCode', '0', '$middleName', '$coupleCode')");
		
	}else{
		
		$username = $un;
		$firstName = $retu[0]['firstName'];
		$middleName = $retu[0]['middleName'];
		$lastName = $retu[0]['lastName'];
		$grade = $retu[0]['grade'];
		$gender = $retu[0]['gender'];
		$photo = $retu[0]['photo'];
		$invitationCode = $retu[0]['invitationCode'];
		$inviter = $retu[0]['inviter'];
		
		if($ret['code'] == 0 && $photo == ''){
			$photo = getPhoto($ret['account']['information']);
			SQL("UPDATE `graduation_prom_2018_account` SET `photo`='$photo' WHERE `username` = '$username'  ");
		}
		
		
		if($ret['code'] == 0 && $retu[0]['conselorFirstName'] == ''){
			$sections = $ret['account']['sections'];
			for($t = 0; $t < count($sections); $t ++){
				if($sections[$t]['expression'] == 'N(1-2)'){
					$conselorFirstName = $sections[$t]['teacher']['firstName'];
					$conselorLastName = $sections[$t]['teacher']['lastName'];
					SQL("UPDATE `graduation_prom_2018_account` SET `conselorFirstName`='$conselorFirstName',`conselorLastName`='$conselorLastName' WHERE `username` = '$username'  ");
				}
			}
			
		}
		
	}


	$_SESSION['un'] = $un;
	
	
	
	echo '{"code": 0, "message": "Welcome, ' . $lastName . ' ' . $firstName . '.", "firstName": "' . $firstName . '", "middleName": "' . $middleName . '", "lastName": "' . $lastName . '", "username": "' . $un . '", "grade": "' . $grade . '", "photo": "' . $photo . '"}';
	
	
	
	
	
	
	
?>