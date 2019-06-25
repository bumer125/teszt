//Új adat felvitele
/*function insertData(table, mark, price, model, em_id){
	//document.getElementById("d1").innerHTML="valami";	
	var xhttp=new XMLHttpRequest();
	xhttp.onreadystatechange=function(){
		if(this.status==200 && this.readyState==4){
			var parts = this.responseText.split('|');
			document.getElementById("address").innerHTML=parts[0];
			document.getElementById("search").innerHTML=parts[1];
			document.getElementById("list").innerHTML=parts[2];
		}
	};
	xhttp.open("POST", "http://localhost/autoshowroom/ajaxinsert.php?table="+table+"&mark="+mark+"&price="+price+"&model="+model+"&em_id="+em_id, true);
	xhttp.send();
}*/

//Függvény az egyes adatok listázásához
function listData(table){
	//A paraméter a tábla neve
	var xhttp=new XMLHttpRequest();
	xhttp.onreadystatechange=function(){
		if(this.status==200 && this.readyState==4){
			var jsobj=JSON.parse(this.responseText);
			if(jsobj.flag2==false){
				document.getElementById("ressql").innerHTML=jsobj.flag;
				document.getElementById("ressql").style.color="red";
			}else{
				document.getElementById("ressql").style.color="green";
				document.getElementById("ressql").innerHTML="";				
			}
			document.getElementById("address").innerHTML=jsobj.address;
			document.getElementById("search").innerHTML=jsobj.head;
			document.getElementById("list").innerHTML=jsobj.r;
			if(jsobj.sel!=null){
				document.getElementById('em_id').innerHTML=jsobj.sel;
				document.getElementById('em_id_edit').innerHTML=jsobj.sel;
			}
		}
	};
	xhttp.open("POST", "http://localhost/autoshowroom/ajaxlist.php?table="+table, true);
	xhttp.send();
}

//Függvény az adatok kereséséhez
function searchData(str, table, col){
	var xhttp=new XMLHttpRequest();
	xhttp.onreadystatechange=function(){
		if(this.status==200 && this.readyState==4){
			var jsobj=JSON.parse(this.responseText);
			if(jsobj.flag2==false){
				document.getElementById("ressql").innerHTML=jsobj.flag;
				document.getElementById("ressql").style.color="red";
			}else if(jsobj.flag2==true && jsobj.flag!="empty"){
				document.getElementById("ressql").innerHTML=jsobj.flag;
				document.getElementById("ressql").style.color="green";
			}else if(jsobj.flag=="empty"){
				document.getElementById("ressql").innerHTML="";
			}
			document.getElementById("list").innerHTML=jsobj.write;
		}
	};
	xhttp.open("POST", "http://localhost/autoshowroom/ajaxsearch.php?str="+str+"&table="+table+"&col="+col, true);
	xhttp.send();
}


