var dataTable
var add_line = [];
var row_num = 0;
var row_id = 0;
var total_cheque = 0;

var check_bank = [];
var check_number = [];
var check_amount = [];
var check_date = [];

var or_number;
var or_date;
var first_name;
var middle_name;
var last_name;
var cash_rec;
var total_rec;
var due_total;
var balance;
var check_rec;
var tax_year;

$(document).ready(function(){

    paymentHide();
    reset();
});



$(document).ready(function () {
    dataTable = $('#posts').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
         "url": global.settings.url + "Compromise/compromise_table",
         "dataType": "json",
         "type": "POST",
         "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                       },
    "columns": [
              
              { "data": "owner"},
              { "data": "location" },
              { "data": "pin" },
              { "data": "tax_dec_no" },
              { "data": "year_assessed" },
              { "data": "action" },
             
           ]    
    });
  });



  function compromise(val)
  { 
      var id = val;
      $("#addCompromisePayment").modal("show");
      $(".owners").remove();
      paymentHide(); 
        reset();
    $.ajax({
        type : 'POST',
        url : global.settings.url + 'Compromise/compromise_payment',
        data: {id:id},
        dataType:"json",
        success : function(data){
            console.log(data);
            var landAndOwner = data.landAndOwner;
            var payment = data.payment;
           console.table(landAndOwner);
            console.table(payment);
            var html_owner = "";
            $("#idd").val(data.land_faas_id);

            $("#pin").val(landAndOwner[0].pin);
            $("#arp").val(landAndOwner[0].tax_dec_no);
            $("#location").val(landAndOwner[0].barangay);
            $("#assessed_value").val(money(landAndOwner[0].assessed_value));

            $("#mode_of_payment").val(payment.mode_of_payment);
            $("#due_basic").val(money(payment.due_basic));
            $("#due_sef").val(money(payment.due_sef));
            $("#due_total").val(money(payment.due_total));
            $("#tax_year").val(payment.tax_year);
            $("#balance").val(money(payment.balance));

            // $("#payment_id").val(payment.payment_id);
            $("#idd").val(payment.payment_id);
             
            $.each(data['landAndOwner'], function( index, value ) {
                html_owner += "<input type = 'text' class = 'form-control owners' value = '" +value['full_name']+"' readonly/> ";
               
               });
               $("#owners").append(html_owner);
               
        },
    });
  }


  $("#paymentbtn").click(function(e){
    e.preventDefault();
    add_line = add_line.filter(function(el){
      return el != null;
    });  

    //ERROR ON PAYMENT GETCASH BALANCE. QUESTION FOR CHANGE?? 
      var getcash = $("#cash_payment").val() == null ? 0 : $("#cash_payment").val();
      console.log("cash" +getcash);
      console.log("check" +total_cheque);
      var change
      if($("#cash_change").val() == 0.00)
      {
          change = $("#cash_change").val()
      }
      else{
           change = moneyToNum($("#cash_change").val()) > 0 ? $("#cash_change").val(): 0 ;
      }
      
      or_number = $("#or_number").val();
      or_date = $("#or_date").val();
      cash_rec = getcash;
      total_rec = parseFloat(moneyToNum(getcash)) + parseFloat(total_cheque) - parseFloat(moneyToNum(change));
      first_name = $("#first_name").val();
      middle_name = $("#middle_name").val();
      last_name = $("#last_name").val();
      due_total = $('#due_total').val();
      balance = $("#balance").val();
      tax_year = $("#tax_year").val();
      check_rec = total_cheque;
    var payment_method = $('#payment_method').val();
    var payment_id = $("#idd").val();

    var numbertowords = asd(due_total);
         
    $.ajax({  
        type: 'POST',  
        url: global.settings.url + 'Compromise/view_receipt', 
        data: {numbertowords:numbertowords,or_number:or_number,or_date:or_date,cash_rec:cash_rec,check_rec:check_rec,total_rec:total_rec,first_name:first_name,middle_name:middle_name,last_name:last_name,
        due_total:due_total,balanace:balance,tax_year:tax_year},
        xhrFields: {	responseType: 'blob'},
        success: function(res) {
            var url = window.URL.createObjectURL(res);
            $('#myframe').attr('src',url);
            $("#recieptmodal").modal("show");
        },
    });

});

  $("#printbtn").click(function(e){
    e.preventDefault();
    add_line = add_line.filter(function(el){
      return el != null;
    });  

    //ERROR ON PAYMENT GETCASH BALANCE. QUESTION FOR CHANGE?? 
      var getcash = $("#cash_payment").val() == null ? 0 : $("#cash_payment").val();
      console.log("cash" +getcash);
      console.log("check" +total_cheque);
      var change
      if($("#cash_change").val() == 0.00)
      {
          change = $("#cash_change").val()
      }
      else{
           change = moneyToNum($("#cash_change").val()) > 0 ? $("#cash_change").val(): 0 ;
      }
      
      or_number = $("#or_number").val();
      or_date = $("#or_date").val();
      cash_rec = getcash;
      total_rec = parseFloat(moneyToNum(getcash)) + parseFloat(total_cheque) - parseFloat(moneyToNum(change));
      first_name = $("#first_name").val();
      middle_name = $("#middle_name").val();
      last_name = $("#last_name").val();
      due_total = $('#due_total').val();
      balance = $("#balance").val();
      tax_year = $("#tax_year").val();
      check_rec = total_cheque;
    var payment_method = $('#payment_method').val();
    var payment_id = $("#idd").val();

    var numbertowords = asd(due_total);
      
    $.ajax({  
            type: 'POST',  
            url: global.settings.url + 'Compromise/view_receipt', 
            data: {numbertowords:numbertowords,or_number:or_number,or_date:or_date,cash_rec:cash_rec,check_rec:check_rec,total_rec:total_rec,first_name:first_name,middle_name:middle_name,last_name:last_name,
            due_total:due_total,balanace:balance,tax_year:tax_year},
            xhrFields: {	responseType: 'blob'},
            success: function(res) {
                var url = window.URL.createObjectURL(res);
                $('#myframe').attr('src',url);
                $("#recieptmodal").modal("show");
                Swal.fire({
                    title: 'Done Printing?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Done'
                  }).then((result) => {
                    if (result.value) {

                switch(payment_method)
                    {
                        case "cash":
                            paymentX(or_number,or_date,cash_rec,total_rec,due_total,first_name,middle_name,last_name,balance,payment_id,check_rec,tax_year);

                        break;

                        case "check":
                            paymentX(or_number,or_date,cash_rec,total_rec,due_total,first_name,middle_name,last_name,balance,payment_id,check_rec,tax_year);
                            $('#cash_payment').attr("hidden",true);
                            for(var i = 0; i< add_line.length;i++)
                            {
                                console.log(add_line[i]); 
                                $.ajax({
                                    type: "POST",
                                    data: add_line[i],
                                    url: global.settings.url +'Compromise/compromise_check',
                                    
                                    success: function(res){
                                        console.log(res);
                                    },
                                    error: function(res){
                                    
                                    }
                                });

                            }
                        break;

                        case "cashandcheck":
                            paymentX(or_number,or_date,cash_rec,total_rec,due_total,first_name,middle_name,last_name,balance,payment_id,check_rec,tax_year);
                                for(var i = 0; i< add_line.length;i++)
                            { 
                                $.ajax({
                                    type: "POST",
                                    data: add_line[i],
                                    url: global.settings.url +'Compromise/compromise_check',
                                    
                                    success: function(res){
                                
                                    },
                                    error: function(res){
                                    
                                    }
                                });

                            }
                        break;
                    }
                    
                    }
                },
            );

            
            
        },
    });
});





