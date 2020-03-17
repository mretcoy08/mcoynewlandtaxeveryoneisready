

let garbageFee = 360.00;

var dataTable;
$(document).ready(function(){

year("tax_year");
hide_element();
advYear("year_of_effectivity");
$("#compromise").hide();


//END OF DOCUMENT READY
});

function hide_element()
{
    $("#payment_info").hide();
    $("#real_tax_order_of_payment").hide();

}







function assessment_table(search,searchType)
{   

    
    var assessment_search = search;
    
        dataTable = $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "bFilter": false,
            "ajax":{
             "url": global.settings.url + "Tax_order_assessment/assessment_table",
             "data":{assessment_search:assessment_search,searchType:searchType},
             "dataType": "json",
             "type": "POST",
            
             },
                        
        "columns": [
                  
                  { "data": "owner"},
                  { "data": "location"},
                  { "data": "pin" },
                  { "data": "tax_dec_no" },
                  { "data": "action" },
               ]    
    
    
   
    });
}

$("#taxData").change(function(){
  var data = $(this).val();
  
  if(data == "")
  {
      $("#assessment_search_btn").attr("disabled", true);
      $("#assessment_search").attr("disabled", true);
      var search = "asdqwezxc123";
      $('#posts').DataTable().clear().destroy();
      assessment_table(search),searchType;
  }
  else
  {
  
    $("#assessment_search_btn").attr("disabled", false);
      $("#assessment_search").attr("disabled", false);
  }

});


$("#assessment_search_btn").click(function(e){
    e.preventDefault();
    var searchType = $("#taxData").val();
    // var check = $("#assessment_search").val();
    // $("#posts").dataTable().fnDestroy();
    var search = $("#assessment_search").val();
    //     console.log(search);
    // if($.trim(search) == ''){
    //     Swal.fire('You can\'t search with empty input field');
       
    // }
    // else{
        // $("#posts").dataTable().fnDestroy();
        // $('#posts').DataTable().fnClearTable();
      
        $('#posts').DataTable().clear().destroy();
        assessment_table(search,searchType);
    // }
    

});

function assesst(val)
{   $('#assessment_search').val("");
    $('#posts').DataTable().clear().destroy();
    var searchType  = $("#taxData").val();
    var id = val;
    console.log(val);
    $("#payment_info").show();

    if(searchType == "Land")
    {
     
      $.ajax({
        type : 'POST',
        url : global.settings.url + 'tax_order_assessment/land_assessment',
        data:{id: id},
        dataType:"json",
        success : function(data){
            console.log(data);
          var basic = parseFloat(data.assessed_value) * .01;
            var subtotal = basic * 2;
            var html_owner ="";
            
            $("#idd").val(data.land_faas_id);
            $("#idd").val(id);
            $("#pin").val(data.pin);
            $("#arp").val(data.arp_no);
            $("#location").val(data.location);
            $("#status_of_tax").val(data.status_of_tax);
            $("#last_paid_assessed").val(data.last_paid_assessed);
            
            console.log(data.assessed_value);
            
            $("#assessed_value").val(money(data.assessed_value));
            
           
            $.each(data['full_name'], function( index, value ) {
               html_owner += "<input class = 'form-control payment paymentowners' type = 'text' value = '" +value['full_name']+"' disabled/>";
              });
              $('.paymentowners').remove();
              $("#owners").append(html_owner);


        },
        error:function(){
            console.log('mali');
        },
        });
    }
    else if(searchType == "Building")
    {
      
      $.ajax({
        type : 'POST',
        url : global.settings.url + 'tax_order_assessment/building_assessment',
        data:{id: id},
        dataType:"json",
        success : function(data){
            console.log(data);
          var basic = parseFloat(data.assessed_value) * .01;
            var subtotal = basic * 2;
            var html_owner ="";
            
            $("#idd").val(id);
            $("#pin").val(data.pin);
            $("#arp").val(data.arp_no);
            $("#location").val(data.location);
            $("#status_of_tax").val(data.status_of_tax);
            $("#last_paid_assessed").val(data.last_paid_assessed);
            
            console.log(data.assessed_value);
            
            $("#assessed_value").val(money(data.assessed_value));
            
           
            $.each(data['full_name'], function( index, value ) {
               html_owner += "<input class = 'form-control payment paymentowners' type = 'text' value = '" +value['full_name']+"' disabled/>";
              });
              $('.paymentowners').remove();
              $("#owners").append(html_owner);


        },
        error:function(){
            console.log('mali');
        },
        });
    }

   
}

