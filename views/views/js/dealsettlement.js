// Requires Datatable and JQuery!
// August 2013 Varun D and Madan U S

function setMerchantValues(firstMerchant) {
  /* This function fills in all variables about the merchant using the variable firstMerchant that is sent by the server with the html. */
  $('[for="M_Name"]').text(firstMerchant.merchant.name);  //Fill in Merchant Name
  $('[for="M_image"]').attr('src', firstMerchant.merchant.image);  //Fill in Merchant Image
  //Fill in Deal Info
}

function setDealInfo(loadedDeal) {
  $.each(merchantDeals, function (index, value) { 
      if (loadedDeal === value['id']) {
        $('[for="D_vcount"]').text(value['voucher_count']);
        $('[for="D_price"]').text(Math.round(parseInt(value['deal_price'])));
        $('[for="D_agent"]').text(value['agent_name']);
        $('[for="D_url"]').attr('href', value['deal_url']);
      } 
  });
}

function setDealSelectList (dropdownDIV, merchantDeals) {
  $.each(merchantDeals.reverse(), function (index, value) {
    var deal = value;
    $("#" + dropdownDIV).append('<option value="'+deal.id+'">'+deal.name+'</option>');
  });
}

// Function to append merchant name listing dropdown
function setMerchantsList (merchantDropdownDIV, merchantDetails) {
  $.each(merchantDetails, function (index, value) { 
    $("#" + merchantDropdownDIV).append('<option value="' + index + '">' + value + '</option>');
  });
}

function initTable(TableDataColumns, TableDataRows, TableDIV, searchInputDIV) {
  /* This function sets the datatable variables and populates the table using TableData variable The function also removed default search feature and sets a div for search*/
  $(TableDIV).html( '<table cellpadding="0" cellspacing="0" border="0" class="display" id="voucher_table"><thead></thead><tbody></tbody></table>' );
  voucherTable = $('#voucher_table').dataTable( {
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": false,
            "bAutoWidth": false,
            "aaData": TableDataRows,
            "aoColumns": TableDataColumns,
           /*  "aoColumnDefs": [
              {
                "mData": null,
                "sDefaultContent": "<input type='checkbox' class='vselectbox'/>",
                "aTargets": [ -1 ] // Change to -1
              }
            ],
		*/
            "oLanguage": {
              "sEmptyTable": "You do not have any vouchers for this deal yet. Either change the selected deal above or wait for purchases :)"
            }
  });

  // Remove default search UI. The ID is obtained from line 2 of this function. Notice id = voucher_table.
  $('#voucher_table_filter').remove();

  //Search to use custom input box
  $(searchInputDIV).keyup(function(){
    voucherTable.fnFilter( $(this).val() );
  });

  return voucherTable;

}

function clearVoucherTable (voucherTable) {
  $(voucherTable).fadeOut("fast", function () { 
    $(voucherTable).html("");
  });  
}

// Get Deal list for merchant id
function loadDealsForMerchant(merchantSelectDIV) {
    selectedMerchant = $('#' + merchantSelectDIV + " option:selected").val();
    var request = $.ajax({
      url: "Deal/getDealsListForMerchant",
      type: "POST",
      data: {merchantid: selectedMerchant},
      dataType: 'html'
    });
    request.done(function(data) {
      var dealIds = new Array();
      dealsForMerchant = JSON.parse(data); 
      $("#dealselect").empty();
      setDealSelectList("dealselect",dealsForMerchant['products']);
      $(dealsForMerchant['products']).each(function(index,element){
        // alert(index + "->" + element['id']); 
        dealIds[index] = element['id'];
      });
      // console.log(dealsForMerchant['products']);
      getVouchersForDeal(dealIds[0],initTable);
    });
}

function setPaymentNotesForDeal(deal_id, entered_notes) {
  var request = $.ajax({
    url: "Voucher/setPaymentNotes",
    type: "POST",
    data: {dealID : deal_id, paymentNotes : entered_notes},
    dataType: "html"
  });
  var datum;
  request.done(function(data) {
    alert("Respond");
    datum = JSON.parse(data);
    console.log(datum);
  });
}

