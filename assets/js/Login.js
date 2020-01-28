
$(document).ready(function(){

    $(document).on('submit', '#login_user', function(event){
        event.preventDefault();

             $.ajax({
                  url:  global.settings.url +"Login/login_user",  
                  method:'POST',
                  type: 'json',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  success:function(data)
                  {



                   var data = JSON.parse(data);

                    if(data.msg == "usernameError"){
                      Swal.fire({
                        icon: 'error',
                        title: 'Wrong Credentials',
                        text: 'Username not found'
                      });
                    }
                    else if(data.msg == "passwordError"){
                      Swal.fire({
                        icon: 'error',
                        title: 'Wrong Credentials',
                        text: 'password does not match'
                      });
                    }
                    else if(data.flag == 1){
                        location.href = global.settings.url + '/Dashboard';
                    }


                  }
             });


   });


});
