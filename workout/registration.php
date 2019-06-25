<?php
	require("connect.php");
	require("funcphp.php");
	if(isset($_POST["reg"])){
			$arr1=checkLetter(clearInput($_POST["nfirst"]));
			$err1=$arr1[1];
			
			$arr2=checkLetter(clearInput($_POST["nsecond"]));
			$err2=$arr2[1];
			
			$arr3=checkCharacter(clearInput($_POST["username"]));
			$err3=$arr3[1];
			
			$arr4=checkEmail(clearInput($_POST["email"]));
			$err4=$arr4[1];
			
			$arr5=checkPassword(clearInput($_POST["pass1"]), clearInput($_POST["pass2"]));
			$err5=$arr5[1];
			
			if($arr1[0]==true && $arr2[0]==true && $arr3[0]==true && $arr4[0]==true && $arr5[0]==true){
				try{
					$flag=true;
					
					$sql="SELECT email FROM users
					WHERE email=:email";
					$stmt=$conn->prepare($sql);
					$stmt->bindParam(":email", $_POST["email"]);
					$stmt->execute();
					
					if(0<$stmt->rowCount()){
						$flag=false;
						$err4="*Ezzel az e-mail címmel már regisztráltak!";
					}
					
					$sql="SELECT * FROM users
					WHERE username=:username";
					$stmt=$conn->prepare($sql);
					$stmt->bindParam(":username", $_POST["username"]);
					$stmt->execute();

					if(0<$stmt->rowCount()){
						$flag=false;
						$err3="*Ez a felhasználónév már foglalt!";
					}
					if($flag==true){
						$sql="INSERT INTO users(username, nfirst, nsecond, email, pass)
						VALUES (:username, :nfirst, :nsecond, :email, :pass)";
						$stmt=$conn->prepare($sql);
						$stmt->bindParam(":username", $_POST["username"]);
						$stmt->bindParam(":nfirst", $_POST["nfirst"]);
						$stmt->bindParam(":nsecond", $_POST["nsecond"]);
						$stmt->bindParam(":email", $_POST["email"]);
						$stmt->bindParam(":pass", sha1($_POST["pass1"]));
						$stmt->execute();
						
						session_start();
						$_SESSION["islog"]=true;
						$_SESSION["username"]=$_POST["username"];
						$_SESSION["email"]=$_POST["email"];
						$_SESSION["pass1"]=$_POST["pass1"];
						$_SESSION["pass2"]=$_POST["pass2"];
						header("Location:mainpage.php");
					}
				}catch(PDOException $e){
					echo $e->getMessage();
				}				
			}
			
	}
?>
<!DOCTYPE html>
<html lang="hu">
	<head>
		<title>Your workout page!</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="author" content="Adlan Daniel Aziz" />
		<meta name="description" content="It is a page that motivate and help you in workout!" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script><!--jQuery library import-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"><!--import bootstrap-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script><!--import bootstrap-->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script><!--import bootstrap-->
		<style>
			input[type=text], input[type=email], input[type=password]{width:100%;}
			p{float:right; color:red;};
		</style>
	</head>
	<body>
		<div class="container">
			<div class="card mx-auto" style="border:2px solid black; max-width:500px;">
				<img src="style/regcoverp.jpg" alt="Cover picture of registration page."  class="img-fluid"/>
				<div class="card-body">
					<form method="post" autocomplete="off">
						<div class="form-group">
							<label for="nfirst">Vezetéknév:</label><p><?php if(isset($err1)) echo $err1;?></p>
							<input type="text" id="nfirst" name="nfirst" value="<?php if(isset($_POST["nfirst"])) echo $_POST["nfirst"];?>" required class="form-control" />
						</div>
						<div class="form-group">
							<label for="nsecond">Keresztnév:</label><p><?php if(isset($err2)) echo $err2;?></p>
							<input type="text" id="nsecond"  name="nsecond" value="<?php if(isset($_POST["nsecond"])) echo $_POST["nsecond"];?>" required  class="form-control" />
						</div>
						<div class="form-group">
							<label for="username">Felhasználónév:</label><p><?php if(isset($err3)) echo $err3;?></p>
							<input type="text" id="username"  name="username" value="<?php if(isset($_POST["username"])) echo $_POST["username"];?>" required  class="form-control" />
						</div>
						<div class="form-group">
							<label for="email">E-mail cím:</label><p><?php if(isset($err4)) echo $err4;?></p>
							<input type="email" id="email"  name="email" value="<?php if(isset($_POST["email"])) echo $_POST["email"];?>" required  class="form-control" />
						</div>
						<div class="form-group">
							<label for="pass1">Jelszó</label><p><?php if(isset($err5)) echo $err5;?></p>
							<input type="password" id="pass1" name="pass1" placeholder="*****" required  class="form-control"  />
						</div>
						<div class="form-group">
							<label for="pass2">Jelszó mégegyszer:</label>
							<input type="password" id="pass2" name="pass2" placeholder="*****" required  class="form-control"  />
						</div>
						<div class="row">
							<div class="col-md-6">
								<input type="submit" name="reg" value="Regisztráció" class="btn btn-success" style="width:100%" />
							</div>
							<div class="col-md-6">
								<a href="index.php" class="btn btn-success"  style="float:right; width:100%"> Főoldal</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>