//Adatok beillesztése az adatbázisba
function insDatOther(table){
	var flag=true;
	
	if(table=="car"){
		//Ha a gomb lenyomva akkor az inputok elmentése
		var mark=document.getElementById("mark").value;
		var price=document.getElementById("price").value;
		var model=document.getElementById("model").value;
		var em_id=document.getElementById("em_id").value;
		
		var regex_letter=/^[ a-záéiíoóöőuúüűÁÉIÍOÓÖŐUÚÜŰA-Z ]+$/;
		var regex_char=/^[a-záéiíoóöőuúüűÁÉIÍOÓÖŐUÚÜŰA-Z0-9]+$/;
		var regex_num=/^[0-9]+$/;
		
		//Szűrés
		if(mark==""){
			flag=false;
			document.getElementById("err_mark").innerHTML="* Üresen hagyta a mezőt!";
		}
		else if(regex_letter.test(mark)==false){
			flag=false;
			document.getElementById("err_mark").innerHTML="* Csak betűk megengedettek!";
		}else{
			document.getElementById("err_mark").innerHTML="";
		}
		
		if(price==""){
			flag=false;
			document.getElementById("err_price").innerHTML="* Üresen hagyta a mezőt!";
		}
		else if(regex_num.test(price)==false){
			flag=false;
			document.getElementById("err_price").innerHTML="* Csak számok megengedettek!";
		}else{
			document.getElementById("err_price").innerHTML="";
		}
		
		if(model==""){
			flag=false;
			document.getElementById("err_model").innerHTML="* Üresen hagyta a mezőt!";
		}
		else if(regex_char.test(model)==false){
			flag=false;
			document.getElementById("err_model").innerHTML="* Csak characterek megengedettek!";
		}else{
			document.getElementById("err_model").innerHTML="";
		}
		
		//Ha minden rendben akkor küldés a php oldalhoz
		if(flag==true && table=="car"){
			var xhttp=new XMLHttpRequest();
			xhttp.onreadystatechange=function(){
				if(this.status==200 && this.readyState==4){
					var jsobj=JSON.parse(this.responseText);
					if(jsobj.flag2==false){
						document.getElementById("ressql").innerHTML=jsobj.flag;
						document.getElementById("ressql").style.color="red";
					}else{
						document.getElementById("ressql").style.color="green";
						document.getElementById("ressql").innerHTML=jsobj.flag;
					}
					document.getElementById("address").innerHTML=jsobj.address;
					document.getElementById("search").innerHTML=jsobj.head;
					document.getElementById("list").innerHTML=jsobj.r;
					
					document.getElementById("mark").value="";
					document.getElementById("price").value="";
					document.getElementById("model").value="";
					document.getElementById("em_id").value="";
				}
			};
			xhttp.open("POST", "http://localhost/autoshowroom/ajaxinsert.php?table="+table+"&mark="+mark+"&price="+price+"&model="+model+"&em_id="+em_id, true);
			xhttp.send();
			document.getElementById("carins").style.display="none";
		}
	}
	
//Ha a beillesztendő tábla employee
	if(table=="employee"){
		//Ha a gomb lenyomva akkor az inputok elmentése
		var firstn=document.getElementById("emp_firstn").value;
		var secondn=document.getElementById("emp_secondn").value;
		var email=document.getElementById("emp_email").value;
		
		var regex_letter=/^[ a-záéiíoóöőuúüűÁÉIÍOÓÖŐUÚÜŰA-Z ]+$/;
		var regex_char=/^[a-záéiíoóöőuúüűÁÉIÍOÓÖŐUÚÜŰA-Z0-9\@]+$/;
		var regex_email=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		
		//Szűrés
		if(firstn==""){
			flag=false;
			document.getElementById("err_emp_firstn").innerHTML="* Üresen hagyta a mezőt!";
		}
		else if(regex_letter.test(firstn)==false){
			flag=false;
			document.getElementById("err_emp_firstn").innerHTML="* Csak betűk megengedettek!";
		}else{
			document.getElementById("err_emp_firstn").innerHTML="";
		}
		/////
		if(secondn==""){
			flag=false;
			document.getElementById("err_emp_secondn").innerHTML="* Üresen hagyta a mezőt!";
		}
		else if(regex_letter.test(secondn)==false){
			flag=false;
			document.getElementById("err_emp_secondn").innerHTML="* Csak betűk megengedettek!";
		}else{
			document.getElementById("err_emp_secondn").innerHTML="";
		}
		/////
		if(email==""){
			flag=false;
			document.getElementById("err_emp_email").innerHTML="* Üresen hagyta a mezőt!";
		}
		else if(regex_email.test(email)==false){
			flag=false;
			document.getElementById("err_emp_email").innerHTML="* Nem e-mail címet adott meg!";
		}else{
			document.getElementById("err_emp_email").innerHTML="";
		}
		
		//Ha minden rendben akkor küldés a php oldalhoz
		if(flag==true && table=="employee"){
			var xhttp=new XMLHttpRequest();
			xhttp.onreadystatechange=function(){
				if(this.status==200 && this.readyState==4){
					var jsobj=JSON.parse(this.responseText);
					if(jsobj.flag2==false){
						document.getElementById("ressql").innerHTML=jsobj.flag;
						document.getElementById("ressql").style.color="red";
					}else{
						document.getElementById("ressql").style.color="green";
						document.getElementById("ressql").innerHTML=jsobj.flag;
					}
					document.getElementById("address").innerHTML=jsobj.address;
					document.getElementById("search").innerHTML=jsobj.head;
					document.getElementById("list").innerHTML=jsobj.r;
					if(jsobj.sel!=null){
						document.getElementById('em_id').innerHTML=jsobj.sel;
						document.getElementById('em_id_edit').innerHTML=jsobj.sel;
					}
					document.getElementById("emp_firstn").value="";
					document.getElementById("emp_secondn").value="";
					document.getElementById("emp_email").value="";
				}
			};
			xhttp.open("POST", "http://localhost/autoshowroom/ajaxinsert.php?table="+table+"&firstn="+firstn+"&secondn="+secondn+"&email="+email, true);
			xhttp.send();
			document.getElementById("empins").style.display="none";
		}
	}
	
//Ha a beillesztendő tábla customer
	if(table=="customer"){
		//Ha a gomb lenyomva akkor az inputok elmentése
		var firstn=document.getElementById("cust_firstn").value;
		var secondn=document.getElementById("cust_secondn").value;
		var email=document.getElementById("cust_email").value;
		
		var regex_letter=/^[ a-záéiíoóöőuúüűÁÉIÍOÓÖŐUÚÜŰA-Z ]+$/;
		var regex_char=/^[a-záéiíoóöőuúüűÁÉIÍOÓÖŐUÚÜŰA-Z0-9\@]+$/;
		var regex_email=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		
		//Szűrés
		if(firstn==""){
			flag=false;
			document.getElementById("err_cust_firstn").innerHTML="* Üresen hagyta a mezőt!";
		}
		else if(regex_letter.test(firstn)==false){
			flag=false;
			document.getElementById("err_cust_firstn").innerHTML="* Csak betűk megengedettek!";
		}else{
			document.getElementById("err_cust_firstn").innerHTML="";
		}
		/////
		if(secondn==""){
			flag=false;
			document.getElementById("err_cust_secondn").innerHTML="* Üresen hagyta a mezőt!";
		}
		else if(regex_letter.test(secondn)==false){
			flag=false;
			document.getElementById("err_cust_secondn").innerHTML="* Csak betűk megengedettek!";
		}else{
			document.getElementById("err_cust_secondn").innerHTML="";
		}
		/////
		if(email==""){
			flag=false;
			document.getElementById("err_cust_email").innerHTML="* Üresen hagyta a mezőt!";
		}
		else if(regex_email.test(email)==false){
			flag=false;
			document.getElementById("err_cust_email").innerHTML="* Nem e-mail címet adott meg!";
		}else{
			document.getElementById("err_cust_email").innerHTML="";
		}
		
		//Ha minden rendben akkor küldés a php oldalhoz
		if(flag==true && table=="customer"){
			var xhttp=new XMLHttpRequest();
			xhttp.onreadystatechange=function(){
				if(this.status==200 && this.readyState==4){
					var jsobj=JSON.parse(this.responseText);
					if(jsobj.flag2==false){
						document.getElementById("ressql").innerHTML=jsobj.flag;
						document.getElementById("ressql").style.color="red";
					}else{
						document.getElementById("ressql").style.color="green";
						document.getElementById("ressql").innerHTML=jsobj.flag;
					}
					document.getElementById("address").innerHTML=jsobj.address;
					document.getElementById("search").innerHTML=jsobj.head;
					document.getElementById("list").innerHTML=jsobj.r;
					
					document.getElementById("cust_firstn").value="";
					document.getElementById("cust_secondn").value="";
					document.getElementById("cust_email").value="";
				}
			};
			xhttp.open("POST", "http://localhost/autoshowroom/ajaxinsert.php?table="+table+"&firstn="+firstn+"&secondn="+secondn+"&email="+email, true);
			xhttp.send();
			document.getElementById("custins").style.display="none";
		}
	}
}


