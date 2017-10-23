$(document).ready(function(){
	var i = 1;
	$("#create_organizer").click(function(){
		$('#create_organizer').attr('href',pathToLoad);
	});
	$("#my_organizer").append("<tr> <th>S.No</th><th> Name </th><th> Contact Person </th><th> Email </th><th> Mobile </th><th> Options </th></tr>");
	$.each(pass_organizers,function(key,value){
		
		$("#my_organizer").append("<tr><td>"+i+"</td><td>"+value['org_name']+"</td> <td>"+value['cont_person']+"</td> <td>"+value['email']+"</td> <td>"+value['mobile']+"</td><td><a href='' class='org_modify' id="+value['email']+" >Modify </a> | <a href='' class='org_manage' id="+value['org_id']+"> Manage Users </a></td></tr> ");
		i = i+1;
	});
	$(".org_modify").click(function(){
		var qryStrng 	= this.id;		
		var path 		= modify_org+"?id="+qryStrng;
		$(this).attr('href',path);
	});
	$(".org_manage").click(function(){
		var qryStrng 	= this.id;		
		var path 		= manage_org+"?id="+qryStrng;
		$(this).attr('href',path);
	});
	$("#log_out").click(function(){ 
		$(this).attr('href',logout);
	});
});