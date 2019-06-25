//Ez egy komment
$(document).ready(function(){
	//Űrlap megjelenítés
	$("#showData").on({
		click:function(event){
			event.preventDefault();
			$.ajax({
				type:"post",
				url:"http://localhost/everyday/ajaxselect.php",
				success:function(result){
					var jsresult=JSON.parse(result);
					$("#d1").val(jsresult.fname);
					$("#d2").val(jsresult.sname);
					$("#d3").val(jsresult.email);
					$("#d4").val(jsresult.username);
				}
			});
		$(".pagecontainer").css("display", "block");	
		}
	});
});
