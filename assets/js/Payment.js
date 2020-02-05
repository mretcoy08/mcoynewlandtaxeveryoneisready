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
var due_discount;
var due_penalty;



$(document).ready(function(){

    paymentHide();
    $("#compromise").hide();

   
});




$(document).ready(function () {
    
    dataTable = $('#posts').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
         "url": global.settings.url + "Payment/payment_table",
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



  $("#paymentbtn").click(function(e){
      e.preventDefault();
     
      add_line = add_line.filter(function(el){
        return el != null;
      });  

      //ERROR ON PAYMENT GETCASH BALANCE. QUESTION FOR CHANGE?? 
        var getcash = $("#cash_payment").val() == null ? 0 : $("#cash_payment").val();
        var change
        if($("#cash_change").val() == 0.00)
        {
            change = $("#cash_change").val()
        }
        else{
             change = moneyToNum($("#cash_change").val()) > 0 ? $("#cash_change").val(): 0 ;
        }
        due_discount = $('#due_discount').val();
        due_penalty = $('#due_penalty').val();
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
        var mode_of_payment = $("#mode_of_payment").val();
        check_rec = total_cheque;
      var payment_id = $("#idd").val();
        var payment_method = $('#payment_method').val();
        console.log(payment_method);
      switch(payment_method)
      {
        case "cash":
            paymentX(payment_method,mode_of_payment,or_number,or_date,cash_rec,total_rec,due_total,first_name,middle_name,last_name,balance,payment_id,check_rec,tax_year,due_discount,due_penalty);
     
        break;

        case "check":
            paymentX(payment_method,mode_of_payment,or_number,or_date,cash_rec,total_rec,due_total,first_name,middle_name,last_name,balance,payment_id,check_rec,tax_year,due_discount,due_penalty);
            $('#cash_payment').attr("hidden",true);
            for(var i = 0; i< add_line.length;i++)
            {
               console.log(add_line[i]); 
                $.ajax({
                    type: "POST",
                    data: add_line[i],
                    url: global.settings.url +'Payment/payment_check',
                    
                    success: function(res){
                        console.log(res);
                    },
                    error: function(res){
                    
                    }
                });

            }

          
          
        break;

        case "cashandcheck":
            paymentX(payment_method,mode_of_payment,or_number,or_date,cash_rec,total_rec,due_total,first_name,middle_name,last_name,balance,payment_id,check_rec,tax_year,due_discount,due_penalty);
                for(var i = 0; i< add_line.length;i++)
            { 
                $.ajax({
                    type: "POST",
                    data: add_line[i],
                    url: global.settings.url +'Payment/payment_check',
                    
                    success: function(res){
                
                    },
                    error: function(res){
                    
                    }
                });

            }

            
         
        break;
      }

    
     
     
  });
  function paymentX(payment_method,mode_of_payment,or_number,or_date,cash_rec,total_rec,due_total,first_name,middle_name,last_name,balance,payment_id,check_rec,tax_year,due_discount,due_penalty)
  {
        $("#payment_idd").val(payment_id);
        console.log(payment_method);
    $.ajax({
        type : 'POST',
        url : global.settings.url + 'Payment/payment_cash',
        data: {payment_method:payment_method,mode_of_payment:mode_of_payment,due_penalty:due_penalty,due_discount:due_discount,tax_year:tax_year,check_rec:check_rec,payment_id:payment_id,balance:balance,or_number:or_number,or_date:or_date,cash_rec:cash_rec,total_rec:total_rec,due_total:due_total,first_name:first_name,middle_name:middle_name,last_name:last_name},
        dataType:"json",
        success : function(data){
            console.table(data);
            paymentHide(); 
            reset();
            $(".owners").remove();
            $("#addPayment").modal("hide");
            dataTable.ajax.reload();
            Swal.fire(
                'PAYMENT Successful!',
                '',
                'success'
                )
                view_OR(payment_id);
        },
    });
  }


  function view_OR(id)
  {
      
    $.ajax({
        type : 'POST',
        url : global.settings.url + 'Payment/view_OR',
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
        url : global.settings.url + 'Payment/print_OR',
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

  function payment_history(val)
  {
    
       
    var id = val
    
  
    $("#viewPayment").modal("show");
    paymentHistory(id,year);
    console.log(year);
   
  }

  $("#paymenthistory_year").change(function(){
    var year = $(this).val();
    var id = $("#idpin").val();
    paymentHistory(id);
  });

  function paymentHistory(id)
  {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    var dateToday = yyyy+"-"+mm+"-"+dd;
    $(".phistory").val("");
    $.ajax({
        type : 'POST',
        url : global.settings.url + 'Payment/payment_history',
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
            var tax_order = data["tax_order"]
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
                                        "<td>"+money(value['due_penalty'])+"</td>"+
                                        "<td>"+money(value['due_discount'])+"</td>"+
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

function cancelOR(value){
    var or_number = value;
    console.log(or_number);

    Swal.fire({
        title: 'Admin Password',
        input: 'password',
        inputAttributes: {
          autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Submit',
        showLoaderOnConfirm: true,
        preConfirm: (password) => {
            $.ajax({
                type : 'POST',
                url : global.settings.url + 'Payment/cancelOR_verification',
                data:{password:password},  
                dataType:"json",
                success : function(data){
                 
                    if(data == "Success") {
                        $.ajax({
                            type : 'POST',
                            url : global.settings.url + 'Payment/cancelOR',
                            data:{or_number:or_number},  
                            dataType:"json",
                            success : function(data){
                                $("#viewPayment").modal("hide")
                                dataTable.ajax.reload();
                                console.log(data);
                                    Swal.fire(
                                    'O.R Cancelled!',
                                    '',
                                    'success'
                                    )
                            }
                        })
                        
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: '',
                            text: 'Wrong Admin Password',
                            
                          })
                    }

                }
            })
        },
        
      })
}

  function payment(val)
  {
    paymentHide(); 
    reset();
      var id = val;
      console.log(id);
      $(".owners").remove();
      $("#addPayment").modal("show");
    
    $.ajax({
        type : 'POST',
        url : global.settings.url + 'Payment/payment_compute',
        data:{id: id},
        dataType:"json",
        success : function(data){
            var landAndOwner = data.landAndOwner;
            var payment = data.payment;
           console.table(landAndOwner);
            console.table(payment);
            var html_owner = "";
           

            $("#pin").val(landAndOwner[0].pin);
            $("#arp").val(landAndOwner[0].tax_dec_no);
            $("#location").val(landAndOwner[0].barangay);
            $("#assessed_value").val(money(landAndOwner[0].assessed_value));

            $("#mode_of_payment").val(payment.mode_of_payment);
            $("#due_basic").val(money(payment.due_basic));
            $("#due_sef").val(money(payment.due_sef));
            $("#due_penalty").val(money(payment.due_penalty));
            $("#due_discount").val(money(payment.due_discount));
            $("#due_total").val(money(payment.due_total));
            $("#tax_year").val(payment.tax_year);
            $("#balance").val(money(payment.balance));

            
            $("#idd").val(payment.id);
            

            
            $.each(data['landAndOwner'], function( index, value ) {
                html_owner += "<input type = 'text' class = 'form-control owners' value = '" +value['full_name']+"' readonly/> ";
               
               });
               $("#owners").append(html_owner);
               
        },
        error:function(){
            console.log('mali');
        },
        });
  }


  

//   $("#cash_payment").change(function(){
     
//         if($("#cash_payment").val() == "" || $("#cash_payment") == null){
//             $("#cash_change").val(money("0"));
//             $("#cash_payment").val(money("0"));
//         }
//         else{
//             $("#cash_change").val(money(subMoney($("#cash_payment").val(),$("#due_total").val())));
//         }
//         $("#cash_payment").val(money($("#cash_payment").val()));
    
//   });

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

  $("#or_number").change(function(){
    add_line = [];
    $(".rowrow").remove();
    row_num = 0;
    row_id = 0;
    total_cheque = 0;
    $("#collected_basic").val("");
    $("#collected_sef").val("");
    $("#collected_penalty").val("");
    $("#collected_discount").val("");
    $("#collected_total").val("");
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

                // console.log(add_line);
                // console.log(total_cheque);


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

  //CLEARANCE
function clearance(val){
    var tax_id = val 
    
    $("#clearancePayment").modal("show");
      $.ajax({
        type : 'POST',
        url : global.settings.url + 'Payment/getLandId',
        data:{tax_id: tax_id},
        dataType:"json",
        success : function(data){
            $("#land_id").val(data);
        }
    });
   
}


$("#clearance_payment").submit(function(e){
    e.preventDefault();
    $.ajax({
        type : 'POST',
        url : global.settings.url + 'Payment/clearance_payment',
        data:$(this).serialize(),
        dataType:"json",
        success : function(data){
            console.log(data);
            $("#clearancePayment").modal("hide");
            $("#clearance_ornumber").val("");
            $("#clearance_fee").val("");
        },
        error:function(xhr){
            console.log(xhr);
        }
    });
   
});

$("#clearance_fee").change(function(){
    $("#clearance_fee").val(money($("#clearance_fee").val()? $("#clearance_fee").val():0));
})

    $("#clearance_ornumber").change(function(){
        var or_no = $(this).val();

        
           
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
                })

  });


  function payment_method(val){
      var id = val;
    $.ajax({
        type : 'POST',
        url : global.settings.url + 'Payment/getPayment_method',
        data:{id: id},
        dataType:"json",
        success : function(data){
            console.log(data);
            $("#changeModeOfPayment").modal("show");
            $("#payment_mode").val(data.mode_of_payment);
            $("#mop_balance").val(money(data.balance));
            $("#mop_total_payment").val(money(data.total));
            $("#tax_order_id").val(id);
            $("#mop_land_id").val(data.land_id);
           $(".mop").remove();
            var mop_html = "";
            switch(data.mode_of_payment){
                case "Annually": 
                mop_html = '<option class = "mop" value="Annually">ANNUALLY</option><option class = "mop" value="Semi Annually">SEMI ANNUALLY</option><option class = "mop" value="Quarterly">QUARTERLY</option><option class = "mop" value="Compromise">COMPROMISE</option>';
                break;
                case "Semi Annually": 
                mop_html = '<option class = "mop" value="Semi Annually">SEMI ANNUALLY</option><option class = "mop" value="Quarterly">QUARTERLY</option><option class = "mop" value="Compromise">COMPROMISE</option>';
                break;
                case "Quarterly": 
                mop_html = '<option class = "mop" value="Quarterly">QUARTERLY</option><option class = "mop" value="Compromise">COMPROMISE</option>';
                break;
                case "Compromise": 
                mop_html = '<option class = "mop" value="Compromise">COMPROMISE</option><option class = "mop" value="a">a</option>';
                break;
            }
            $("#mode_of_payment1").append(mop_html);
          
            },
        error : function(xhr){

        }
    })

  }
    
  $("#mode_of_payment1").change(function(){    
      var id = $("#mop_land_id").val();
      console.log(id);
    if($(this).val() == "Compromise"){
        $("#compromise").show();
        $("#compromise").attr("required", true);
        
    }
    else{
        $("#compromise").hide();
        $("#compromise").attr("required", false);
    }

   mop_compute(id);

});

$("#changebutton").click(function(e){
    e.preventDefault();
    var  payment_mode = $("#payment_mode").val();
    var tax_order_id = $("#tax_order_id").val();
    var mode_of_payment = $('#mode_of_payment1').val();
    var mop1 = $("#mop1").val();
    var mop2 = $("#mop2").val();
    var number_of_payment = $('#number_of_payment').val();

    if(payment_mode == mode_of_payment)
    {
        
    }
    else{
        
         $.ajax({
            type : 'POST',
            url : global.settings.url + 'Payment/change_payment_method',
            data:{number_of_payment:number_of_payment,tax_order_id:tax_order_id,mode_of_payment:mode_of_payment,mop1:mop1,mop2:mop2},  
            dataType:"json",
            success : function(data){
                console.log(data);
                }
            });
            }
   


});



$("#number_of_payment").change(function(){
    var id = $("#mop_land_id").val();
    mop_compute(id);
});

function mop_compute(id)
{
    var mop = $("#mode_of_payment1").val();
    var total = moneyToNum($("#mop_total_payment").val());
    var balance = moneyToNum($("#mop_balance").val());
    var compromise = $("#number_of_payment").val();
    console.log(compromise);
    var assessed_value = 0;
    var id = id;
    $(".cmop").remove();
    $.ajax({
        type : 'POST',
        url : global.settings.url + 'Payment/mop_compute',
        data:{id: id},
        dataType:"json",
        success : function(data){
            var payment_html = "";
            assessed_value = data.assessed_value;
            var payment = (parseFloat(assessed_value) * 0.01) * 2;
            var basic = data.basic;
            var discount = data.discount;
            var penalty = data.penalty;
            var tax = (parseFloat(assessed_value) * .01) *2;
            var  pastpayment = ((parseFloat(basic) * 2) + (parseFloat(penalty) * 2) - (parseFloat(discount) * 2)) - tax;
            
            
         
            if(balance == total)
            {
              
                
               if(total == payment){
                   console.log("pasok");
                   console.log(mop);
                   switch(mop)
                   {
                      
                        case "Annually":
                            var first_payment = total;
                            payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop1' class ='form-control ' name = 'mop1' value = '"+first_payment+"' readonly></div>";
                            console.log(payment_html);
                        break;
                        case "Semi Annually":
                            var first_payment = (parseFloat(tax)/ 2);
                            var div_payment = parseFloat(tax)/ 2;
                            console.log(first_payment);
                            payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop1' class ='form-control ' name = 'mop1' value ='"+first_payment+"' readonly></div>";
                            payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop2' class ='form-control ' name = 'mop2' value = '"+money(div_payment)+"' readonly></div>";
                            console.log(payment_html);
                        break;
                        case "Quarterly":
                            var first_payment = parseFloat(tax)/ 4;;
                            var div_payment = parseFloat(tax) / 4;
                            payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop1' class ='form-control ' name = 'mop1' value ='"+money(first_payment)+"' readonly></div>";
                            payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop2' class ='form-control ' name = 'mop2' value = '"+money(div_payment)+"' readonly></div>";
                            payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop3' class ='form-control ' name = 'mop3' value ='"+money(div_payment)+"' readonly></div>";
                            payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop4' class ='form-control ' name = 'mop4' value = '"+money(div_payment)+"' readonly></div>";
                            console.log(payment_html);
                        break;
                        case "Compromise":
                            var first_payment = total / parseFloat(compromise);
                           
                            payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop1' class ='form-control ' name = 'mop1' value ='"+money(first_payment)+"' readonly></div>";
                            
                        break;
                   }
               }
               else{
                   var penalty = parseFloat(total) - parseFloat(payment);
                switch(mop)
                {
                   
                     case "Annually":
                         var first_payment =  parseFloat(pastpayment) + parseFloat(tax);
                         payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop1' class ='form-control ' name = 'mop1' value = '"+money(first_payment)+"' readonly></div>";
                         console.log(payment_html);
                     break;
                     case "Semi Annually":
                         var first_payment =  parseFloat(pastpayment) + (parseFloat(tax)/ 2);
                         var div_payment = parseFloat(tax) / 2;
                         payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop1' class ='form-control ' name = 'mop1' value ='"+money(first_payment)+"' readonly></div>";
                         payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop2' class ='form-control ' name = 'mop2' value = '"+money(div_payment)+"' readonly></div>";
                         console.log(payment_html);
                     break;
                     case "Quarterly":
                        var first_payment =  parseFloat(pastpayment) + (parseFloat(tax)/ 4);
                        var div_payment = parseFloat(tax) / 4;
                         payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop1' class ='form-control ' name = 'mop1' value ='"+money(first_payment)+"' readonly></div>";
                         payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop2' class ='form-control ' name = 'mop2' value = '"+money(div_payment)+"' readonly></div>";
                         payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop3' class ='form-control ' name = 'mop3' value ='"+money(div_payment)+"' readonly></div>";
                         payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop4' class ='form-control ' name = 'mop4' value = '"+money(div_payment)+"' readonly></div>";
                         console.log(payment_html);
                     break;
                     case "Compromise":
                         var first_payment =  (parseFloat(pastpayment) + parseFloat(tax)) /parseFloat(compromise);
                        
                         payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop1' class ='form-control ' name = 'mop1' value ='"+money(first_payment)+"' readonly></div>";
                         
                     break;
                }
               }

            }
            else{
                // logical error. sala to.. bukas ko aayusin...
                //may itatanong kay mam...
                switch(mop)
                {
                   
                     case "Annually":
                         var first_payment = balance;
                         payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop1' class ='form-control ' name = 'mop1' value = '"+money(first_payment)+"' readonly></div>";
                         console.log(payment_html);
                     break;
                     case "Semi Annually":
                         var first_payment = parseFloat(balance) / 1;
                         var div_payment = parseFloat(balance) / 1;
                         payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop1' class ='form-control ' name = 'mop1' value ='"+money(first_payment)+"' readonly></div>";

                         console.log(payment_html);
                     break;
                     case "Quarterly":
                         var first_payment = parseFloat(balance) /2;
                         var div_payment = parseFloat(balance) /2;
                         payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop1' class ='form-control ' name = 'mop1' value ='"+money(first_payment)+"' readonly></div>";
                         payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop2' class ='form-control ' name = 'mop2' value = '"+money(div_payment)+"' readonly></div>";
                        
                         console.log(payment_html);
                     break;
                     case "Compromise":
                         var first_payment = parseFloat(balance)/ parseFloat(compromise);
                        
                         payment_html += "<div class ='col-md-6 cmop'><input type = 'text' id = 'mop1' class ='form-control ' name = 'mop1' value ='"+money(first_payment)+"' readonly></div>";
                         
                     break;
                }
            }
            console.log(payment_html);
            
            $("#payment_here").append(payment_html);
        },
        error : function(xhr){

        }
    });


}




$("#cash_payment").click(function(){
     
    $("#cash_payment").val("");
 
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

