<?php
	require("connect.php");
	require("phpFunc.php");

	$fn_err=$sec_err=$e_err=$usn_err=$pass_err="";
	//Regisztráció gomb lenyomása után
	if(isset($_POST["reg"])){
		$fname=$sname=$email=$username=$pass="";
		
		//Ellenőrzések az inputokra
		//Vezetéknév
		$arr=checkLetter($_POST["fname"]);
		if($arr[0]==false){
			$fn_err=$arr[1];
		}else{
			$fname=clearInput($_POST["fname"]);
		}
		
		$arr=checkLetter($_POST["sname"]);
		//Utónév
		if($arr[0]==false){
			$sec_err=$arr[1];
		}else{
			$sname=clearInput($_POST["sname"]);
		}

		$arr=checkEmail($_POST["email"]);
		//E-mail
		if($arr[0]==false){
			$e_err=$arr[0];
		}else{
			$email=clearInput($_POST["email"]);
		}

		$arr=checkCharacter($_POST["username"]);
		//Felhasználónév
		if($arr[0]==false){
			$usn_err=$arr[1];
		}else{
			$username=clearInput($_POST["username"]);
		}
		
		$arr=checkPassword($_POST["pass"], $_POST["passc"]);
		//Jelszó
		if($arr[0]==false){
			$pass_err=$arr[1];
		}else{
			//Ha minden rendben feltöltés előtt átalakítás
			$pass=clearInput($_POST["pass"]);
			$encryptedpass=hash('sha256', $pass);
		}
		
		//Ha minden adat jó
		if($fname!="" && $sname!="" && $email!="" && $username && $pass!=""){
			$flag=true;
			try{
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
			}catch(PDOException $e){
				echo $e->getMessage();
			}
			if($flag==true){
				try{
					$sql3="INSERT INTO users(fname, sname, email, username, pass)
					VALUES(:fname,:sname,:email,:username,:pass)
					";
					//echo $stmt->num_rows();
					$stmt=$conn->prepare($sql3);
					$stmt->bindParam(":fname", $fname);
					$stmt->bindParam(":sname", $sname);
					$stmt->bindParam(":email", $email);
					$stmt->bindParam(":username", $username);
					$stmt->bindParam(":pass", $encryptedpass);
					$stmt->execute();
					
					session_start();
					$_SESSION["islog"]=true;
					$_SESSION["username"]=$username;
					
					$sql4="SELECT * FROM users
					WHERE username=:username";
					$stmt=$conn->prepare($sql4);
					$stmt->bindParam(":username", $username);
					$stmt->execute();
					
					$row=$stmt->fetch(PDO::FETCH_ASSOC);
					$_SESSION["id"]=$row["id"];
					header("Location:mainpage.php");
				}catch(PDOException $e){
					echo $e->getMessage();
				}
			}
			/*echo "<script>jqInsertData(\"users\", \"$fname\", \"$sname\", \"$email\",
			\"$username\", \"$pass\");</script>";				*/
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
	</head>
	<body>
		<h1>Regisztráció</h1>
		<h2>A regisztárcióhoz töltse ki a mezőket!</h2>
		<div id="sheet">
			<form method="post" id="regf" autocomplete="off" >
				<label for="fname">Vezetéknév:</label><p><?php if(isset($fn_err)){ echo $fn_err;}?></p>
				<input type="text" required="required"  name="fname" value="<?php if(isset($_POST["fname"])){ echo $_POST["fname"];}?>" />
				
				<label for="sname">Utónév:</label><p><?php  if(isset($sec_err)){ echo $sec_err;}?></p>
				<input type="text" required="required" name="sname" value="<?php if(isset($_POST["sname"])){ echo $_POST["sname"];} ?>" />
				
				<label for="email">E-mail cím:</label><p><?php  if(isset($e_err)){ echo $e_err;}?></p>
				<input type="email" required="required"  name="email" value="<?php if(isset($_POST["email"])){ echo $_POST["email"];}?>" />
				
				<label for="username">Felhasználónév:</label><p id="d1"><?php if(isset($usn_err)){ echo $usn_err;}?></p>
				<input type="text" required="required" name="username" value="<?php if(isset($_POST["username"])){ echo $_POST["username"];}?>" />
				
				<label for="pass">Jelszó:</label><p id="d2"><?php if(isset($pass_err)){echo $pass_err;}?></p>
				<input type="password" required="required" placeholder="*****" name="pass" value="<?php if(isset($_POST["pass"])){ echo $_POST["pass"];}?>" />
				
				<label for="pass">Jelszó még egyszer:</label>
				<input type="password" required="required" placeholder="*****" name="passc" value="<?php if(isset($_POST["passc"])){ echo $_POST["passc"];}?>"/>
				
				<input type="submit" id="reg" name="reg" value="Regisztráció" />
				<a href="index.php">Mégsem</a>
			</form>
		<div>
	</body>
</html>