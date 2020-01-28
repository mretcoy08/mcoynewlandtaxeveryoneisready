$(document).ready(function(){
   
    
    profileName(); 

});

function profileName()
{
    
//     $.ajax({  
//         url: global.settings.url + "Main_controller/profile_name",  
//         method:'POST',
//         type: 'json',   
//         contentType:false,  
//         processData:false,  
//         success:function(data)  
//         {   
            
//             var data = JSON.parse(data);
           
//             $("#profile_name").text(data.role + ": " + data.name);
//         }  
//    });  
}

function sidebar()
{
    $.ajax({
        url: globalThis.settings.url + "Main_controller/sidebar",
        method: "POST",
        type: "json",
        success:function(data){
            
        }
    });
}