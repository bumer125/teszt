<?php
	//Kapcsolódás az adatbázishoz
	$dbname="autoshowroom";
	$dbhost="localhost";
	$dbuser="postgres";
	$dbpass="adlandani125";
	
	try{
		$conn=new PDO("pgsql:dbname=$dbname;port=5432;host=$dbhost", $dbuser, $dbpass);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//$conn->exec("SET NAMES utf8");
	}catch(PDOExcpetion $e){
		echo $e->getMessage();
	}
		
	//Karakter készlet  beállítása
?>