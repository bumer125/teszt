
function escapeHtml(text) {
	str=text.trim();
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };
  return str.replace(/[&<>"']/g, function(m) { return map[m]; });
}
function checkLetter(data, id){
	var regex_letter=/^[ a-záéiíoóöőuúüűÁÉIÍOÓÖŐUÚÜŰA-Z ]+$/;
	if(data==""){
		document.getElementById(id).innerHTML="* Üresen hagyta a mezőt!";
		return false;
	}
	else if(regex_letter.test(data)==false){
		document.getElementById(id).innerHTML="* Csak betűk megengedettek!";
		return false;
	}else{
		document.getElementById(id).innerHTML="";
		return true;
	}
}

function checkCharacter(data, id){
	var regex_char=/^[a-záéiíoóöőuúüűÁÉIÍOÓÖŐUÚÜŰA-Z0-9]+$/;
	if(data==""){
		document.getElementById(id).innerHTML="* Üresen hagyta a mezőt!";
		return false;
	}
	else if(regex_char.test(data)==false){
		document.getElementById(id).innerHTML="* Csak betűk és számok megengedettek!";
		return false;
	}else{
		document.getElementById(id).innerHTML="";
		return true;
	}
}
function checkNumber(data, id){
	var regex_num=/^[0-9]+$/;
	if(data==""){
		document.getElementById(id).innerHTML="* Üresen hagyta a mezőt!";
		return false;
	}
	else if(regex_num.test(data)==false){
		document.getElementById(id).innerHTML="* Csak számok megengedettek!";
		return false;
	}else{
		document.getElementById(id).innerHTML="";
		return true;
	}
}

function checkEmail(data, id){
	var regex_email=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;	
	if(data==""){
		document.getElementById(id).innerHTML="* Üresen hagyta a mezőt!";
		return false;
	}
	else if(regex_email.test(data)==false){
		document.getElementById(id).innerHTML="* Nem e-mail címet adott meg!";
		return false;
	}else{
		document.getElementById(id).innerHTML="";
		return true;
	}
}

function checkPassword(pass1, pass2, id1, id2){
		if(pass1==""){
			document.getElementById(id1).innerHTML="* Üresen hagyta a mezőt!";
			return false;
		}
		if(pass2==""){
			document.getElementById(id2).innerHTML="* Üresen hagyta a mezőt!";
			return false;
		}
		if(pass1!=pass2){
			document.getElementById(id1).innerHTML="* A jelszavak nem egyeznek meg!";
			return false;
		}else if(pass1.length<7){
			document.getElementById(id1).innerHTML="*A jelszónak lgalább 7 karakterből kell állnia!";
			return false;
		}else if(20<pass1.length){
			document.getElementById(id1).innerHTML="*A jelszó maximum 20 karakterből állhat!";
			return false;
		}else{
			document.getElementById(id1).innerHTML="";
			document.getElementById(id2).innerHTML="";
			return true;
		}
}
//cím animáció

$(document).ready(function(){
	var elementW=$("#addanim").css("width");
	var width = $(window).width() - $('#addanim').width();
	alert(width);
	$(function(){
		var addressAnimate=function(id){	
			$(id).animate({
				left:width+"px"
			}, 3000).animate({
				left:"0px"
			}, 3000);
		};
		setInterval(function(){addressAnimate("#addanim");}, 6000);
	});
});
$(document).ready(function(){
	//Az űrlap záródjon be ha mellé kattintok
	$(window).on({
		click:function(e){
			if(e.target.className=="pagecontainer"){
				$(".pagecontainer").css("display", "none");
			}
		}
	});	
});

