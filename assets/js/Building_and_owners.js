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
            $("#land_id").val(data.id);
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

  $("#additional_owner").click(function(){

    add_line.push({
      'ol[first_name]' :$("#first_name").val(),
      'ol[middle_name]' :$("#middle_name").val(),
      'ol[last_name]' :$("#last_name").val(),
  });

  var table = document.getElementById("tableOwner");
  var row= document.createElement("tr");
  row.setAttribute('id','row'+row_id);
  row.setAttribute('class','rowrow');
  var td1 = document.createElement("td");
  var td2 = document.createElement("td");
  var td3 = document.createElement("td");
  var td4 = document.createElement("td");
  td1.innerHTML = document.getElementById("first_name").value;
  td2.innerHTML  = document.getElementById("middle_name").value;
  td3.innerHTML  = document.getElementById("last_name").value;
  td4.innerHTML  = '<button type="button" class="btn_delete btn btn-danger cor_del" id="'+row_id+'">Delete</button>';
  row.appendChild(td1);
  row.appendChild(td2);
  row.appendChild(td3);
  row.appendChild(td4);
  table.children[0].appendChild(row);
  console.log(add_line);
  row_id++;
  row_num++;

  $("#first_name").val("");
  $("#middle_name").val("");
  $("#last_name").val("");

});

$(document).on('click', '.btn_delete', function(){

var a = $(this).attr("id");
row_num--;
delete add_line[a];
$('#row'+a+'').remove(); 
console.log(add_line);

});

$("#add_land_and_owner").submit(function(e){
  e.preventDefault();
var data =  $(this).serialize();
console.table(data);

// Array.prototype.push.apply(save, add_line);
console.table(save);
    $.ajax({  
      url: global.settings.url + "Building_and_owners/insert",  
      method:'POST',  
      data:data,  
      success:function(data)  
      {  
         
          var building_id = data;

          add_line = add_line.filter(function(el){
            return el != null;
          });  
          console.log(add_line);

          for(i=0;i<add_line.length;i++){
            add_line[i]["ol[building_id]"] = building_id;
            $.ajax({  
              url: global.settings.url + "Building_and_owners/insert_owners",  
              method:'POST',  
              data:add_line[i],  
              success:function(data)  
              {  
                  
              }  
          });  

          }
          Swal.fire(
            'Insert Successful!',
            '',
            'success'
          )
          dataTable.ajax.reload();
          add_line = [];
          row_id = 0;
          row_num = 0;
          $(".rowrow").remove();
          $(".new_input").val("");
          $("#addBuildingAndOwner").modal("hide");
      
      }  
  });  

});