function paymentX(or_number,or_date,cash_rec,total_rec,due_total,first_name,middle_name,last_name,balance,payment_id,check_rec,tax_year)
{
    $("#payment_idd").val(payment_id);
  $.ajax({
      type : 'POST',
      url : global.settings.url + 'Compromise/compromise_cash',
      data: {tax_year:tax_year,check_rec:check_rec,payment_id:payment_id,balance:balance,or_number:or_number,or_date:or_date,cash_rec:cash_rec,total_rec:total_rec,due_total:due_total,first_name:first_name,middle_name:middle_name,last_name:last_name},
      dataType:"json",
      success : function(data){
          console.table(data);
          paymentHide(); 
          reset();
          $(".owners").remove();
          $("#addCompromisePayment").modal("hide");
          dataTable.ajax.reload();
          Swal.fire(
              'PAYMENT Successful!',
              '',
              'success'
              )
      },
  });
}

$("#testbtn").click(function(){

    view_OR(2);
    $("#payment_idd").val(2);
});

function view_OR(id)
  {
      
    $.ajax({
        type : 'POST',
        url : global.settings.url + 'Compromise/view_OR',
        data: {id:id},
        xhrFields: {	responseType: 'blob'},
        success : function(data){
            var url = window.URL.createObjectURL(data);
            $('#myframe1').attr('src',url);
            $("#recieptmodal1").modal("show");
           
        },
    });
  }

  function printOR()
  {
    
    var id = $("#payment_idd").val();
    $.ajax({
        type : 'POST',
        url : global.settings.url + 'Compromise/print_OR',
        data: {id:id},
        xhrFields: {	responseType: 'blob'},
        success : function(data){


            Swal.fire({
                title: 'Done Printing?',
                text: "This is the only time you can re-print!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
              }).then((result) => {
                if (result.value) {

                  $("#payment_idd").val(""); 
                 $("#recieptmodal1").modal("hide");
                 $("#recieptmodal2").modal("hide");
                }
                else{
                    $("#recieptmodal2").modal("hide");
                }
              })
            var url = window.URL.createObjectURL(data);
            $('#myframe2').attr('src',url);
            $("#recieptmodal2").modal("show");
            
           
        },
    });
  }