//Sor kiválasztása id alapján a módosításhoz
//ajaxlist.php hívja
function selectId(table, id){
	if(table=="car"){
		var xhttp=new XMLHttpRequest();
		xhttp.onreadystatechange=function(){
			if(this.status==200 && this.readyState==4){
				var jsobj=JSON.parse(this.responseText);
				document.getElementById("mark_edit").value=jsobj.sendmark;
				document.getElementById("price_edit").value=jsobj.sendprice;
				document.getElementById("model_edit").value=jsobj.sendmodel;
				document.getElementById("em_id_edit").value=jsobj.sendem_id;
				document.getElementById("carnum").innerHTML=jsobj.sendid;
			}
		};
		xhttp.open("POST", "http://localhost/autoshowroom/ajaxselect.php?table="+table+"&id="+id, true);
		xhttp.send();
		document.getElementById("caredit").style.display="block";
	}
	if(table=="employee"){
		var xhttp=new XMLHttpRequest();
		xhttp.onreadystatechange=function(){
			if(this.status==200 && this.readyState==4){
				var jsobj=JSON.parse(this.responseText);
				document.getElementById("emp_firstn_edit").value=jsobj.sendfirstn;
				document.getElementById("emp_secondn_edit").value=jsobj.sendsecondn;
				document.getElementById("emp_email_edit").value=jsobj.sendemail;
				document.getElementById("empnum").innerHTML=jsobj.sendid;
			}
		};
		xhttp.open("POST", "http://localhost/autoshowroom/ajaxselect.php?table="+table+"&id="+id, true);
		xhttp.send();
		document.getElementById("empedit").style.display="block";
	}
	if(table=="customer"){
		var xhttp=new XMLHttpRequest();
		xhttp.onreadystatechange=function(){
			if(this.status==200 && this.readyState==4){
				var jsobj=JSON.parse(this.responseText);
				document.getElementById("cust_firstn_edit").value=jsobj.sendfirstn;
				document.getElementById("cust_secondn_edit").value=jsobj.sendsecondn;
				document.getElementById("cust_email_edit").value=jsobj.sendemail;
				document.getElementById("custnum").innerHTML=jsobj.sendid;
			}
		};
		xhttp.open("POST", "http://localhost/autoshowroom/ajaxselect.php?table="+table+"&id="+id, true);
		xhttp.send();
		document.getElementById("custedit").style.display="block";
	}
}

