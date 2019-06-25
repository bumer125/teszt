<?php
	$dbname="workout";
	$host="localhost";
	$dbuser="postgres";
	$dbpassword="adlandani125";
	
	try{
		$conn=new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $dbuser, $dbpassword);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch(PDOException $e){
		echo $e->getMessage();
	}
?>