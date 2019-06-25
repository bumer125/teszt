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
	$jump=null;
	$sel=null;
	
	if($table=="car"){
		$id=$_REQUEST["id"];
		
		//Kapott id alapján módosítás
		$sql="
			DELETE FROM $table
			WHERE id=:id
		";
		$stmt=$conn->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();
		if(0<$stmt->rowCount()){
			$flag="Sikeres törlés!";
			$flag2=true;
		}else{
			$flag2=false;
			$flag="Sikertelen törlés!";			
		}		
		
		//Frissített lista visszaküldése
		$sql="SELECT car.id, mark, price, model, firstn, secondn FROM employee, $table
		WHERE car.em_id=employee.id
		ORDER BY mark";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		//$stmt->bind_result($carid, $carmark, $carprice, $carmodel, $emfirstn, $emsecondn);
		
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
//////////////////////////////////////////////////////////////////////////////////////
	if($table=="employee"){
		$id=$_REQUEST["id"];
		$sql="
			SELECT * FROM car
			WHERE em_id=:id
		";
		$stmt=$conn->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();
		//$stmt->store_result();
		if(0<$stmt->rowCount()){
			$jump="Ez az alkalmazott autóért felelős! Nem törölhető!";
		}else{	
		//Kapott id alapján módosítás
			$sql="
				DELETE FROM $table
				WHERE id=:id;
			";
			$stmt=$conn->prepare($sql);
			$stmt->bindParam(":id", $id);
			$stmt->execute();
			if(0<$stmt->rowCount()){
				$flag="Sikeres törlés!";
				$flag2=true;
				
			}else{
				$flag2=false;
				$flag="Sikertelen törlés!";
			}
		}			
		
		//Frissített lista visszaküldése
		$sql="SELECT id, firstn, secondn, email FROM $table
		ORDER BY firstn";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		//$stmt->bind_result($eid, $efirstn, $esecondn, $eemail);
		
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
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
	if($table=="customer"){
		$id=$_REQUEST["id"];
		
		//Kapott id alapján módosítás
		$sql="
			DELETE FROM $table
			WHERE id=:id
		";
		$stmt=$conn->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();
		if(0<$stmt->rowCount()){
			$flag="Sikeres törlés!";
			$flag2=true;		
		}else{
			$flag2=false;
			$flag="Sikertelen törlés!";
		}			
		
		//Frissített lista visszaküldése
		$sql="SELECT id, firstn, secondn, email FROM $table
		ORDER BY firstn";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		//$stmt->bind_result($cid, $cfirstn, $csecondn, $cemail);
		
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
        'jump'=>$jump,
		'sel'=>$sel,
    ]);
	echo $resultsql;
//////////////////////////////////////////////////////////////////////////////////////
?>