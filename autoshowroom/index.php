<?php
	require("connect.php");
	$err=""; //hibaüzenet
	
	if(isset($_POST["log"])){
		//Beírt jelszó átalakítása az ellenőrzéshez
		$salt="8dC_9Kl?";
		$encryptedpass=md5($_POST["pass"] . $salt);
		
		$sql="SELECT username, pass FROM users
		WHERE username=:username";
		$stmt=$conn->prepare($sql);
		$stmt->bindParam(":username", $_POST["username"]);
		$stmt->execute();
		
		//$res=$stmt->get_result();
		if(0<$stmt->rowCount()){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			if($row["username"]==$_POST["username"] && $row["pass"]==$encryptedpass){
				session_start();
				$_SESSION["islog"]=true;
				$_SESSION["username"]=$row["username"];
				header("Location:mainpage.php");
			}else{
				$err="*Hibás felhasználónév, vagy jelszó!";
			}
		}else{
			$err="*Hibás felhasználónév, vagy jelszó!";
		}
	}
?>
<!DOCTYPE html>
<html lang="hu">
	<head>
		<title>Autószalon</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="style/index.css" />
	</head>
	<body>
		<h1>Bejelentkezés</h1>
		<h2>Az oldal megtekintéséhez először be kell jelentkeznie!</h2>
		<div class="container">
			<form method="post" autocomplete="off" >
				<img src="style/login.png" alt="login.png" /><br />
				
				<label for="username">Felhasználónév:</label><p><?php echo $err;?></p>
				<input type="text" required="required" placeholder="Username" name="username" />
				
				<label for="pass">Jelszó:</label>
				<input type="password" required="required" placeholder="*****" name="pass" />
				
				<input type="submit" name="log" value="Bejelentkezés" />
				<a href="registration.php">Regisztráció</a>
			</form>
		<div>
	</body>
</html>