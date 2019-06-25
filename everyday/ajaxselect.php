<?php
	require("connect.php");
	session_start();
	if($_SESSION["islog"]!=true){
		session_unset();
		session_destroy();
		header("Location:index.php");
	}
	try{
		$sql="SELECT * FROM users
		WHERE id=:id";
		$stmt=$conn->prepare($sql);
		$stmt->bindParam(":id", $_SESSION["id"]);
		$stmt->execute();
		
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		echo json_encode([
			"fname"=>$row["fname"],
			"sname"=>$row["sname"],
			"email"=>$row["email"],
			"username"=>$row["username"],
		]);
	}catch(PDOException $e){
		echo $e->getMessage();
	}
?>