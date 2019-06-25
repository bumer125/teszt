<?php
	//Bejelentkezés ellenőrzése
	require("connect.php");
	session_start();
	if($_SESSION["islog"]==false){
		session_destroy();
		header("Location:index.php");
	}
	
	//Kapott adatok tárolása
	$str=$_REQUEST["str"];
	$table=$_REQUEST["table"];
	$col=$_REQUEST["col"];
	
	$flag=null;
	$flag2=null;
	//Eredmény kiíratása;
	$write="";
	
//--------------------------------------------------------------------------------------------------------------------------------------------------------
	//Ha a táblanév autó és nem alkalmazottra keresünk
	if($table=="car" && $col!="em_id"){
		$sql="SELECT car.id, mark, price, model, firstn, secondn FROM employee, $table
		WHERE car.em_id=employee.id
		ORDER BY mark";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		//$res=$stmt->get_result();
		
		//Ha üres a kapott string, akkor írjunk ki mindent
		if($str==""){		
			if(0<$stmt->rowCount()){
				$flag="empty";
				$flag2=true;
			}else{
				$flag="A lista üres!";
				$flag2=false;
			}
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				$write.='
				<tr>
					<td>'.$row["mark"].'</td>
					<td>'.$row["price"].' Ft</td>
					<td>'.$row["model"].'</td>
					<td>'.$row["firstn"].' '.$row["secondn"].'</td>
					<td><button onclick=selectId(\'car\','.$row["id"].')>'.$row["id"].'</td>
				</tr>';
			}
		}else{ //Különben vizsgáljuk meg az egyezéseket a lekérdezett adatokkal
			$str=strtolower(trim($str));
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				if (stripos($row["$col"], $str, 0)!==FALSE){						
					if($write==""){
						$write='
						<tr>
							<td>'.$row["mark"].'</td>
							<td>'.$row["price"].' Ft</td>
							<td>'.$row["model"].'</td>
							<td>'.$row["firstn"].' '.$row["secondn"].'</td>
							<td><button onclick=selectId(\'car\','.$row["id"].')>'.$row["id"].'</td>
						</tr>';
					}else{
						$write.='
						<tr>
							<td>'.$row["mark"].'</td>
							<td>'.$row["price"].' Ft</td>
							<td>'.$row["model"].'</td>
							<td>'.$row["firstn"].' '.$row["secondn"].'</td>
							<td><button onclick=selectId(\'car\','.$row["id"].')>'.$row["id"].'</td>
						</tr>';
					}
				}
				if($write!==""){
					$flag="A keresés eredményei:";
					$flag2=true;
				}else{
					$flag="A keresett kifejezés nem található!";
					$flag2=false;
				}
			}
		}
	}
	
//----------------------------------------------------------------------------------------------------------------------------
	//Ha a táblanév autó és  alkalmazottra keresünk
	if($table=="car" && $col=="em_id"){
		$sql="SELECT car.id, mark, price, model, firstn, secondn FROM employee, $table
		WHERE car.em_id=employee.id
		ORDER BY mark";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		//$res=$stmt->get_result();
		
		if(0<$stmt->rowCount()){
			$flag="empty";
		}else{
			$flag="A lista üres!";
		}
		//Ha üres a kapott string, akkor írjunk ki mindent
		if($str==""){
			if(0<$stmt->rowCount()){
				$flag="empty";
				$flag2=true;
			}else{
				$flag="A lista üres!";
				$flag2=false;
			}
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				$write.='
				<tr>
					<td>'.$row["mark"].'</td>
					<td>'.$row["price"].' Ft</td>
					<td>'.$row["model"].'</td>
					<td>'.$row["firstn"].' '.$row["secondn"].'</td>
					<td><button onclick=selectId(\'car\','.$row["id"].')>'.$row["id"].'</td>
				</tr>';
			}
		}else{ //Különben vizsgáljuk meg az egyezéseket a lekérdezett adatokkal
			$str=strtolower(trim($str));
			$len=strlen($str);
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				if (stripos($row["firstn"], $str, 0)!==FALSE || stripos($row["secondn"], $str, 0)!==FALSE){
					if($write==""){
						$write='
						<tr>
							<td>'.$row["mark"].'</td>
							<td>'.$row["price"].' Ft</td>
							<td>'.$row["model"].'</td>
							<td>'.$row["firstn"].' '.$row["secondn"].'</td>
							<td><button onclick=selectId(\'car\','.$row["id"].')>'.$row["id"].'</td>
						</tr>';
					}else{
						$write.='
						<tr>
							<td>'.$row["mark"].'</td>
							<td>'.$row["price"].' Ft</td>
							<td>'.$row["model"].'</td>
							<td>'.$row["firstn"].' '.$row["secondn"].'</td>
							<td><button onclick=selectId(\'car\','.$row["id"].')>'.$row["id"].'</td>
						</tr>';
					}
				}
				if($write!==""){
					$flag="A keresés eredményei:";
					$flag2=true;
				}else{
					$flag="A keresett kifejezés nem található!";
					$flag2=false;
				}
			}
		}
	}
	
//------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------
	//Ha a táblanév alkalmazott
	if($table=="employee"){
		$sql="SELECT * FROM $table
		ORDER BY firstn";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		//$res=$stmt->get_result();
		
		if(0<$stmt->rowCount()){
			$flag="empty";
		}else{
			$flag="A lista üres!";
		}
		//Ha üres a kapott string, akkor írjunk ki mindent
		if($str==""){
			if(0<$stmt->rowCount()){
				$flag="empty";
				$flag2=true;
			}else{
				$flag="A lista üres!";
				$flag2=false;
			}
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				$write.='
				<tr>
					<td>'.$row["firstn"].'</td>
					<td>'.$row["secondn"].'</td>
					<td>'.$row["email"].'</td>
					<td><button onclick=selectId(\'employee\','.$row["id"].')>'.$row["id"].'</td>
				</tr>';
			}
		}else{ //Különben vizsgáljuk meg az egyezéseket alekérdezett adatokkal
			$str=strtolower(trim($str));
			$len=strlen($str);
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				if (stripos($row["$col"], $str, 0)!==FALSE){
					if($write==""){
						$write='
						<tr>
							<td>'.$row["firstn"].'</td>
							<td>'.$row["secondn"].'</td>
							<td>'.$row["email"].'</td>
							<td><button onclick=selectId(\'employee\','.$row["id"].')>'.$row["id"].'</td>
						</tr>';
					}else{
						$write.='
						<tr>
							<td>'.$row["firstn"].'</td>
							<td>'.$row["secondn"].'</td>
							<td>'.$row["email"].'</td>
							<td><button onclick=selectId(\'employee\','.$row["id"].')>'.$row["id"].'</td>
						</tr>';
					}
				}
				if($write!==""){
					$flag="A keresés eredményei:";
					$flag2=true;
				}else{
					$flag="A keresett kifejezés nem található!";
					$flag2=false;
				}
			}
		}
	}
	
//------------------------------------------------------------------------------------------------------------------------
	//Ha a táblanév alkalmazott
	if($table=="customer"){
		$sql="SELECT * FROM $table
		ORDER BY firstn";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		//$res=$stmt->get_result();
		
		if(0<$stmt->rowCount()){
			$flag="empty";
		}else{
			$flag="A lista üres!";
		}
		//Ha üres a kapott string, akkor írjunk ki mindent
		if($str==""){
			if(0<$stmt->rowCount()){
				$flag="empty";
				$flag2=true;
			}else{
				$flag="A lista üres!";
				$flag2=false;
			}
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				$write.='
				<tr>
					<td>'.$row["firstn"].'</td>
					<td>'.$row["secondn"].'</td>
					<td>'.$row["email"].'</td>
					<td><button onclick=selectId(\'employee\','.$row["id"].')>'.$row["id"].'</td>
				</tr>';
			}
		}else{ //Különben vizsgáljuk meg az egyezéseket alekérdezett adatokkal
			$str=strtolower(trim($str));
			$len=strlen($str);
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				if (stripos($row["$col"], $str, 0)!==FALSE){
					if($write==""){
						$write='
						<tr>
							<td>'.$row["firstn"].'</td>
							<td>'.$row["secondn"].'</td>
							<td>'.$row["email"].'</td>
							<td><button onclick=selectId(\'employee\','.$row["id"].')>'.$row["id"].'</td>
						</tr>';
					}else{
						$write.='
						<tr>
							<td>'.$row["firstn"].'</td>
							<td>'.$row["secondn"].'</td>
							<td>'.$row["email"].'</td>
							<td><button onclick=selectId(\'employee\','.$row["id"].')>'.$row["id"].'</td>
						</tr>';
					}
				}
				if($write!==""){
					$flag="A keresés eredményei:";
					$flag2=true;
				}else{
					$flag="A keresett kifejezés nem található!";
					$flag2=false;
				}
			}
		}
	}
	
	$resultsql=json_encode([
        'write'=>$write,
        'flag'=>$flag,
		'flag2'=>$flag2,
    ]);
	echo $resultsql;
?>