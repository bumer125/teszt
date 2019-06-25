<?php
	//Bejelentkezés ellenőrzése
	require("connect.php");
	session_start();
	if($_SESSION["islog"]==false){
		session_destroy();
		header("Location:index.php");
	}
	$table=$_REQUEST["table"];
	
	$flag=null;
	$flag2=null;
	$address=null;
	$head=null;
	$r=null;
	$sel=null;
	
	if($table=="car"){
		$mark=$_REQUEST["mark"];
		$price=$_REQUEST["price"];
		$model=$_REQUEST["model"];
		$em_id=$_REQUEST["em_id"];
		
		//Kapott adatok beillesztése
		$sql="
			INSERT INTO $table(mark, price, model, em_id)
			VALUES(:mark, :price, :model, :em_id);
		";
		$stmt=$conn->prepare($sql);
		$stmt->bindParam(":mark", $mark);
		$stmt->bindParam(":price", $price);
		$stmt->bindParam(":model", $model);
		$stmt->bindParam(":em_id", $em_id);
		$stmt->execute();				
		if(0<$stmt->rowCount()){
			$flag="Sikeres hozzáadás!";
			$flag2=true;
			
		}else{
			$flag2=false;
			$flag="Sikertelen hozzáadás!";
		}
		
		//Frissített lista lekérdezése és vissazküldése
		$sql="SELECT car.id, mark, price, model, firstn, secondn FROM employee, $table
		WHERE car.em_id=employee.id
		ORDER BY mark";
		$stmt=$conn->prepare($sql);		
		$stmt->execute();
		//$stmt->bind_result($carid, $carmark, $carprice, $carmodel, $emfirstn, $emsecondn);
		//$res=$stmt->get_result();
		
		$address="Autók";
		$head='
			<tr>
				<td><input type="text" onkeyup="searchData(this.value,\'car\',\'mark\')"></td>
				<td><input type="text" onkeyup="searchData(this.value,\'car\',\'price\')"></td>
				<td><input type="text" onkeyup="searchData(this.value,\'car\',\'model\')"></td>
				<td><input type="text" onkeyup="searchData(this.value,\'car\',\'em_id\')"></td>
				<td><button onclick=showForm(\'carins\')>Új hozzáadás</button></td>
			</tr>
			<tr>
				<th>Márka</th>
				<th>Ár</th>
				<th>Modell</th>
				<th>Felelős alklamazott</th>
				<th>Módosítás</th>
			</tr>
		';
		//Adatok kilitázása
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$r.='
			<tr>
				<td>'.$row["mark"].'</td>
				<td>'.$row["price"].' Ft</td>
				<td>'.$row["model"].'</td>
				<td>'.$row["firstn"].' '.$row["secondn"].'</td>
				<td><button onclick=selectId(\'car\','.$row["id"].')>'.$row["id"].'</td>
			</tr>';
		}
	}
///////////////////////////////////////////////////////////////////////////////////////
//Ha a tábla alkalmazott
	if($table=="employee"){
		$firstn=$_REQUEST["firstn"];
		$secondn=$_REQUEST["secondn"];
		$email=$_REQUEST["email"];
		
		//Kapott adatok beillesztése
		$sql="
			INSERT INTO $table(firstn, secondn, email)
			VALUES(:firstn, :secondn, :email);
		";
		$stmt=$conn->prepare($sql);
		$stmt->bindParam(":firstn", $firstn);
		$stmt->bindParam("secondn", $secondn);
		$stmt->bindParam("email",  $email);
		$stmt->execute();
		if(0<$stmt->rowCount()){
			$flag="Sikeres hozzáadás!";
			$flag2=true;			
		}else{
			$flag2=false;
			$flag="Sikertelen hozzáadás!";
		}	
		
		//Frissített lista lekérdezése és vissazküldése
		$sql="SELECT id, firstn, secondn, email FROM $table
		ORDER BY firstn";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		//$stmt->bind_result($eid, $efirstn, $esecondn, $eemail);
		//$res=$stmt->get_result();
		
		$address="Alkalmazottak";
		$head='
			<tr>
				<td><input type="text" onkeyup="searchData(this.value,\'employee\',\'firstn\')"></td>
				<td><input type="text" onkeyup="searchData(this.value,\'employee\',\'secondn\')"></td>
				<td><input type="text" onkeyup="searchData(this.value,\'employee\',\'email\')"></td>
				<td><button onclick=showForm(\'empins\')>Új hozzáadás</button></td>
			</tr>
			<tr>
				<th>Vezetéknév</th>
				<th>Utónév</th>
				<th>E-mail</th>
				<th>Módosítás</th>
			</tr>
		';
		
		//Adatok kilitázása
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$r.='
			<tr>
				<td>'.$row["firstn"].'</td>
				<td>'.$row["secondn"].'</td>
				<td>'.$row["email"].'</td>
				<td><button onclick=selectId(\'employee\','.$row["id"].')>'.$row["id"].'</td>
			</tr>';
		}
		$sql="SELECT id, firstn, secondn FROM employee
		ORDER BY firstn";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		//$stmt->bind_result($usid, $usfirstn, $ussecondn);
						//$res=$stmt->get_result();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$sel.="<option value=".$row["id"].">".$row["firstn"]." ".$row["secondn"]."</option>";
		}
	}
///////////////////////////////////////////////////////////////////////////////////////
//Ha a tábla vevő
	if($table=="customer"){
		$firstn=$_REQUEST["firstn"];
		$secondn=$_REQUEST["secondn"];
		$email=$_REQUEST["email"];
		
		//Kapott adatok beillesztése
		$sql="
			INSERT INTO $table(firstn, secondn, email)
			VALUES(:firstn, :secondn, :email);
		";
		$stmt=$conn->prepare($sql);
		$stmt->bindParam(":firstn", $firstn);
		$stmt->bindParam("secondn", $secondn);
		$stmt->bindParam("email",  $email);
		$stmt->execute();	
		if(0<$stmt->rowCount()){
			$flag="Sikeres hozzáadás!";
			$flag2=true;
		
		}else{
			$flag2=false;
			$flag="Sikertelen hozzáadás!";
		}		
		
		//Frissített lista lekérdezése és vissazküldése
		$sql="SELECT id, firstn, secondn, email FROM $table
		ORDER BY firstn";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		//$stmt->bind_result($cid, $cfirstn, $csecondn, $cemail);
		//$res=$stmt->get_result();
		
		$address="Vásárlók";
		$head='
			<tr>
				<td><input type="text" onkeyup="searchData(this.value,\'customer\',\'firstn\')"></td>
				<td><input type="text" onkeyup="searchData(this.value,\'customer\',\'secondn\')"></td>
				<td><input type="text" onkeyup="searchData(this.value,\'customer\',\'email\')"></td>
				<td><button onclick=showForm(\'custins\')>Új hozzáadás</button></td>
			</tr>
			<tr>
				<th>Vezetéknév</th>
				<th>Utónév</th>
				<th>E-mail</th>
				<th>Módosítás</th>
			</tr>
		';
		
		//Adatok kilitázása
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$r.='
			<tr>
				<td>'.$row["firstn"].'</td>
				<td>'.$row["secondn"].'</td>
				<td>'.$row["email"].'</td>
				<td><button onclick=selectId(\'customer\','.$row["id"].')>'.$row["id"].'</td>
			</tr>';
		}
	}
	
	$resultsql=json_encode([
        'flag'=>$flag,
        'flag2'=>$flag2,
        'head'=>$head,
        'address'=>$address,
        'r'=>$r,
		'sel'=>$sel,
    ]);
	echo $resultsql;
?>