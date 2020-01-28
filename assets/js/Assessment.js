var dataTable;
var balance_basic;
var balance_sef;
var balance_penalty;
var balance_discount;
var balance_total;


$(document).ready(function(){

    year();

   
    // TABLE
    $(document).ready(function () {
        dataTable = $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
             "url": global.settings.url + "Assessment/show_payment",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                           },
        "columns": [
                  
                  { "data": "full_name"},
                  { "data": "location" },
                  { "data": "pin" },
                  { "data": "arp_no" },
                  { "data": "date" },
                  { "data": "action" },
               ]    


        });
    });
    //END OF TABLE

    $(".due_payment_decimal").keyup(function(){
        var total;
        var sum = 0;
        $('.due_payment_add').each(function(){
            var due = ($(this).val() == ""||$(this).val() == " ") ? 0 : $(this).val();
            sum += parseFloat(due); 
           total = sum.toFixed(2);
           $("#total").val(total);
    
        });
        var discount = ($("#discount").val() == ""||$("#discount").val() == " ") ? 0 : $("#discount").val();
        var sef = $("#basic").val();
        
        var over_all_total = parseFloat(total) + parseFloat(sef) - parseFloat(discount);
        var totalwithdiscount = over_all_total.toFixed(2);
        $("#sub_total").val(totalwithdiscount);
        
    });

    $(".collected_payment_decimal").keyup(function(){
        var total;
        var sum = 0;
        $('.collected_payment_add').each(function(){
            var due = ($(this).val() == ""||$(this).val() == " ") ? 0 : $(this).val();
            sum += parseFloat(due); 
           total = sum.toFixed(2);
           $("#collected_total").val(total);
    
        });

        var discount = ($("#collected_discount").val() == ""||$("#collected_discount").val() == " ") ? 0 : $("#collected_discount").val();
        var over_all_total = parseFloat(total) - parseFloat(discount);
        var totalwithdiscount = over_all_total.toFixed(2);
        $("#collected_total").val(totalwithdiscount);
        
    });

 
    
}); 

function assessment(val){
   
    $("#add_assessment")[0].reset();
    var id = val;
    $(".payment").val("");

    $.ajax({
        type : 'POST',
        url : global.settings.url + 'Assessment/select_owner',
        data:{id: id},
        dataType:"json",
        success : function(data){
            var basic = parseFloat(data.assessed_value) * .01;
            var subtotal = basic * 2;
            var html_owner ="";
            
            $("#addAssessment").modal("show");
            $("#idd").val(data.land_faas_id);
           console.log(data);
            $("#pin").val(data.pin);
            $("#arp").val(data.arp_no);
            $("#location").val("Brgy. "+data.location);
            $("#basic").val(basic.toFixed(2));
            $("#sub_total").val(subtotal.toFixed(2));
            $("#status_of_tax").val(data.status_of_tax);
            $("#assess_effectivity").val(data.assess_effectivity);
            var assessed_value = data.assessed_value;
            assessed_value = parseFloat(assessed_value);
            var assessev_val = assessed_value.toFixed(2);
            
            $("#assessed_value").val(assessev_val);
            
           

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

function year()
{
    var year = new Date().getFullYear();
    var html = "";
    for(i=2000;year>i;year--)
    {
        html += "<option value = '"+year+"'>"+year+"</option>";
    }
    $("#tax_year").append(html);
}

$("#add_assessment").submit(function(e){
    e.preventDefault();

    $.ajax({
            type : 'POST',
            url : global.settings.url + 'Assessment/insert_assessment',
            data:new FormData(this),  
            // dataType:"json",
            processData: false,
            contentType: false,
            success : function(data){

                 $("#addAssessment").modal("hide");
                $("#add_assessment")[0].reset();
                $(".payment").val("");
                Swal.fire(
                    'Assessed Successfuly!',
                    '',
                    'success'
                  )
            },
            error:function(xhr){
                console.log(xhr);
            },
        });

});









