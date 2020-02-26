var add_line = []
var row_id = 0;
var row_num = 0;
var save = [];
var first_name = [];
var middle_name = [];
var last_name = [];
var dataTable;
$(document).ready(function(){
 

})


function land_search(search)
{   

    
    var land_search = search;

        dataTable = $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "bFilter": false,
            "ajax":{
             "url": global.settings.url + "Tax_order_assessment/assessment_table",
             "data":{land_search:land_search},
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


$("#add").click(function(e){
    e.preventDefault();
  
    $(".rowrow").remove();
    $(".new_input").val("");
    add_line = [];
    row_id = 0;
    row_num = 0;
   
    $("#addBuildingAndOwner").modal("show");
   
    
  
    var year = new Date().getFullYear()-1;
    var limit = new Date().getFullYear() -12;
    
    var html = "";
    for(limit;year>limit;year--)
    {
        html += "<option value = '"+year+"'>"+year+"</option>";
    }
  $("#last_year_paid").append(html);
  console.log(html);
  
  
  });


  $("#land_pin").change(function(){
    var land_pin = $(this).val();
    $.ajax({  
        url: global.settings.url + "Building_and_owners/getland",  
        method:'POST',  
        data:{land_pin:land_pin},  
        dataType:'json',
        success:function(data)  
        {  
        
            var data = data[0];
            var subd = data.subdivision;
            $.ajax({  
                url: global.settings.url + "Building_and_owners/getSubdivision",  
                method:'POST',  
                data:{subd:subd},  
                dataType:'json',
                success:function(data)  
                {  
                    $("#subdivision").val(data[0].subdivision_name);
                },
            });
           
            console.log(data.assessed_value);

            $("#barangay").val(data.barangay);
            $("#lot_no").val(data.lot_no);
            $("#block_no").val(data.block_no);
            $("#street").val(data.street);
            $("#city").val(data.city);
            $("#subdivision").val(data.subdivision);
            $("#province").val(data.province);

            $("#class").val(data.class);
            $("#sub_class").val(data.sub_class);
            $("#land_status").val(data.land_status);
            $("#assessed_value").val(money(data.assessed_value));
            $(".flood_subd").remove();
            $("#subdivision").append(html_subdivision);
          
  
            console.log('test');
        }  
  });
});







