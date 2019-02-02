<?php
require_once 'vendor/autoload.php'; // composer autoloader

if(!isset($_REQUEST["username"]))
    exit("No username is given");

$username = preg_replace('/[^\w]+/','',$_REQUEST["username"]);
$password = preg_replace('/[^\w]+/','',$_REQUEST["password"]);
try {
    $student = PowerAPI\PowerAPI::authenticate("http://101.132.86.211", $username,$password);
} catch (PowerAPI\Exceptions\Authentication $e) {
    file_put_contents("../error.log.py", date('Y-m-d H:i:s') . ' ' .  $e->getMessage() . "\n",FILE_APPEND);
    exit('Something went wrong! '.$e->getMessage());
}
header('Content-type: application/json');


echo json_encode($student);
