<?php
	$host="localhost";
	$dbname="everyday";
	$user="root";
	$pass="goarsenaladlan";
	try{
		$conn=new PDO("mysql:dbname=$dbname;host=$host", $user, $pass);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->exec("SET NAMES utf8");
	}catch(PDOException $e){
		echo $e->getMessage();
	}
?>