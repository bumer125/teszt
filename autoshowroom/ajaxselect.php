<?php
	//Bejelentkezés ellenőrzése
	require("connect.php");
	session_start();
	if($_SESSION["islog"]==false){
		session_destroy();
		header("Location:index.php");
	}
	
	$table=$_REQUEST["table"];
	//Autók listázása, | jel a szétdarabolás miatt kell, 
	//NEM KELL LISTÁZNI MERT CSAK EGY EREDMÉNY LEHET
	//MÓDOSÍTÁS MIATT KELL EZ A SELECT
	if($table=="car"){
		$req_id=$_REQUEST["id"];
		$sql="SELECT id, mark, price, model, em_id FROM $table
		WHERE id=:id";
		$stmt=$conn->prepare($sql);
		$stmt->bindParam(':id', $req_id);
		$stmt->execute();
		//$stmt->bind_result($id, $mark, $price, $model, $em_id);
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
			$sendmark=$row["mark"];
			$sendprice=$row["price"];
			$sendmodel=$row["model"];
			$sendem_id=$row["em_id"];
			$sendid=$row["id"];
		}
		$resultsql = json_encode([
			'sendmark'=>$sendmark,
			'sendprice'=>$sendprice,
			'sendmodel'=>$sendmodel,
			'sendem_id'=>$sendem_id,
			'sendid'=>$sendid,
		]);
		echo $resultsql;
		//$stmt->close;
	}
//--------------------------------------------------------------------------------------------------------------
	if($table=="employee"){
		$req_id=$_REQUEST["id"];
		$sql="SELECT id, firstn, secondn, email FROM $table
		WHERE id=:id";
		$stmt=$conn->prepare($sql);
		$stmt->bindParam(':id', $req_id);
		$stmt->execute();
		//$stmt->bind_result($id, $firstn, $secondn, $email);
		while($row=$stmt->fetch(PDO::FETCH_ASSOC) ) {
			$sendfirstn=$row["firstn"];
			$sendsecondn=$row["secondn"];
			$sendemail=$row["email"];
			$sendid=$row["id"];
		}
		//$stmt->close;
		$resultsql = json_encode([
			'sendfirstn'=>$sendfirstn,
			'sendsecondn'=>$sendsecondn,
			'sendemail'=>$sendemail,
			'sendid'=>$sendid,
		]);
		echo $resultsql;
	}
//--------------------------------------------------------------------------------------------------------------
	if($table=="customer"){
		$req_id=$_REQUEST["id"];
		$sql="SELECT id, firstn, secondn, email FROM $table
		WHERE id=:id";
		$stmt=$conn->prepare($sql);
		$stmt->bindParam(':id', $req_id);
		$stmt->execute();
		//$stmt->bind_result($id, $firstn, $secondn, $email);
		while($row=$stmt->fetch(PDO::FETCH_ASSOC) ) {
			$sendfirstn=$row["firstn"];
			$sendsecondn=$row["secondn"];
			$sendemail=$row["email"];
			$sendid=$row["id"];
		}
		//$stmt->close;
		$resultsql=json_encode([
			'sendfirstn'=>$sendfirstn,
			'sendsecondn'=>$sendsecondn,
			'sendemail'=>$sendemail,
			'sendid'=>$sendid,
		]);
		echo $resultsql;
	}
?>