//Módosított adatok küldése
function alterData(table){
	var flag=true;
	//Ha a módosítandó tábla autó
	if(table=="car"){
		var mark=document.getElementById("mark_edit").value;
		var price=document.getElementById("price_edit").value;
		var model=document.getElementById("model_edit").value;
		var em_id=document.getElementById("em_id_edit").value;
		var id=document.getElementById("carnum").innerHTML;
		
		var regex_letter=/^[ a-záéiíoóöőuúüűÁÉIÍOÓÖŐUÚÜŰA-Z ]+$/;
		var regex_char=/^[a-záéiíoóöőuúüűÁÉIÍOÓÖŐUÚÜŰA-Z0-9]+$/;
		var regex_num=/^[0-9]+$/;
		
		//Szűrés
		if(mark==""){
			flag=false;
			document.getElementById("err_mark_edit").innerHTML="* Üresen hagyta a mezőt!";
		}
		else if(regex_letter.test(mark)==false){
			flag=false;
			document.getElementById("err_mark_edit").innerHTML="* Csak betűk megengedettek!";
		}else{
			document.getElementById("err_mark_edit").innerHTML="";
		}
		
		if(price==""){
			flag=false;
			document.getElementById("err_price_edit").innerHTML="* Üresen hagyta a mezőt!";
		}
		else if(regex_num.test(price)==false){
			flag=false;
			document.getElementById("err_price_edit").innerHTML="* Csak számok megengedettek!";
		}else{
			document.getElementById("err_price_edit").innerHTML="";
		}
		
		if(model==""){
			flag=false;
			document.getElementById("err_model_edit").innerHTML="* Üresen hagyta a mezőt!";
		}
		else if(regex_char.test(model)==false){
			flag=false;
			document.getElementById("err_model_edit").innerHTML="* Csak characterek megengedettek!";
		}else{
			document.getElementById("err_model_edit").innerHTML="";
		}
		
		//Ha minden randben akkor küldés a php oldalhoz
		if(flag==true && table=="car"){
			var xhttp=new XMLHttpRequest();
			xhttp.onreadystatechange=function(){
				if(this.status==200 && this.readyState==4){
					var jsobj=JSON.parse(this.responseText);
					if(jsobj.flag2==false){
						document.getElementById("ressql").innerHTML=jsobj.flag;
						document.getElementById("ressql").style.color="red";
					}else{
						document.getElementById("ressql").style.color="green";
						document.getElementById("ressql").innerHTML=jsobj.flag;
					}
					document.getElementById("address").innerHTML=jsobj.address;
					document.getElementById("search").innerHTML=jsobj.head;
					document.getElementById("list").innerHTML=jsobj.r;
					
					document.getElementById("mark_edit").value="";
					document.getElementById("price_edit").value="";
					document.getElementById("model_edit").value="";
					document.getElementById("em_id_edit").value="";
					document.getElementById("carnum").innerHTML="";
				}
			};
			xhttp.open("POST", "http://localhost/autoshowroom/ajaxalter.php?table="+table+"&mark="+mark+"&price="+price+"&model="+model+"&em_id="+em_id+"&id="+id, true);
			xhttp.send();
			document.getElementById("caredit").style.display="none";		
		}
	}
/////////////////////////////////////////////////////////////////////////////	
//Ha a módosítandó tábla employee
	if(table=="employee"){
		//Ha a gomb lenyomva akkor az inputok elmentése
		var firstn=document.getElementById("emp_firstn_edit").value;
		var secondn=document.getElementById("emp_secondn_edit").value;
		var email=document.getElementById("emp_email_edit").value;
		var id=document.getElementById("empnum").innerHTML;
		
		var regex_letter=/^[ a-záéiíoóöőuúüűÁÉIÍOÓÖŐUÚÜŰA-Z ]+$/;
		var regex_char=/^[a-záéiíoóöőuúüűÁÉIÍOÓÖŐUÚÜŰA-Z0-9\@]+$/;
		var regex_email=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		
		//Szűrés
		if(firstn==""){
			flag=false;
			document.getElementById("err_emp_firstn_edit").innerHTML="* Üresen hagyta a mezőt!";
		}
		else if(regex_letter.test(firstn)==false){
			flag=false;
			document.getElementById("err_emp_firstn_edit").innerHTML="* Csak betűk megengedettek!";
		}else{
			document.getElementById("err_emp_firstn_edit").innerHTML="";
		}
		/////
		if(secondn==""){
			flag=false;
			document.getElementById("err_emp_secondn_edit").innerHTML="* Üresen hagyta a mezőt!";
		}
		else if(regex_letter.test(secondn)==false){
			flag=false;
			document.getElementById("err_emp_secondn_edit").innerHTML="* Csak betűk megengedettek!";
		}else{
			document.getElementById("err_emp_secondn_edit").innerHTML="";
		}
		/////
		if(email==""){
			flag=false;
			document.getElementById("err_emp_email_edit").innerHTML="* Üresen hagyta a mezőt!";
		}
		else if(regex_email.test(email)==false){
			flag=false;
			document.getElementById("err_emp_email_edit").innerHTML="* Nem e-mail címet adott meg!";
		}else{
			document.getElementById("err_emp_email_edit").innerHTML="";
		}
		
		//Ha minden rendben akkor küldés a php oldalhoz
		if(flag==true && table=="employee"){
			var xhttp=new XMLHttpRequest();
			xhttp.onreadystatechange=function(){
				if(this.status==200 && this.readyState==4){
					var jsobj=JSON.parse(this.responseText);
					if(jsobj.flag2==false){
						document.getElementById("ressql").innerHTML=jsobj.flag;
						document.getElementById("ressql").style.color="red";
					}else{
						document.getElementById("ressql").style.color="green";
						document.getElementById("ressql").innerHTML=jsobj.flag;
					}
					document.getElementById("address").innerHTML=jsobj.address;
					document.getElementById("search").innerHTML=jsobj.head;
					document.getElementById("list").innerHTML=jsobj.r;
					if(jsobj.sel!=null){
						document.getElementById('em_id').innerHTML=jsobj.sel;
						document.getElementById('em_id_edit').innerHTML=jsobj.sel;
					}
					
					document.getElementById("emp_firstn_edit").value="";
					document.getElementById("emp_secondn_edit").value="";
					document.getElementById("emp_email_edit").value="";
					document.getElementById("empnum").innerHTML="";
				}
			};
			xhttp.open("POST", "http://localhost/autoshowroom/ajaxalter.php?table="+table+"&firstn="+firstn+"&secondn="+secondn+"&email="+email+"&id="+id, true);
			xhttp.send();
			document.getElementById("empedit").style.display="none";		
		}
	}
/////////////////////////////////////////////////////////////////////////////	
//Ha a módosítandó tábla vásárló
	if(table=="customer"){
		//Ha a gomb lenyomva akkor az inputok elmentése
		var firstn=document.getElementById("cust_firstn_edit").value;
		var secondn=document.getElementById("cust_secondn_edit").value;
		var email=document.getElementById("cust_email_edit").value;
		var id=document.getElementById("custnum").innerHTML;
		
		var regex_letter=/^[ a-záéiíoóöőuúüűÁÉIÍOÓÖŐUÚÜŰA-Z ]+$/;
		var regex_char=/^[a-záéiíoóöőuúüűÁÉIÍOÓÖŐUÚÜŰA-Z0-9\@]+$/;
		var regex_email=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		
		//Szűrés
		if(firstn==""){
			flag=false;
			document.getElementById("err_cust_firstn_edit").innerHTML="* Üresen hagyta a mezőt!";
		}
		else if(regex_letter.test(firstn)==false){
			flag=false;
			document.getElementById("err_cust_firstn_edit").innerHTML="* Csak betűk megengedettek!";
		}else{
			document.getElementById("err_cust_firstn_edit").innerHTML="";
		}
		/////
		if(secondn==""){
			flag=false;
			document.getElementById("err_cust_secondn_edit").innerHTML="* Üresen hagyta a mezőt!";
		}
		else if(regex_letter.test(secondn)==false){
			flag=false;
			document.getElementById("err_cust_secondn_edit").innerHTML="* Csak betűk megengedettek!";
		}else{
			document.getElementById("err_cust_secondn_edit").innerHTML="";
		}
		/////
		if(email==""){
			flag=false;
			document.getElementById("err_cust_email_edit").innerHTML="* Üresen hagyta a mezőt!";
		}
		else if(regex_email.test(email)==false){
			flag=false;
			document.getElementById("err_cust_email_edit").innerHTML="* Nem e-mail címet adott meg!";
		}else{
			document.getElementById("err_cust_email_edit").innerHTML="";
		}
		
		//Ha minden rendben akkor küldés a php oldalhoz
		if(flag==true && table=="customer"){
			var xhttp=new XMLHttpRequest();
			xhttp.onreadystatechange=function(){
				if(this.status==200 && this.readyState==4){
					var jsobj=JSON.parse(this.responseText);
					if(jsobj.flag2==false){
						document.getElementById("ressql").innerHTML=jsobj.flag;
						document.getElementById("ressql").style.color="red";
					}else{
						document.getElementById("ressql").style.color="green";
						document.getElementById("ressql").innerHTML=jsobj.flag;
					}
					document.getElementById("address").innerHTML=jsobj.address;
					document.getElementById("search").innerHTML=jsobj.head;
					document.getElementById("list").innerHTML=jsobj.r;
					
					document.getElementById("cust_firstn_edit").value="";
					document.getElementById("cust_secondn_edit").value="";
					document.getElementById("cust_email_edit").value="";
					document.getElementById("custnum").innerHTML="";
				}
			};
			xhttp.open("POST", "http://localhost/autoshowroom/ajaxalter.php?table="+table+"&firstn="+firstn+"&secondn="+secondn+"&email="+email+"&id="+id, true);
			xhttp.send();
			document.getElementById("custedit").style.display="none";		
		}
	}
}