$("#add_cheque").click(function(e){
    e.preventDefault();

    var or_num = $("#or_number").val();
    or_num = or_num.replace(/\s/g, '') 
    


    if(or_num == ""){
         
        Swal.fire("You cannot add check without OR number!");
    }
    else if(or_num){

                if (row_num >= 3) {
            
                } 
                else {
                // table_cheque.row.add([
                //   cheq_number,
                //   cheq_amount,
                //   bank_branch,
                //   '<button type="button" class="btn btn-danger" id="Delete-btn">Delete</button> '
                // ]).draw(false);
            
                    add_line.push({
                        'ch[bank]' : $('#bank').val(),
                        'ch[check_number]' : $('#cheque_no').val(),
                        'ch[check_amount]' : moneyToNum($('#cheque_amount').val()),
                        'ch[check_date]' :  $('#cheque_date').val(),
                        'ch[or_number]' :  $("#or_number").val()

                    });
                   
                    total_cheque += parseFloat(moneyToNum($("#cheque_amount").val())); 
                
                    var table = document.getElementById("table_cheque");
                    var row= document.createElement("tr");
                    row.setAttribute('id','row'+row_id);
                    row.setAttribute('class','rowrow');
                    var td1 = document.createElement("td");
                    var td2 = document.createElement("td");
                    var td3 = document.createElement("td");
                    var td4 = document.createElement("td");
                    var td5 = document.createElement("td");
                    td1.innerHTML = document.getElementById("bank").value;
                    td2.innerHTML  = document.getElementById("cheque_no").value;
                    td3.innerHTML  = document.getElementById("cheque_amount").value;
                    td4.innerHTML  = document.getElementById("cheque_date").value;
                    td5.innerHTML  = '<button type="button" class="btn_delete btn btn-danger cor_del" id="'+row_id+'">Delete</button>';
                    row.appendChild(td1);
                    row.appendChild(td2);
                    row.appendChild(td3);
                    row.appendChild(td4);
                    row.appendChild(td5);
                    table.children[0].appendChild(row);
                    row_id++;
                    row_num++;

                    $(".check_pay").val("");
            
                }

          


    }
   

  });




  $(document).on('click', '.btn_delete', function(){

    var a = $(this).attr("id");
    total_cheque -= parseFloat(add_line[a]["ch[check_amount]"]);
   
    row_num--;
    delete add_line[a];
    $('#row'+a+'').remove(); 

  });


$("#cash_payment").click(function(){
     
    $("#cash_payment").val("");
 
});


