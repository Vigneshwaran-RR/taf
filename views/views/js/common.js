
function ajaxCall(urlp, typep, datap, datatypep, callbackp) {
  var request = $.ajax({
    url: urlp,
    type: typep,
    data: datap,
    dataType: datatypep
  });
  request.done(function(data) {

    var d = JSON.parse(data);

    var rettype = d.status.type;
    var retmsg = d.status.message;

    if(rettype != "")
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

    callbackp(data);
  });
}
