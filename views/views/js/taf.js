
function ajaxCall(urlp, typep, datap, datatypep, callbackp) { 
  // Show loading image 
  var request = $.ajax({
    url: urlp,
    type: typep,
    data: datap,
    dataType: datatypep
  });
  request.done(function(data) { 
    // hide loading image
  var d = JSON.parse(data);
  callbackp(d);

  var rettype = d.status.type;
  var retmsg = d.status.message;  
  if(rettype != "NOMSG")
  {
    if(rettype == "Success")
    {
      $("#successdiv").text(retmsg);
      $("#successdiv").show();
      $("#successdiv").fadeOut(5000);
    }
    else
    {
      $("#errordiv").text(retmsg);
      $("#errordiv").show();
      $("#errordiv").fadeOut(5000);
    }
  }
  });
  request.error(function(data, textStatus, errorThrown) {
    console.log(textStatus, errorThrown);
  });
 
}