//Sor törlése
function deleteData(table){
	if(table=="car"){
		var id=document.getElementById("carnum").innerHTML;
		var xhttp=new XMLHttpRequest();
		xhttp.onreadystatechange=function(){
			if(this.status==200 && this.readyState==4){
				var jsobj=JSON.parse(this.responseText);
				if(jsobj.flag2==false){
					document.getElementById("ressql").innerHTML=jsobj.flag;
					document.getElementById("ressql").style.color="red";
				}else{
					document.getElementById("ressql").style.color="green";
					document.getElementById("ressql").innerHTML=jsobj.flag;
				}
				document.getElementById("address").innerHTML=jsobj.address;
				document.getElementById("search").innerHTML=jsobj.head;
				document.getElementById("list").innerHTML=jsobj.r;
					
				document.getElementById("mark_edit").value="";
				document.getElementById("price_edit").value="";
				document.getElementById("model_edit").value="";
				document.getElementById("em_id_edit").value="";
				document.getElementById("carnum").innerHTML="";
			}
		};
		xhttp.open("POST", "http://localhost/autoshowroom/ajaxdelete.php?table="+table+"&id="+id, true);
		xhttp.send();
		document.getElementById("caredit").style.display="none";		
	}
	if(table=="employee"){
		var id=document.getElementById("empnum").innerHTML;
		var xhttp=new XMLHttpRequest();
		xhttp.onreadystatechange=function(){
			if(this.status==200 && this.readyState==4){
				var jsobj=JSON.parse(this.responseText);
				if(jsobj.jump!=null){
					alert(jsobj.jump);
					document.getElementById("ressql").innerHTML=jsobj.flag;
				}
				if(jsobj.flag2==false){
					document.getElementById("ressql").innerHTML=jsobj.flag;
					document.getElementById("ressql").style.color="red";
				}else{
					document.getElementById("ressql").style.color="green";
					document.getElementById("ressql").innerHTML=jsobj.flag;
				}
				document.getElementById("address").innerHTML=jsobj.address;
				document.getElementById("search").innerHTML=jsobj.head;
				document.getElementById("list").innerHTML=jsobj.r;
				if(jsobj.sel!=null){
					document.getElementById('em_id').innerHTML=jsobj.sel;
					document.getElementById('em_id_edit').innerHTML=jsobj.sel;
				}
				
				document.getElementById("emp_firstn_edit").value="";
				document.getElementById("emp_secondn_edit").value="";
				document.getElementById("emp_email_edit").value="";
				document.getElementById("empnum").innerHTML="";
			}
		};
		xhttp.open("POST", "http://localhost/autoshowroom/ajaxdelete.php?table="+table+"&id="+id, true);
		xhttp.send();
		document.getElementById("empedit").style.display="none";		
	}
	if(table=="customer"){
		var id=document.getElementById("custnum").innerHTML;
		var xhttp=new XMLHttpRequest();
		xhttp.onreadystatechange=function(){
			if(this.status==200 && this.readyState==4){
				var jsobj=JSON.parse(this.responseText);
				if(jsobj.flag2==false){
					document.getElementById("ressql").innerHTML=jsobj.flag;
					document.getElementById("ressql").style.color="red";
				}else{
					document.getElementById("ressql").style.color="green";
					document.getElementById("ressql").innerHTML=jsobj.flag;
				}
				document.getElementById("address").innerHTML=jsobj.address;
				document.getElementById("search").innerHTML=jsobj.head;
				document.getElementById("list").innerHTML=jsobj.r;
					
				document.getElementById("cust_firstn_edit").value="";
				document.getElementById("cust_secondn_edit").value="";
				document.getElementById("cust_email_edit").value="";
				document.getElementById("custnum").innerHTML="";
				}
			};
		xhttp.open("POST", "http://localhost/autoshowroom/ajaxdelete.php?table="+table+"&id="+id, true);
		xhttp.send();
		document.getElementById("custedit").style.display="none";
	}
}

