<?php

//error_reporting(0);

function PowerSchoolAccess($un, $pw){

	require_once 'vendor/autoload.php'; // composer autoloader
	
	$username = preg_replace('/[^\w]+/','',$un);
	$password = preg_replace('/[^\w]+/','',$pw);
	
	//directly invoke PowerSchool® API
	try {
		$student = PowerAPI\PowerAPI::authenticate("http://101.132.86.211", $username,$password, true);
	} catch (PowerAPI\Exceptions\Authentication $e) {
		return '{"code": -1, "message": "' . $e->getMessage() . '"}';
	}
	
	return '{"code": 0, "message": "Valid Powerschool account", "account": '.  json_encode($student) . '}';
	
}

?>