function compromise_history(id)
{
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    var dateToday = yyyy+"-"+mm+"-"+dd;
    $(".phistory").val("");
    $.ajax({
        type : 'POST',
        url : global.settings.url + 'Compromise/compromise_history',
        data: {id:id},
        dataType:"json",
        success : function(data){
            //change paymenthistory_year to tax_year payment
            console.table(data);
            var year = new Date().getFullYear();
            var html = "";
            for(i=2000;year>i;year--)
            {
                html += "<option value = '"+year+"'>"+year+"</option>";
            }
            $("#paymenthistory_year").append(html);
            $(".history").remove();
            var html_owner = "<label class = 'history'>Owner/s:</label>";
            var html_paymenthistorydata;
            var payment = data['payment'];
            var owner = data['owner'];
            var tax_order = data["tax_order"];
            console.log(owner[0]['pin']);
            console.log(payment);
            var basic = tax_order[0]['basic'] ? tax_order[0]['basic'] : 0;
            var sef = tax_order[0]['sef'] ?  tax_order[0]['sef'] : 0;
            var penalty = tax_order[0]['penalty'] ? tax_order[0]['penalty'] : 0;
            var discount = tax_order[0]['discount'] ? tax_order[0]['discount'] : 0;
            var total = tax_order[0]['total'] ? tax_order[0]['total'] : 0;
           $("#viewPayment").modal("show");
  
           $("#idpin").val(id);
           $('#paymenthistory_pin').val(owner[0]['pin']);
           $('#paymenthistory_tax_dec_no').val(owner[0]['tax_dec_no']);
           $('#paymenthistory_assessed_val').val(money(owner[0]['assessed_value']));
           $('#paymenthistory_location').val('Barangay '+owner[0]['barangay'] +' San Pablo City, Laguna');
           $('#paymenthistory_mode_of_payment').val(tax_order[0]['mode_of_payment']);
           $('#paymenthistory_basic').val(money(basic));
           $('#paymenthistory_sef').val(money(sef));
           $('#paymenthistory_penalty').val(money(penalty));
           $('#paymenthistory_discount').val(money(discount));
           $('#paymenthistory_total').val(money(total));

           $.each(data['owner'], function( index, value ) {
            html_owner += "<input class = 'form-control payment history' type = 'text' value = '" +value['full_name']+"' readonly/>";
           });
           $("#paymenthistory_owners").append(html_owner);

           $.each(data['payment'], function( index, value ) {
            html_paymenthistorydata += "<tr class ='history'>"+
                                        "<td>"+value['payor_name']+"</td>"+
                                        "<td>"+value['or_number']+"</td>"+
                                        "<td>"+money(value['due_basic'])+"</td>"+
                                        "<td>"+money(value['due_sef'])+"</td>"+
                                        "<td>"+money(value['due_total'])+"</td>"+
                                        "<td>"+money(value['cash_rec'])+"</td>"+
                                        "<td>"+money(value['check_rec'])+"</td>"+
                                        "<td>"+money(value['total_rec'])+"</td>"+
                                        "<td>"+value['or_date']+"</td>"
                                        if(value['or_date'] == dateToday || data.admin == "Admin" || data.admin == "Superadmin"){
                                            
                                            html_paymenthistorydata += "<td><button class = 'btn btn-danger' onclick='cancelOR("+value['or_number']+")'><fa class = 'fa fa-window-close'></fa></button></td>"
                                        }
                                        else{
                                            html_paymenthistorydata +="<td></td>"
                                        }
                                        html_paymenthistorydata +="<tr>";

           });

          

           $("#paymenthistorydata").append(html_paymenthistorydata);

        },
    });
}

$("#or_number").change(function(){
    add_line = [];
    $(".rowrow").remove();
    row_num = 0;
    row_id = 0;
    total_cheque = 0;
    var or_no = $(this).val();

    if($(this).val().length > 7)
    {
        Swal.fire("Exceed O.R length");
            $("#or_number").val("");
    }

    
$.ajax({
    type : 'POST',
    url : global.settings.url + 'Payment/check_or',
    data:{or_no: or_no},
    dataType:"json",
    success : function(data){
        console.log(data);
        
        if(data){
            Swal.fire("O.R number already exist");
            $("#or_number").val("");
        }

        // 
    },
    error : function(xhr){

    }
});

});


  $("#payment_method").change(function(){
    console.log($(this).val());
    switch($(this).val()){
        case "cash":
            $("#name_of_payer").show();
            $(".payment_info").show();
            $(".paymentcheque").hide();
            $(".paymentcash").show();
            $("#cash_change").val(money("0"));
            $("#cash_payment").val(money("0"));
        break;
        case "check":
            $("#name_of_payer").show();
            $(".payment_info").show();
            $(".paymentcheque").show();
            $(".paymentcash").hide();
            $("#cash_change").val(money("0"));
            $("#cash_payment").val(money("0"));
        break;
        case "cashandcheck":
            $("#name_of_payer").show();
            $(".payment_info").show();
            $(".paymentcheque").show();
            $(".paymentcash").show();
            $(".change").hide();
            $("#cash_change").val(money("0"));
            $("#cash_payment").val(money("0"));
        break;
        default :
        paymentHide(); 
        reset();
        break;
    }

  });

  function paymentHide()
  {
      $("#name_of_payer").hide();
      $(".payment_info").hide();
      $(".paymentcheque").hide();
      $(".paymentcash").hide();
  }

  function reset(){
    // $("#add_payment")[0].reset();
   
    $(".payment").val("");
    $(".rowrow").remove();
   
    $(".paymentcash").hide();
    paymentHide();
    $(".check_pay").val("");
    $("#payment_method").val("");

     add_line = [];
     row_num = 0;
     row_id = 0;
     total_cheque = 0;

     check_bank = [];
     check_number = [];
     check_amount = [];
     check_date = [];
}
