<?php
	require("connect.php");
	require("funcphp.php");
	session_start();
	if($_SESSION["islog"]!=true){
		session_unset();
		session_destroy();
		header("Location:index.php");
	}
	//echo $_SESSION["email"];
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
			
		</style>
	</head>
	<body>
		<div class="jumbotron text-center">
			<h1>Üdvözöllek a weboldalon <?php echo $_SESSION["username"]?>!</h1>
		</div>
		<nav class="navbar navbar-expand-sm bg-dark nav-dark">
			
		</nav>
	</body>
</html>