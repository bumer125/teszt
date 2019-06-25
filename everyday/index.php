<?php
	require("connect.php");
	require("phpFunc.php");
	if(isset($_POST["send"])){
		try{
			$username=clearInput($_POST["username"]);
			$pass=hash('sha256', clearInput($_POST["pass"]));
			$err=null;
			
			$sql="SELECT * FROM users
			WHERE username=:username";
			$stmt=$conn->prepare($sql);
			$stmt->bindParam("username", $username);
			$stmt->execute();
			
			if(0<$stmt->rowCount()){
				$row=$stmt->fetch(PDO::FETCH_ASSOC);
				if($row["username"]==$_POST["username"] && $row["pass"]==$pass){
					session_start();
					$_SESSION["islog"]=true;
					$_SESSION["username"]=$row["username"];
					$_SESSION["id"]=$row["id"];
					header("Location:mainpage.php");
				}else{
					$err="*Hibás felhasználónév, vagy jelszó!";
				}
			}else{
				$err="*Hibás felhasználónév, vagy jelszó!";
			}
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}
?>
<!DOCTYPE html>
<html lang="hu">
	<head>
		<title>Every day</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="author" content="Adlan Daniel Aziz" />
		<meta name="description" content="M" />
		<link rel="stylesheet" href="style/index.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	</head>
	<body>
		<div id="sheet">
			<video height="350px" width="550px" controls muted autoplay >
				<source src="style/intro.mp4" type="video/mp4">
				A videó lejátszását nem támogatja a böngésződ.
			</video>
			<h1>Bejelentkezés</h1>
			<form method="post" autocomplete="off" >
				<label for="username">Felhasználónév:</label><p><?php if(isset($err)){ echo $err;} ?></p>
				<input type="text" name="username" required="required" />
				<label for="pass">Jelszó:</label>
				<input type="password" name="pass" placeholder="*****" required="required" />
				<input type="submit"  name="send" id="send" value="Bejelentkezés" />
				<a href="registration.php">Regisztráció</a>
			</form>
		</div>
	</body>
</html>