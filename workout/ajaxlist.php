<?php
	require("connect.php");
	session_start();
	if($_SESSION["islog"]==false){
		session_unset();
		session_destroy();
		header("Location:index.php");
	}
	$o=json_decode($_REQUEST["se"]);
	echo $o->table;
?>