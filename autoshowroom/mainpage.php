<?php
	require("connect.php");
	session_start();

	if($_SESSION["islog"]==false){
		session_destroy();
		header("Location:index.php");
	}
	if(isset($_POST["kilepes"])){
		session_unset();
		session_destroy();
		header("Location:index.php");
	}
?>
<!DOCTYPE html>
<html lang="hu">
	<head>
		<title>Autószalon</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="style/mainpage.css" />
		<script src="ajax.js"></script>
	</head>
	<body>
		<header>
			<h2><?php echo $_SESSION["username"];?></h2>
			<h1>Autószalon-nyilvántartó rendszer</h1>
			<form method="post">
				<input type="submit" name="kilepes" value="Kijelentkezés"  />
			</form>
		</header>		
		<section>
			<nav>
				<button onclick='listData("car")' >Autók</button>
				<button onclick='listData("employee")'>Alkalmazottak</button>
				<button onclick='listData("customer")'>Vevők</button>
			</nav>
			<article>
				<h1 id="address"></h1>	
				<h3 id="ressql"></h3>
				<table id="search"></table>				
				<table id="list"></table>
			</article>
		</section>
<!--Űrlapok megjelenítése----------------------------------------------------------------------------------------------------------------------------->
<!--Autó hozzáadás----------------------------------------------------------------------------------------------------------------------------->
		<div id="carins" class="container">
			<form class="content" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" autocomplete="off" >
				<h1>Új autó hozzáadása</h1>
				<span onclick='document.getElementById("carins").style.display="none";
				document.getElementById("err_mark").innerHTML="";
				document.getElementById("err_price").innerHTML="";
				document.getElementById("err_model").innerHTML="";
				document.getElementById("mark").value="";
				document.getElementById("price").value="";
				document.getElementById("model").value="";' class="close" >&times;</span>
				
				<label for="mark">Márka:</label><p id="err_mark"></p>
				<input type="text" id="mark" name="mark" required="required" />
				
				<label for="price">Ár (Ft):</label><p id="err_price"></p>
				<input type="text" id="price" name="price" required="required" />
				
				<label for="model">Modell:</label><p id="err_model"></p>
				<input type="text" id="model" name="model" required="required" />
				
				<label for="em_id">Kijelölt alkalmazott:</label>
				<select name="em_id" id="em_id" required="required" >
					<?php
						//Option-ok létrehozása az alkalmazottakhoz;
						$sql="SELECT id, firstn, secondn FROM employee
						ORDER BY firstn";
						$stmt=$conn->prepare($sql);
						$stmt->execute();
						//$stmt->bind_result($usid, $usfirstn, $ussecondn);
						//$res=$stmt->get_result();
						while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
							echo "<option value=".$row["id"].">".$row["firstn"]." ".$row["secondn"]."</option>";
						}
					?>
				</select>
				<input type="button" name="addcar" value="Hozzáadás" onclick='insDatOther("car")' />
			</form>
		</div>
<!--Autó modosítás-------------------------------------------------------------------------------------->
		<div id="caredit" class="container">
			<form class="content" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" autocomplete="off" >
				<h1><span id="carnum"></span>. id autó módosítás</h1>
				<span onclick='document.getElementById("caredit").style.display="none";
				document.getElementById("err_mark_edit").innerHTML="";
				document.getElementById("err_price_edit").innerHTML="";
				document.getElementById("err_model_edit").innerHTML="";
				document.getElementById("mark_edit").value="";
				document.getElementById("price_edit").value="";
				document.getElementById("model_edit").value="";' class="close" >&times;</span>
				
				<label for="mark_edit">Márka:</label><p id="err_mark_edit"></p>
				<input type="text" id="mark_edit" name="mark_edit" required="required" />
				
				<label for="price_edit">Ár (Ft):</label><p id="err_price_edit"></p>
				<input type="text" id="price_edit" name="price_edit" required="required" />
				
				<label for="model_edit">Modell:</label><p id="err_model_edit"></p>
				<input type="text" id="model_edit" name="model_edit" required="required" />
				
				<label for="em_id_edit">Kijelölt alkalmazott:</label>
				<select name="em_id_edit" id="em_id_edit" required="required" >
					<?php
						//Option-ok létrehozása az alkalmazottakhoz;
						$sql="SELECT id, firstn, secondn FROM employee
						ORDER BY firstn";
						$stmt=$conn->prepare($sql);
						$stmt->execute();
						//$stmt->bind_result($usid, $usfirstn, $ussecondn);
						//$res=$stmt->get_result();
						while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
							echo "<option value=".$row["id"].">".$row["firstn"]." ".$row["secondn"]."</option>";
						}
					?>
				</select>
				<input type="button" name="editcar" value="Módosítás" onclick='alterData("car")' />
				<input type="button" name="deletecar" value="Törlés" onclick='deleteData("car")' />
			</form>
		</div>
		
		
