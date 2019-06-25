<?php
	require("connect.php");
	if(isset($_POST["kuld"])){
		$sql="SELECT * FROM users
		WHERE username=:username";
		$stmt=$conn->prepare($sql);
		$stmt->bindParam(":username", $_POST["username"]);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		
		if(0<$stmt->rowCount()){
			if(sha1($_POST["pass"])==$row["pass"]){
				session_start();
				$_SESSION["islog"]=true;
				$_SESSION["username"]=$_POST["username"];
				$_SESSION["email"]=$row["email"];
				header("Location:mainpage.php");
			}else{
				$err="*Hibás felhasználónév vagy jelszó!";
			}
		}else{
			$err="*Hibás felhasználónév vagy jelszó!";
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
			p{float:right; color:red;}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="card mx-auto mt-5" style="max-width:500px; border:2px solid black;" >					
				<video controls autoplay muted style="max-width:100%; ">
					<source src="style/intro.mp4" type="video/mp4" />
					Ez egy motivációs videó.
				</video>
				<div class="card-body">
					<form method="post" autocomplete="off">
						<div class="form-group">
							<label for="username">Felhasználónév:</label><p><?php if(isset($err)) echo $err; ?></p>
							<input type="text" id="username" name="username" placeholder="Username" required class="form-control" /><br />
						</div>
						<div class="form-group">
							<label for="pass">Jelszó:</label>
							<input type="password" id="pass" name="pass" placeholder="*****" required class="form-control" /><br />
						</div>
						<div class="row">
							<div class="col-md-6"><!--responsive appear on medium 768px device-->
								<input type="submit" name="kuld" value="Bejelentkezés"  class="btn btn-success" style="width:100%;" />
							</div>	
							<div class="col-md-6"><!--responsive appear on medium 768px device-->
								<a href="registration.php" class="btn btn-success float-right" style="width:100%;">Regisztráció</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>