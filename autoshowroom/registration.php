<?php
	require("connect.php");
	
	$fn_err=$sec_err=$e_err=$usn_err=$pass_err="";
	//Regisztráció gomb lenyomása után
	if(isset($_POST["reg"])){
		$firstn=$secondn=$email=$username=$pass="";
		
		//Ellenőrzések az inputokra
		//Vezetéknév
		if(checkCharacter($_POST["firstn"])==false){
			$fn_err="*Csak betűk megengedettek!";
		}else{
			$firstn=checkI($_POST["firstn"]);
		}
		
		//Utónév
		if(checkCharacter($_POST["secondn"])==false){
			$sec_err="*Csak betűk megengedettek!";
		}else{
			$secondn=checkI($_POST["secondn"]);
		}

		//E-mail
		if(checkEmail($_POST["email"])==false){
			$e_err="*Rossz e-mail címet adott meg!";
		}else{
			$email=checkI($_POST["email"]);
		}

		//Felhasználónév
		if(checkUsName($_POST["username"])==false){
			$usn_err="*Csak betűk és számok megengedettek!";
		}else{
			$username=checkI($_POST["username"]);
		}
		
		//Jelszó
		if($_POST["pass"]!=$_POST["passc"]){
			$pass_err="*A jelszavak nem egyeznek meg!";
		}else if(strlen($_POST["pass"])<7){
			$pass_err="*Adjon meg legalább 7 character!";
		}else if(20<strlen($_POST["pass"])){
			$pass_err="*A jelszó maximum 20 characterből állhat!";
		}else{
			//Ha minden rendben feltöltés előtt átalakítás
			$salt="8dC_9Kl?";
			$pass=checkI($_POST["pass"]);
			$encryptedpass=md5($pass . $salt);
		}
		
		//Ha minden adat jó
		if($firstn!="" && $secondn!="" && $email!="" && $username && $pass!=""){			
			//Foglalt e a felhasználónév
			$flag=true; //Jelzés ha minden tökéletes
			
			//Felhasználónév fogalalt e
			$sql1="SELECT username FROM users
			WHERE username=:username";
			$stmt=$conn->prepare($sql1);
			$stmt->bindParam(":username", $username);
			$stmt->execute();
			//$res1=$stmt->get_result();
			
			if(0<$stmt->rowCount()){
				$flag=false;
				$usn_err="*A felhasználónév már fogalalt!";
			}
			//$stmt->close();
			
			
			//E-mail cím regisztrálva van e
			$sql2="SELECT username FROM users
			WHERE email=:email";
			$stmt=$conn->prepare($sql2);
			$stmt->bindParam(":email", $email);
			$stmt->execute();
			//$res2=$stmt->get_result();
			
			if(0<$stmt->rowCount()){
				$flag=false;
				$e_err="*Az e-mail cím már regisztrált!";
			}
			
			if($flag==true){
				//$stmt->close();
				$sql3="INSERT INTO users(firstn, secondn, email, username, pass)
				VALUES(:firstn,:secondn,:email,:username,:pass)
				";
				//echo $stmt->num_rows();
				$stmt=$conn->prepare($sql3);
				$stmt->bindParam(":firstn", $firstn);
				$stmt->bindParam(":secondn", $secondn);
				$stmt->bindParam(":email", $email);
				$stmt->bindParam(":username", $username);
				$stmt->bindParam(":pass", $encryptedpass);
				$stmt->execute();
				
				session_start();
				$_SESSION["islog"]=true;
				$_SESSION["username"]=$username;
				header("Location:mainpage.php");
			}
		}
	}
	
	//Input ellenőrzése: szóközök, html character és / jelekre
	function checkI($data){
		$data=trim($data);
		$data=htmlspecialchars($data);
		$data=stripcslashes($data);
		return $data;
	}
	//Ellenőrzés: csak berűket tartalmazhat
	function checkCharacter($data){
		if(preg_match("/^[ a-záéiíoóöőuúüűÁÉIÍOÓÖŐUÚÜŰA-Z ]*$/", $data)){
			return true;
		}else{
			return false;
		}
	}		
	//Ellenőrzés: csak betűket és számokat tartalmazhat (Username)
	function checkUsName($data){
		if(preg_match("/^[a-záéiíoóöőuúüűÁÉIÍOÓÖŐUÚÜŰA-Z0-9]*$/", $data)){
			return true;
		}else{
			return false;
		}
	}	
	//Ellenőrzés: e-mail cím valós
	function checkEmail($data){
		if(filter_has_var(INPUT_POST, "email")){
			return true;
		}else{
			return false;
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
		<h1>Regisztráció</h1>
		<h2>A regisztárcióhoz töltse ki a mezőket!</h2>
		<div class="container">
			<form method="post" autocomplete="off" >
				<label for="firstn">Vezetéknév:</label><p><?php echo $fn_err;?></p>
				<input type="text" required="required"  name="firstn" value="<?php if(isset($_POST["firstn"])){ echo checkI($_POST["firstn"]);}?>" />
				
				<label for="secondn">Utónév:</label><p><?php echo $sec_err;?></p>
				<input type="text" required="required" name="secondn" value="<?php if(isset($_POST["secondn"])){ echo $_POST["secondn"];} ?>" />
				
				<label for="email">E-mail cím:</label><p><?php echo $e_err;?></p>
				<input type="email" required="required"  name="email" value="<?php if(isset($_POST["email"])){ echo $_POST["email"];}?>" />
				
				<label for="username">Felhasználónév:</label><p><?php echo $usn_err;?></p>
				<input type="text" required="required" name="username" value="<?php if(isset($_POST["username"])){ echo $_POST["username"];}?>" />
				
				<label for="pass">Jelszó:</label><p><?php echo $pass_err;?></p>
				<input type="password" required="required" placeholder="*****" name="pass" value="<?php if(isset($_POST["pass"])){ echo $_POST["pass"];}?>" />
				
				<label for="pass">Jelszó még egyszer:</label>
				<input type="password" required="required" placeholder="*****" name="passc" value="<?php if(isset($_POST["passc"])){ echo $_POST["passc"];}?>"/>
				
				<input type="submit" name="reg" value="Regisztráció" />
				<a href="index.php">Mégsem</a>
			</form>
		<div>
	</body>
</html>