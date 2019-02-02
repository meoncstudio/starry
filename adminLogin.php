<?php

	Session_Start();

	$un = $_REQUEST['un'];
	
	$_SESSION['un'] = $un;
	
?>