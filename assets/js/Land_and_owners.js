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

$(document).ready(function () {
  dataTable = $('#posts').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax":{
       "url": global.settings.url + "Land_and_owners/show_land",
       "dataType": "json",
       "type": "POST",
       "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                     },
  "columns": [
            
            { "data": "pin"},
            { "data": "tax_dec_no" },
            { "data": "class" },
            { "data": "assessed_value" },
            { "data": "land_status" },
            { "data": "action" },
         ]    


  });
});

$("#pin_barangay").change(function(){
    var brgycode = $(this).val();
    console.log(brgycode);
    $.ajax({  
        url: global.settings.url + "Land_and_owners/getBarangayAndSubdivision",  
        method:'POST',   
        data:{brgycode:brgycode}, 
        success:function(data)  
        {  
          
          console.log(JSON.parse(data));
          var data = JSON.parse(data);
          console.log(data.subdivision);
          console.log(data.barangay[0].district_code);
          var pinDistrict = (data.barangay[0].district_code) ? data.barangay[0].district_code : "";
          var barangay = (data.barangay[0].barangay_name) ? data.barangay[0].barangay_name : "";
          $("#pin_district").val(pinDistrict);
          $("#barangay").val(barangay);
          var html_subdivision
          $.each(data['subdivision'], function( index, value ) {
            html_subdivision += "<option class = 'form-control flood_subd' type = 'text' value = '" +value['location_subdivision_id']+"'> "+value['subdivision_name']+"</option>";
                   
                   });
          $(".flood_subd").remove();
          $("#subdivision").append(html_subdivision);
        

        },  
    }); 
});

$("#uppin_barangay").change(function(){
  var brgycode = $(this).val();
  console.log(brgycode);
  $.ajax({  
      url: global.settings.url + "Land_and_owners/getBarangayAndSubdivision",  
      method:'POST',   
      data:{brgycode:brgycode}, 
      success:function(data)  
      {  
        
        console.log(JSON.parse(data));
        var data = JSON.parse(data);
        console.log(data.subdivision);
        console.log(data.barangay[0].district_code);
        var pinDistrict = (data.barangay[0].district_code) ? data.barangay[0].district_code : "";
        var barangay = (data.barangay[0].barangay_name) ? data.barangay[0].barangay_name : "";
        $("#uppin_district").val(pinDistrict);
        $("#upbarangay").val(barangay);
        var html_subdivision
        $.each(data['subdivision'], function( index, value ) {
          html_subdivision += "<option class = 'form-control flood_subd' type = 'text' value = '" +value['location_subdivision_id']+"'> "+value['subdivision_name']+"</option>";
                 
                 });
        $(".flood_subd").remove();
        $("#upsubdivision").append(html_subdivision);
      

      },  
  }); 
});



$("#subdivision").change(function(){
  var subdivision = $(this).val();

  $.ajax({  
    url: global.settings.url + "Land_and_owners/subdivision_class",  
    method:'POST',   
    data:{subdivision:subdivision}, 
    success:function(data)  
    {
      var gdata = JSON.parse(data);
   
      $("#sub_class").val(gdata.subdivision[0].sub_class);
    },  
}); 
    
});

$("#upsubdivision").change(function(){
  var subdivision = $(this).val();

  $.ajax({  
    url: global.settings.url + "Land_and_owners/subdivision_class",  
    method:'POST',   
    data:{subdivision:subdivision}, 
    success:function(data)  
    {
      var gdata = JSON.parse(data);
   
      $("#upsub_class").val(gdata.subdivision[0].sub_class);
    },  
}); 
    
});

$("#add").click(function(e){
  e.preventDefault();
  $(".rowrow").remove();
  $(".new_input").val("");
  add_line = [];
  row_id = 0;
  row_num = 0;
 
  $("#addLandAndOwner").modal("show");
 
  

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
        url: global.settings.url + "Land_and_owners/insert",  
        method:'POST',  
        data:data,  
        success:function(data)  
        {  
           
            var land_id = data;

            add_line = add_line.filter(function(el){
              return el != null;
            });  
            console.log(add_line);

            for(i=0;i<add_line.length;i++){
              add_line[i]["ol[land_id]"] = land_id;
              $.ajax({  
                url: global.settings.url + "Land_and_owners/insert_owners",  
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
            $("#addLandAndOwner").modal("hide");
        
        }  
    });  

});

function updbtn(val)
{ var id = val;
      $.ajax({  
        url: global.settings.url + "Land_and_owners/getland",  
        method:'POST',  
        data:{id:id},  
        success:function(data)  
        {   
            console.table(JSON.parse(data));
            var data = JSON.parse(data);
             data = data[0];
             var brgycode = data.pin_barangay;
             $.ajax({  
              url: global.settings.url + "Land_and_owners/getBarangayAndSubdivision",  
              method:'POST',   
              data:{brgycode:brgycode}, 
              success:function(data)  
              {  
                var data = JSON.parse(data);
                var barangay = (data.barangay[0].barangay_name) ? data.barangay[0].barangay_name : "";
         
                $("#upbarangay").val(barangay);
                var html_subdivision;
                $.each(data['subdivision'], function( index, value ) {
                  html_subdivision += "<option class = 'form-control flood_subd' type = 'text' value = '" +value['location_subdivision_id']+"'> "+value['subdivision_name']+"</option>";
                         
                         });
                $(".flood_subd").remove();
                $("#upsubdivision").append(html_subdivision);
                
              
      
              },  
          }); 
            $("#uppin_city").val(data.pin_city);
            $("#uppin_district").val(data.pin_district);
            $("#uppin_barangay").val(data.pin_barangay);
            $("#uppin_section").val(data.pin_section);
            $("#uppin_parcel").val(data.pin_parcel);

            $("#uptax_dec_no").val(data.tax_dec_no);

            $("#uplot_no").val(data.lot_no);
            $("#upblock_no").val(data.block_no);
            $("#upstreet").val(data.street);
            $("#upcity").val(data.city);
            $("#upsubdivision").val(data.subdivision);
            $("#upprovince").val(data.province);

            $("#upclass").val(data.class);
            $("#upsub_class").val(data.sub_class);
            $("#upland_status").val(data.land_status);
            $("#upassessed_value").val(data.assessed_value);
          
            $("#idd").val(id);
            console.log('test');
           

            $("#updateLand").modal("show");

        }  
    });  
}

$("#update_land").submit(function(e){
  e.preventDefault();
  var data =  $(this).serialize();
  console.log(data);
  $.ajax({  
    url: global.settings.url + "Land_and_owners/update_land",  
    method:'POST',  
    data:$(this).serialize(),  
    success:function(data)  
    {  
      console.table(data);
      Swal.fire(
        'Update Successful!',
        '',
        'success'
      )
    }  
});  
});

function ownerbtn(val)
{
  add_line = [];
  first_name = [];
  middle_name = [];
  last_name = [];
  var id = val;

  $("#updateOwner").modal("show");

  $.ajax({  
    url: global.settings.url + "Land_and_owners/getowner",  
    method:'POST',  
    data:{id:id},  
    success:function(data)  
    {  var data = JSON.parse(data);
        
        for(i=0;i<data.length;i++)
        {
          first_name[i]= data[i].first_name;
          middle_name[i]= data[i].middle_name;
          last_name[i]= data[i].last_name;
        }
        console.log(first_name+" "+middle_name+" "+last_name);
        
    }  
});  
}




