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
  
   
   
});

function paymentX(or_number,or_date,cash_rec,total_rec,due_total,first_name,middle_name,last_name,balance,payment_id,check_rec,tax_year)
{
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
                        'ch[check_amount]' : $('#cheque_amount').val(),
                        'ch[check_date]' :  $('#cheque_date').val(),
                        'ch[or_number]' :  $("#or_number").val()

                    });
                   
                    total_cheque += parseFloat($("#cheque_amount").val()); 
                
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

                console.log(add_line);
                console.log(total_cheque);


    }
   

  });




  $(document).on('click', '.btn_delete', function(){

    var a = $(this).attr("id");
    total_cheque -= parseFloat(add_line[a]["ch[check_amount]"]);
    console.log(total_cheque);
    row_num--;
    delete add_line[a];
    $('#row'+a+'').remove(); 

  });


$("#cash_payment").click(function(){
     
    $("#cash_payment").val("");
 
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
