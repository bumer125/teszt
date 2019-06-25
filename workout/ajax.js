$(document).ready(function(){
	$("a").click(function(event){
		event.preventDefault();
	});
})
function listDat(tableName){	
	var obj={"table": tableName};
	var jsob=JSON.stringify(obj);
	$.ajax({
		type:"post",
		url:"http://localhost/workout/ajaxlist.php",
		data:{"se":jsob},
		success:function(result){
			alert(result);
		}
	})
}