<!--ALKALMAZOTT hozzáadás----------------------------------------------------------------------------------------------------------------------------->
		<div id="empins" class="container">
			<form class="content" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" autocomplete="off" >
				<h1>Új alkalmazott hozzáadása</h1>
				<span onclick='document.getElementById("empins").style.display="none";
				document.getElementById("err_emp_firstn").innerHTML="";
				document.getElementById("err_emp_secondn").innerHTML="";
				document.getElementById("err_emp_email").innerHTML="";
				document.getElementById("emp_firstn").value="";
				document.getElementById("emp_secondn").value="";
				document.getElementById("emp_email").value="";' class="close" >&times;</span>
				
				<label for="emp_firstn">Vezetéknév:</label><p id="err_emp_firstn"></p>
				<input type="text" id="emp_firstn" name="emp_firstn" required="required" />
				
				<label for="emp_secondn">Utónév:</label><p id="err_emp_secondn"></p>
				<input type="text" id="emp_secondn" name="emp_secondn" required="required" />
				
				<label for="emp_email">E-mail:</label><p id="err_emp_email"></p>
				<input type="email" id="emp_email" name="emp_email" required="required" />

				<input type="button" name="addemp" value="Hozzáadás" onclick='insDatOther("employee")' />
			</form>
		</div>
<!--Alkalmazott modosítás-------------------------------------------------------------------------------------->
		<div id="empedit" class="container">
			<form class="content" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" autocomplete="off" >
				<h1><span id="empnum"></span>. id alkalmazott módosítás</h1>
				<span onclick='document.getElementById("empedit").style.display="none";
				document.getElementById("err_emp_firstn_edit").innerHTML="";
				document.getElementById("err_emp_secondn_edit").innerHTML="";
				document.getElementById("err_emp_email_edit").innerHTML="";
				document.getElementById("emp_firstn_edit").value="";
				document.getElementById("emp_secondn_edit").value="";
				document.getElementById("emp_email_edit").value="";' class="close" >&times;</span>
				
				<label for="emp_firstn_edit">Vezetéknév:</label><p id="err_emp_firstn_edit"></p>
				<input type="text" id="emp_firstn_edit" name="emp_firstn_edit" required="required" />
				
				<label for="emp_secondn_edit">Utónév:</label><p id="err_emp_secondn_edit"></p>
				<input type="text" id="emp_secondn_edit" name="emp_secondn_edit" required="required" />
				
				<label for="emp_email_edit">E-mail:</label><p id="err_emp_email_edit"></p>
				<input type="email" id="emp_email_edit" name="emp_email_edit" required="required" />

				<input type="button" name="editemp" value="Módosítás" onclick='alterData("employee")' />
				<input type="button" name="deleteemployee" value="Törlés" onclick='deleteData("employee")' />
			</form>
		</div>
		
<!--VEVŐK hozzáadás----------------------------------------------------------------------------------------------------------------------------->
		<div id="custins" class="container">
			<form class="content" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" autocomplete="off" >
				<h1>Új vásárló hozzáadása</h1>
				<span onclick='document.getElementById("custins").style.display="none";
				document.getElementById("err_cust_firstn").innerHTML="";
				document.getElementById("err_cust_secondn").innerHTML="";
				document.getElementById("err_cust_email").innerHTML="";
				document.getElementById("cust_firstn").value="";
				document.getElementById("cust_secondn").value="";
				document.getElementById("cust_email").value="";' class="close" >&times;</span>
				
				<label for="cust_firstn">Vezetéknév:</label><p id="err_cust_firstn"></p>
				<input type="text" id="cust_firstn" name="cust_firstn" required="required" />
				
				<label for="cust_secondn">Utónév:</label><p id="err_cust_secondn"></p>
				<input type="text" id="cust_secondn" name="cust_secondn" required="required" />
				
				<label for="cust_email">E-mail:</label><p id="err_cust_email"></p>
				<input type="email" id="cust_email" name="cust_email" required="required" />

				<input type="button" name="addcust" value="Hozzáadás" onclick='insDatOther("customer")' />
			</form>
		</div>
