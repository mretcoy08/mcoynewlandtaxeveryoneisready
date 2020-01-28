var dataTable;
// var sort = array();

$(document).ready(function(){
    table();
     sort();
});



function sort()
{
    $(document).ready(function () {
        $.ajax({  
            url: global.settings.url + "Audit_trail/sort",  
            method:'POST',   
            contentType:false,  
            processData:false,  
            success:function(data)  
            {  
                var html_user = "";
                var html_action = "";
                var data = JSON.parse(data);
                console.log(data);
                 $.each(data['user'], function( index, value ) {
                    html_user += "<option class = 'form-control' type = 'text' value = '" +value['username']+"'> "+value['username']+"</option>";
                   
                   });
                $.each(data['action'], function( index, value ) {
                    html_action += "<option class = 'form-control' type = 'text' value = '" +value['action']+"'> "+value['action']+"</option>";
                   
                   });
                   $("#action").append(html_action);
                   $("#user").append(html_user);
        
            },  
    }); 
    }); 
}

function table(user,action,module,date)
{

    $(document).ready(function () {
        dataTable = $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
             "url": global.settings.url + "Audit_trail/show_logs",
             "dataType": "json",
             "type": "POST",
             "data":{user:user,action:action,module:module,date:date}
                           },
        "columns": [
                  
                  { "data": "user"},
                  { "data": "action"},
                  { "data": "what" },
                  { "data": "module" },
                  { "data": "date" },
               ]    


        });
    });
}


$(".sort").change(function(){
   var user = $("#user").val();
   var action = $("#action").val();
   var module = $("#module").val();
   var date = $("#date").val();

    console.log(user);
    console.log(action);
    console.log(module);
    console.log(date);
    $("#posts").dataTable().fnDestroy();
    table(user,action,module,date);

});


     

  