$("#viewTaxOrder").click(function(e){
    e.preventDefault();
   var id = $("#idd").val();
   var mode_of_payment = $("#mode_of_payment").val();
   var taxData = $("#taxData").val();
   var requestor = $("#requestor").val();
   var last_paid_year = $("#last_paid_assessed").val();
    var assessed_value = $("#assessed_value").val();
    var basic_fee = $("#basic_fee").val();
    var total_fee = $("#total_fee").val(); 
    var mop1 = $("#mop1").val();
    var mop2 = $("#mop2").val();
    var mop3 = $("#mop3").val();
    var mop4 = $("#mop4").val();
    var year_of_effectivity = $('#year_of_effectivity').val();
   $("#printtaxorder").modal("show");

    $.ajax({  
        type: 'POST',  
        url : global.settings.url + 'Tax_order_assessment/viewprint',
        data:{requestor:requestor,taxData:taxData,id:id, mode_of_payment:mode_of_payment,year_of_effectivity:year_of_effectivity},
        xhrFields: {
            responseType: 'blob'
        },
        success: function(res) {
            var url = window.URL.createObjectURL(res);
            $('#taxorder').attr('src',url);
           
        },
        error: function(xhr){
            xhr.responseText()
        }
    });
  

});

$("#print").click(function(e){
    e.preventDefault();
   var id = $("#idd").val();
   var mode_of_payment = $("#mode_of_payment").val();
   var last_paid_year = $("#last_paid_assessed").val();
    var assessed_value = $("#assessed_value").val();
    var taxData = $("#taxData").val();
    var basic_fee = $("#basic_fee").val();
    var total_fee = $("#total_fee").val(); 
    var mop1 = $("#mop1").val();
    var mop2 = $("#mop2").val();
    var mop3 = $("#mop3").val();
    var mop4 = $("#mop4").val();
    var basic_total = $("#total_basic").val();
    var penalty_total = $("#total_penalty").val();
    var discount_total = $("#total_discount").val();
    var year_of_effectivity = $('#year_of_effectivity').val();
    var number_of_payment = $("#number_of_payment").val();
    var down_payment = $("#down_payment").val();
    var garbageFee = $("#garbage_fee").val();
    console.log(taxData);
    console.log(penalty_total);    

    $.ajax({  
        type: 'POST',  
        url : global.settings.url + 'Tax_order_assessment/printTO',
        data:{taxData:taxData,id:id, mode_of_payment:mode_of_payment,year_of_effectivity:year_of_effectivity},
        xhrFields: {
            responseType: 'blob'
        },
        success: function(res) {


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
                      alert(taxData);
                    $.ajax({
                        type : 'POST',
                        url : global.settings.url + 'Tax_order_assessment/print_taxOrder',
                        data:{garbageFee:garbageFee,taxData:taxData,down_payment:down_payment,number_of_payment:number_of_payment,discount_total:discount_total,year_of_effectivity:year_of_effectivity,basic_total:basic_total,penalty_total:penalty_total,mop1:mop1,mop2:mop2,mop3:mop3,mop4:mop4,id:id, mode_of_payment:mode_of_payment,last_paid_year:last_paid_year,assessed_value:assessed_value,basic_fee:basic_fee,total_fee:total_fee},
                        dataType:"json",
                        success: function(data) {
                            console.log(data);
                            
                        },
                    });
                    $("#printtaxorder").modal("hide");
                  
                }
              })
            
            var url = window.URL.createObjectURL(res);
            $('#taxorder').attr('src',url);
            hide_element();
           
        },
        error: function(xhr){
            xhr.responseText()
        }
    });
  

});




