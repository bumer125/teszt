<?php
	require("connect.php");
	function clearInput($data){
		$data=trim($data);
		$data=htmlspecialchars($data);
		$data=stripcslashes($data);
		return $data;
	}
	function checkLetter($data){
		$arr;
		if(preg_match("/^[ a-záéiíoóöőuúüűÁÉIÍOÓÖŐUÚÜŰA-Z ]*$/", $data)){
			$arr[0]=true;
			$arr[1]="";
		}else{
			$arr[0]=false;
			$arr[1]="*Csak betűk megengedettek!";
		}
		return $arr;
	}		
	//Ellenőrzés: csak betűket és számokat tartalmazhat (Username)
	function checkCharacter($data){
		$arr;
		if(preg_match("/^[a-záéiíoóöőuúüűÁÉIÍOÓÖŐUÚÜŰA-Z0-9]*$/", $data)){
			$arr[0]=true;
			$arr[1]="";
		}else{
			$arr[0]=false;
			$arr[1]="*Csak betűk és számok megengedettek!";
		}
		return $arr;
	}	
	//Ellenőrzés: e-mail cím valós
	function checkEmail($data){
		$arr;
		if(filter_has_var(INPUT_POST, "email")){
			$arr[0]=true;
			$arr[1]="";
		}else{
			$arr[0]=false;
			$arr[1]="Nem e-mail címet adott meg!";
		}
		return $arr;
	}
	function checkPassword($pass1, $pass2){
		$arr;
		if($pass1!=$pass2){
			$arr[0]=false;
			$arr[1]="*A jelszavak nem egyeznek!";
		}elseif(strlen($pass1)<7){
			$arr[0]=false;
			$arr[1]="*A jelszónak lgalább 7 karakterből kell állnia!";
		}elseif(20<strlen($pass1)){
			$arr[0]=false;
			$arr[1]="*A jelszó maximum 20 karakterből állhat!";
		}else{
			$arr[0]=true;
			$arr[1]="";
		}
		return $arr;
	}
?>