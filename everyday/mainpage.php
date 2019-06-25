<?php
	session_start();
	if($_SESSION["islog"]!=true){
		session_unset();
		session_destroy();
		header("index.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Every day</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="author" content="Adlan Daniel Aziz" />
		<meta name="description" content="M" />
		<link rel="stylesheet" href="style/mainpage.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
		<script src="http://code.jquery.com/color/jquery.color-2.1.2.js"></script><!--jQuery színek importja-->
		<script src="ajax.js"></script>
		<script src="javascriptFunc.js"></script>
	</head>
	<body>
		<header>
			<h1> Üdvözlünk kedves <?php echo $_SESSION["username"];?>!</h1>
			<h1 id="addanim" >NÉZZ RÁ MINDEN NAP AZ OLDALRA!!</h1>
		</header>
		
		<section>			
			<nav>
				<ul>
					<li><a href="" id="showData" >Adataim</a></li>
					<li class="dropb"><a href="">Testrészek</a>
						<ul class="dropside">
							<li><a href="">1</a></li>
							<li><a href="">2</a></li>
							<li><a href="">3</a></li>
						</ul>
					</li>
					<li><a href="">Gyakorlatok</a></li>
					<li><a href="">Edzések</a></li>
					<li><a href="">Videók</a></li>
					<li><a href="">Motiváció</a></li>
					<li><a href="logout.php">Kilépés</a></li>
				</ul>
			</nav>
			
			<article class="maincontent">			
			
			</article>	

			<article class="sidecontent">
			Reklám helye
			</article>
		</section>
		<div class="pagecontainer">
			<form class="pagecontent">
				<h1>Az ön személyes adatai</h1>
				
				<label for="fname">Vezetéknév:</label>
				<input type="text" id="d1" />
				
				<label for="sname">Keresztnév:</label>
				<input type="text" id="d2" />
				
				<label for="email">E-mail cím:</label>
				<input type="text" id="d3" />
				
				<label for="username">Felhasználónév:</label>
				<input type="text" id="d4" />
			</form>
		</div>
	</body>
</html>