$("#compute").click(function(e){
    e.preventDefault();
   var id = $("#idd").val();
   var mode_of_payment = $("#mode_of_payment").val();
   var compromise = $("#number_of_payment").val();
   var year_of_effectivity = $('#year_of_effectivity').val();
   var taxData = $('#taxData').val();
   $(".rowrow").remove();

   $("#real_tax_order_of_payment").show();
    $.ajax({
        type : 'POST',
        url : global.settings.url + 'Tax_order_assessment/compute',
        data:{taxData:taxData,id:id, mode_of_payment:mode_of_payment,year_of_effectivity:year_of_effectivity},
        dataType:"json",
        success : function(data){
            console.log(data);
            
            var length = data['basic'].length;
            var total_fee = 0;
            var upbasic = 0;
            var uppenalty = 0;
            var upyear;
            var upassessed_value;
            var total_penalty = 0;
            var total_discount = 0;
            var total_basic = 0;
            
            if(data.checkPaymentNo == "semicheck"){
                for(i=100;i<101;i++)
               {
                   var getbasic = data["upbasic"][0][i] == null ? 0 : data["upbasic"][0][i];
                   var getpenalty =  data["uppenalty"][0][i] == null ? 0 : data["uppenalty"][0][i];
                    upbasic += parseFloat(getbasic);
                    uppenalty += parseFloat(getpenalty);
                    upyear = data["upyear"][0][i];
                    upassessed_value =data["upassessed_value"][0][i];   
               }
               var table = document.getElementById("tax_order_table");
               var row = document.createElement("tr");
               row.setAttribute('class','rowrow');
               var td1 = document.createElement("td");
               var td2 = document.createElement("td");
               var td3 = document.createElement("td");
               var td4 = document.createElement("td");
               var td5 = document.createElement("td");
               var td6 = document.createElement("td");
               td1.innerHTML =  $("#arp").val();
               td2.innerHTML  = money(upassessed_value);
               td3.innerHTML  = upyear;
               td4.innerHTML  = money(upbasic);
               td5.innerHTML  = money(uppenalty);
               td6.innerHTML  = money(upbasic+uppenalty);
               row.appendChild(td1);
               row.appendChild(td2);
               row.appendChild(td3);
               row.appendChild(td4);
               row.appendChild(td5);
               row.appendChild(td6);
               table.children[0].appendChild(row);
            }
            if(data.checkPaymentNo == "quartercheck"){
               for(i=100;i<103;i++)
               {
                   var getbasic = data["upbasic"][0][i] == null ? 0 : data["upbasic"][0][i];
                   var getpenalty =  data["uppenalty"][0][i] == null ? 0 : data["uppenalty"][0][i];
                    upbasic += parseFloat(getbasic);
                    uppenalty += parseFloat(getpenalty);
                    upyear = data["upyear"][0][i];
                    upassessed_value =data["upassessed_value"][0][i];   
               }
                    
                    var table = document.getElementById("tax_order_table");
                    var row = document.createElement("tr");
                    row.setAttribute('class','rowrow');
                    var td1 = document.createElement("td");
                    var td2 = document.createElement("td");
                    var td3 = document.createElement("td");
                    var td4 = document.createElement("td");
                    var td5 = document.createElement("td");
                    var td6 = document.createElement("td");
                    td1.innerHTML =  $("#arp").val();
                    td2.innerHTML  = money(upassessed_value);
                    td3.innerHTML  = upyear;
                    td4.innerHTML  = money(upbasic);
                    td5.innerHTML  = money(uppenalty);
                    td6.innerHTML  = money(upbasic+uppenalty);
                    row.appendChild(td1);
                    row.appendChild(td2);
                    row.appendChild(td3);
                    row.appendChild(td4);
                    row.appendChild(td5);
                    row.appendChild(td6);
                    table.children[0].appendChild(row);
                }
            // if(data.check = "penaltyWithOutBalance")
            // {   
            //     alert();
            //     var basic = data["basic"][0];
            //     var assessed_value = data["assessed_value"][0];
            //     var year = data["year"][0];
            //     var penalty = 0;
            //     var total = basic;

            //     var table = document.getElementById("tax_order_table");
            //     var row = document.createElement("tr");
            //     row.setAttribute('class','rowrow');
            //     var td1 = document.createElement("td");
            //     var td2 = document.createElement("td");
            //     var td3 = document.createElement("td");
            //     var td4 = document.createElement("td");
            //     var td5 = document.createElement("td");
            //     var td6 = document.createElement("td");
            //     td1.innerHTML =  $("#arp").val();
            //     td2.innerHTML  = assessed_value;
            //     td3.innerHTML  = year;
            //     td4.innerHTML  = basic;
            //     td5.innerHTML  = penalty;
            //     td6.innerHTML  = total;
            //     row.appendChild(td1);
            //     row.appendChild(td2);
            //     row.appendChild(td3);
            //     row.appendChild(td4);
            //     row.appendChild(td5);
            //     row.appendChild(td6);
            //     table.children[0].appendChild(row);
            //     total_fee += total ;
            // }
                for(var counter = 0;counter<length;counter++)
            {
               
                var table = document.getElementById("tax_order_table");
                var row = document.createElement("tr");
                row.setAttribute('class','rowrow');
                var td1 = document.createElement("td");
                var td2 = document.createElement("td");
                var td3 = document.createElement("td");
                var td4 = document.createElement("td");
                var td5 = document.createElement("td");
                var td6 = document.createElement("td");
                td1.innerHTML =  $("#arp").val();
                td2.innerHTML  = money(data['assessed_value'][counter][0]);
                td3.innerHTML  = data['year'][counter][0];
                td4.innerHTML  = money(data['basic'][counter][0]);
                td5.innerHTML  = money(data['penalty'][counter][0]);
                td6.innerHTML  = money(data['total'][counter][0]);
                row.appendChild(td1);
                row.appendChild(td2);
                row.appendChild(td3);
                row.appendChild(td4);
                row.appendChild(td5);
                row.appendChild(td6);
                table.children[0].appendChild(row);
                total_fee += parseFloat(data['total'][counter][0]);
                var pendisc = Math.sign(data['penalty'][counter][0]);
                if(pendisc >=0)
                {
                    total_penalty += parseFloat(data['penalty'][counter][0]);
                }
                else
                {
                    total_discount += parseFloat(data['penalty'][counter][0]);
                }
                
                total_basic += parseFloat(data['basic'][counter][0]);
                
            }
            
            total_penalty = parseFloat(total_penalty) + parseFloat(uppenalty);
            total_basic = parseFloat(total_basic) + parseFloat(upbasic);
            total_fee += parseFloat(upbasic) + parseFloat(uppenalty);
            $("#total_basic").val(money(total_basic));
            $("#total_penalty").val(money(total_penalty));
            $("#total_discount").val(money(total_discount));
            $("#basic_fee").val(money(total_fee));
            $("#special_education_fee").val(money(total_fee));
            $("#garbage_fee").val(money(garbageFee));
            $("#total_fee").val(money(total_fee*2 + garbageFee));
            
            $(".mop").remove();
            var html_mop = "<div class = 'mop'>"+mode_of_payment+"<br>";
            switch(mode_of_payment){
                case "Annually" :
                    var annual = total_fee * 2 + garbageFee;
                    html_mop += "1st <input type = 'text' class= 'form-control mop' id ='mop1' value ='"+money(annual)+"' readonly/> ";
                break;
                case "Semi Annually" :
                    var semi1st = (parseFloat(total_fee) * 2) - (parseFloat(data['basic'][0][0])* 2)/2   + parseFloat(garbageFee);
                    var semi = (parseFloat(data['basic'][0][0])*2)/2;
                    html_mop += "1st <input type = 'text' class= 'form-control mop' id ='mop1' value = '"+money(semi1st)+"'  readonly/> ";
                    html_mop += "2nd <input type = 'text' class= 'form-control mop' id ='mop2' value ='"+money(semi)+"' readonly/>";

                break;
                case "Quarterly" :
                    var quarterly1st = ((parseFloat(total_fee) * 2)+(parseFloat(data['basic'][0][0])/2)) - (parseFloat(data['basic'][0][0])* 2) + parseFloat(garbageFee) ;
                    var quarter = (parseFloat(data['basic'][0][0])*2)/4;
                    html_mop += "1st <input type = 'text' class= 'form-control mop' id ='mop1' value = '"+money(quarterly1st)+"' readonly/> ";
                    html_mop += "2nd <input type = 'text' class= 'form-control mop' id ='mop2' value ='"+money(quarter)+"' readonly/> ";
                    html_mop += "3rd <input type = 'text' class= 'form-control mop' id ='mop3' value ='"+money(quarter)+"' readonly/> ";
                    html_mop += "4th <input type = 'text' class= 'form-control mop' id ='mop4' value ='"+money(quarter)+"' readonly/> ";
                break;
                case "Compromise" :
                    var comp = ((parseFloat(total_fee) * 2) - moneyToNum($("#down_payment").val()))/ parseFloat(compromise);
                    html_mop += "<input type = 'text' class= 'form-control mop' id ='mop1' value = '"+money(comp)+"' readonly/>";
                    
               
            }
             html_mop += "</div>";
            console.log(html_mop);
            $(".paymentsmop").append(html_mop);

        },
    });

});


$("#mode_of_payment").change(function(){
    
    if($(this).val() == "Compromise"){
        $("#compromise").show();
        $("#compromise").attr("required", true);
        
    }
    else{
        $("#compromise").hide();
        $("#compromise").attr("required", false);
    }

});