<!--VEVÓK modosítás-------------------------------------------------------------------------------------->
		<div id="custedit" class="container">
			<form class="content" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" autocomplete="off" >
				<h1><span id="custnum"></span>. id vásárló módosítás</h1>
				<span onclick='document.getElementById("custedit").style.display="none";
				document.getElementById("err_cust_firstn_edit").innerHTML="";
				document.getElementById("err_cust_secondn_edit").innerHTML="";
				document.getElementById("err_cust_email_edit").innerHTML="";
				document.getElementById("cust_firstn_edit").value="";
				document.getElementById("cust_secondn_edit").value="";
				document.getElementById("cust_email_edit").value="";' class="close" >&times;</span>
				
				<label for="cust_firstn_edit">Vezetéknév:</label><p id="err_cust_firstn_edit"></p>
				<input type="text" id="cust_firstn_edit" name="cust_firstn_edit" required="required" />
				
				<label for="cust_secondn_edit">Utónév:</label><p id="err_cust_secondn_edit"></p>
				<input type="text" id="cust_secondn_edit" name="cust_secondn_edit" required="required" />
				
				<label for="cust_email_edit">E-mail:</label><p id="err_cust_email_edit"></p>
				<input type="email" id="cust_email_edit" name="cust_email_edit" required="required" />

				<input type="button" name="editcust" value="Módosítás" onclick='alterData("customer")' />
				<input type="button" name="deletecustomer" value="Törlés" onclick='deleteData("customer")' />
			</form>
		</div>
		<script>
			//Űrlapok megjelenítése
			function showForm(kind){
				document.getElementById(kind).style.display="block";
			}
			//Bárhová kattintasz bezárul az űrlap
			var exarea1 = document.getElementById("carins");
			var exarea2 = document.getElementById("caredit");
			var exarea3 = document.getElementById("empins");
			var exarea4 = document.getElementById("empedit");
			var exarea5 = document.getElementById("custins");
			var exarea6 = document.getElementById("custedit");
			window.onclick = function(event) {
				if (event.target == exarea1) {
					exarea1.style.display = "none";
					document.getElementById("err_mark").innerHTML="";
					document.getElementById("err_price").innerHTML="";
					document.getElementById("err_model").innerHTML="";
					document.getElementById("mark").value="";
					document.getElementById("price").value="";
					document.getElementById("model").value="";
					document.getElementById("ressql").innerHTML="";
				}
				if (event.target == exarea2) {
					exarea2.style.display = "none";
					document.getElementById("err_mark_edit").innerHTML="";
					document.getElementById("err_price_edit").innerHTML="";
					document.getElementById("err_model_edit").innerHTML="";
					document.getElementById("mark_edit").value="";
					document.getElementById("price_edit").value="";
					document.getElementById("model_edit").value="";
					document.getElementById("ressql").innerHTML="";
				}
				if (event.target == exarea3) {
					exarea3.style.display = "none";
					document.getElementById("err_emp_firstn").innerHTML="";
					document.getElementById("err_emp_secondn").innerHTML="";
					document.getElementById("err_emp_email").innerHTML="";
					document.getElementById("emp_firstn").value="";
					document.getElementById("emp_secondn").value="";
					document.getElementById("emp_email").value="";
					document.getElementById("ressql").innerHTML="";
				}
				if (event.target == exarea4) {
					exarea4.style.display = "none";
					document.getElementById("err_emp_firstn").innerHTML="";
					document.getElementById("err_emp_secondn").innerHTML="";
					document.getElementById("err_emp_email").innerHTML="";
					document.getElementById("emp_firstn").value="";
					document.getElementById("emp_secondn").value="";
					document.getElementById("emp_email").value="";
					document.getElementById("ressql").innerHTML="";
				}
				if (event.target == exarea5) {
					exarea5.style.display = "none";
					document.getElementById("err_cust_firstn").innerHTML="";
					document.getElementById("err_cust_secondn").innerHTML="";
					document.getElementById("err_cust_email").innerHTML="";
					document.getElementById("cust_firstn").value="";
					document.getElementById("cust_secondn").value="";
					document.getElementById("cust_email").value="";
					document.getElementById("ressql").innerHTML="";
				}
				if (event.target == exarea6) {
					exarea6.style.display = "none";
					document.getElementById("err_cust_firstn").innerHTML="";
					document.getElementById("err_cust_secondn").innerHTML="";
					document.getElementById("err_cust_email").innerHTML="";
					document.getElementById("cust_firstn").value="";
					document.getElementById("cust_secondn").value="";
					document.getElementById("cust_email").value="";
					document.getElementById("ressql").innerHTML="";
				}
			}
		</script>

	</body>
</html>