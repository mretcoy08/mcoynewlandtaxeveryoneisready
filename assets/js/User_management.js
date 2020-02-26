var dataTable = "";

$(document).ready(function(){
    
  
     $(document).ready(function () {
        dataTable = $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
             "url": global.settings.url + "User_management/show_users",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                           },
        "columns": [
                  
                  { "data": "username"},
                  { "data": "first_name" },
                  { "data": "contact_number" },
                  { "data": "action" },
               ]    


        });
    });

    $('#add').click(function(){
        $('#h4user').text('Add User');
        $('#addbtn').text('Add User');
        $('#update_user').attr('id','add_user');
        $('#first_name').attr("readonly",false);
        $('#middle_name').attr("readonly",false);
        $('#last_name').attr("readonly",false);
        $('#username').attr("readonly",false);
        $('#add_user')[0].reset(); 
    });


    $(document).on('submit', '#add_user', function(event){  
        event.preventDefault();   
       
       
             $.ajax({  
                  url: global.settings.url + "User_management/add_user",  
                  method:'POST',  
                  data:new FormData(this),  
                  contentType:false,  
                  processData:false,  
                  success:function(data)  
                  {  
                       
                       $('#add_user')[0].reset();  
                       $('#addUser').modal('hide');   
                       dataTable.ajax.reload();

                        Swal.fire(
                           'Add Successfully!',
                           '',
                           'success'
                           
                         )
                  
                  }  
             });  
         
     
   });  

   
  

   $(document).on('submit', '#update_user', function(event){  
    event.preventDefault();   
   
   
         $.ajax({  
              url: global.settings.url + "User_management/update_user",  
              method:'POST',  
              data:new FormData(this),  
              contentType:false,  
              processData:false,  
              success:function(data)  
              {  
               
                $('#role').attr('required',true);
                   $('#update_user')[0].reset();  
                   $('#addUser').modal('hide');   
                   dataTable.ajax.reload();
                    console.log(data);
                    Swal.fire(
                       'Update Successfully!',
                       '',
                       'success'
                       
                     )
              
              }  
         });  
     
 
});  

   $(document).on('click','.updbtn',function(){
        var id = $(this).attr('id');
        $('#addbtn').text('Update User');
        $('#add_user').attr('id','update_user');
        $.ajax({
                type : 'POST',
                url : global.settings.url + 'User_management/select_user',
                data:{id: id},
                dataType:"json",
                success : function(data){

                    $('#addUser').modal('show');
                    $('#add_User').attr('id','update_user')
                    $('#first_name').val(data.first_name);
                    $('#middle_name').val(data.middle_name);
                    $('#last_name').val(data.last_name);
                    $('#username').val(data.username);
                    $('#password').val(data.password);
                    $('#contact_number').val(data.contact_number);
                    $('.hide').attr('hidden',true);
                    $('#role').attr('hidden',true);
                    $('#role').attr('required',false);
                    $('#ddd').val(data.id);
                    $('#h4user').text('Update User');

                    $('#first_name').attr("readonly",true);
                    $('#middle_name').attr("readonly",true);
                    $('#last_name').attr("readonly",true);
                    $('#username').attr("readonly",true);

                    console.log(data);
                

                
    
                },
                error:function(){
                    console.log('mali');
                },
                });
        });

       
        $('#username').change(function(){
            var username = $('#username').val();
            $.ajax({
                type : 'POST',
                url : global.settings.url + 'User_management/check_username',
                data:{username: username},
                dataType:"json",
                success : function(data){
                    if(data == "meron"){
                        Swal.fire({
                            icon: 'error',
                            title: 'Username Already Taken', 
                          })

                          $('#username').val("");
                    }
                    
                },
                error:function(){
                  console.log('mali');
                },
              });

        });

    


});