function loadDealsOnChange (dealSelectDIV) {
  $('#' + dealSelectDIV).change(function(){
    selecteddeal = $('#' + dealSelectDIV + " option:selected").val();
    var request = $.ajax({
      url: "Voucher/getVouchersForDealId",
      type: "POST",
      data: {dealid : selecteddeal},
      dataType: "html"
    });
    request.done(function(data) {
      loadedDeal.vouchers_Columns = new Array();
      loadedDeal.vouchers_Data = new Array();
      d = JSON.parse(data);
      vouchers = d['vouchers'];
      row = 1;
      $(vouchers).each(function(index,element){
        voucher = element;
        rowObj = new Array();
        for(var key in voucher)
        {
          if(row==1)
          {
            headerObj = new Object();
            headerObj['sTitle'] = key;
            loadedDeal.vouchers_Columns.push(headerObj);
          }
          value = voucher[key];
          rowObj.push(value);
        }
        loadedDeal.vouchers_Data.push(rowObj);
        row++;
      });
    });
    
    request.fail(function(jqXHR, textStatus) {
      alert( "Request failed: " + textStatus );
    });
  });

  // console.log("Printing loadedDeal-----------------0-0-0-00");
  // console.log(loadedDeal);

  return loadedDeal
}


function getVouchersForDeal (dealID,functiond) {

  // Get Order Status filter values
  var order_status = "";
  order_status = $("#orderstatusfilter option:selected").val();

  // Get Payment Method filter values
  var payment_method = "";
  payment_method = $("#paymentmethodfilter option:selected").val();

  // Get Voucher Payment Status
  var voucher_payment_status = ""; 
  voucher_payment_status = $("#voucherpaymentstatus option:selected").val();

  // Get Order Receivable Status
  var OrderReceivableStatus = ""; 
  OrderReceivableStatus = $("#orderreceivablestatus option:selected").val();

  var request = $.ajax({
    url: "Voucher/getVouchersForDealIdWithFilters",
    type: "POST",
    data: {dealid : dealID, orderstatus : order_status ,paymentmethod : payment_method ,voucherpaymentstatus : voucher_payment_status ,orderReceivableStatus : OrderReceivableStatus},
    dataType: "html",
  });

  request.done(function(data) {
    console.log(data);
    vouchers_Columns = new Array(); 
    vouchers_Data = new Array();
    d = JSON.parse(data);
    vouchers = d['vouchers'];
    // Getting total value from the function
    var total = "";
    grandSummary = d['summary'];
    if(grandSummary) {
        $("#amount_summary_div").css("display", "block");
        $("#totalVouchers").empty();
        $("#grandTotalAmount").empty();
        $("#amountRecieved").empty();
        $("#commission").empty();
        $("#totalPayable").empty();
        $("#paymentNotes").empty();
        $("#totalVouchers").append(grandSummary['totalVouchers']);
        $("#grandTotalAmount").append(grandSummary['totalAmount']);
        $("#amountRecieved").append(grandSummary['amountRecieved']);
        $("#commission").append(grandSummary['commission']);
        $("#totalPayable").append(grandSummary['totalPayable']);
        $("#paymentNotes").append(grandSummary['paymentNotes']);
    } else { $("#amount_summary_div").css("display", "none"); }
    row = 1;
    $(vouchers).each(function(index,element){
      voucher = element;
      rowObj = new Array();
      for(var key in voucher)
      {
        if(row==1)
        {
          headerObj = new Object();
          headerObj['sTitle'] = key;
          vouchers_Columns.push(headerObj);
        }
        value = voucher[key];
        rowObj.push(value);
      }
      checkbox = "<input type='checkbox' class='vselectbox' value='" + voucher['Voucher ID'] + "' onchange='javascript:toggleId(this)'/>";
      rowObj.push(checkbox);
      vouchers_Data.push(rowObj);
      row++;
    });
    if (vouchers_Columns.length === 0){ vouchers_Columns = [[]]; }
    selectClm = {sTitle:"Select<br/><input id='selectall' type='checkbox'/>"};
    vouchers_Columns.push(selectClm);
    functiond(vouchers_Columns, vouchers_Data, voucher_table_div, xCore3000Search);
    $(voucher_table_div).fadeIn("fast");
  });
    
  request.fail(function(jqXHR, textStatus) {
    alert( "Request failed: " + textStatus );
  });
}

