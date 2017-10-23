$(document).ready(function(){

	$("#log_out").click(function(){ 
			$(this).attr('href',logout);
		});
	$("#whole_cont").append("<table class='tab1'><tr class='row1'><th class='col1'>Event Name</th><th>Show Name</th><th class='col2'>Show Date </th> <th class='col3'>Time</th><th class='col4'>Venue</th> <th class='col4'>Active/Inactive</th></tr>");
	
	$.each(organizer_event_full_data,function(keys,values)
 	{
 		var status ="";
 		var date = "";
 		var time = "";
 		if(values['status']==1) 		
 			status = "Active"; 		
 		else 	
 			status = "Inactive";
 		if(values['shows_date'] == '-')
 			date = "0000-00-00";
 		else
 			date = values['shows_date'];
 		if(values['shows_time'] == '-')
 			time = "00.00.00";
 		else
 			time = values['shows_time'];
 	
 		$(".tab1").append("<tr><td class='col1' >"+values['display_name']+"</td><td class='col2'>"+date+"</td><td class='col3'>"+time+"</td><td class='col4'>"+values['venue']+"</td><td class='col5'>"+status+"</td></tr></table>");
 	});
});