var selectedvoucherids = '';

function toggleId(checkbox)
{
	valuecomma = checkbox.value + ',';
  if(checkbox.checked)
	{
		selectedvoucherids += valuecomma;
	}
	else
	{
		selectedvoucherids = selectedvoucherids.replace(valuecomma, '');
	}
}

$(document).ready(function(){

  // Set Merchant name dropdown
  setMerchantsList("merchantselect",merchantName);
  // firstMerchant recived from Server
  setMerchantValues(firstMerchant);
  // merchantDeals recievd from Server
  setDealSelectList("dealselect",merchantDeals);
  // Set deal related values.
  setDealInfo(merchantDeals[0]['id']);
  
  // Setup initial table
  getVouchersForDeal(parseInt(merchantDeals[0]['id']),initTable);

  // Action for Select All
  $("#selectall").click(function(){
      // alert("Hoooola");
  });

  $("#dealselect").change(function(){
      reloadVouchers();
  });

  $("#orderstatusfilter").change(function(){
      // alert("hola!")
      reloadVouchers();
  });

  $("#paymentmethodfilter").change(function(){
      reloadVouchers();
  });

  $("#voucherpaymentstatus").change(function(){
      reloadVouchers();
  });

  $("#orderreceivablestatus").change(function(){
      reloadVouchers();
  });

  // change action for merchant name dropdown
  $("#merchantselect").change(function(){
    // 
    merchantid = $('#merchantselect option:selected').val();
    loadDealsForMerchant("merchantselect");
  });

  // Export to Excel btn Fx
  $("#btn_e2eL").click(function(){
    selecteddeal = $("#dealselect option:selected").val();
    url = 'Voucher/getvouchersForDealIdAsCSV?dealid=' + selecteddeal;
    window.open(url);
  });

  // Export ALL vouchers btn Fx
  $("#btn_e2eA").click(function(){
    selecteddeal = $("#dealselect option:selected").val();
    url = 'Voucher/getAllvouchersForMerchantAsCSV';
    window.open(url);
  });

  // Save Payment Notes
  $("#notes_btn").click(function(){
    var deal_id = "";
    deal_id = $("#dealselect option:selected").val();
    enteredPaymentNotes = $('#paymentNotes').val();
    setPaymentNotesForDeal(deal_id, enteredPaymentNotes);
  });

  // Change Payment Status
  $("#PaymentStatusChange_btn").click(function(){
    var paymentStatus = $("#changePaymentStatus").val();
    setStatus(paymentStatus);
  });

  
});

function reloadVouchers()
{
  $(voucher_table_div).fadeOut("fast");
  dealid = $('#dealselect option:selected').val();
  setDealInfo(dealid);
  getVouchersForDeal(parseInt(dealid),initTable);
}


function setStatus(status)
{
  var request = $.ajax({
    url: "Voucher/setVoucherStatusForVoucherIds",
    type: "POST",
    data: {'voucherids' : selectedvoucherids, 'status' : status},
    dataType: "html",
  });

  request.done(function(data) {
    console.log(data);
    $(voucher_table_div).fadeOut("fast");
    dealid = $('#dealselect option:selected').val();
    setDealInfo(dealid);
    getVouchersForDeal(parseInt(dealid),initTable);
  });
    
  request.fail(function(jqXHR, textStatus) {
    alert( "Request failed: " + textStatus );
  });
}
