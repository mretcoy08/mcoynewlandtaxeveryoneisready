$(document).ready(function(){

    $('.res').attr('hidden',true);
    $('.empsidenav').attr('hidden',true);
 restrict();
 emprestrict();
    
});


function restrict()
{
    $.ajax({
        url : global.settings.url + '/Restriction/restrict',
        type : 'POST',
        data : $(this).serialize(),
        dataType : 'json',
        success : function(res){

          var len = res.pages.length;
          if(len!=null)
          {
            for(i=0;i<res.pages.length;i++){
                
              $("#"+res.pages[i]).attr('hidden',false);
         }
          }
            
            
        },
        error : function(xhr){
          console.log(xhr.responseText);
        }
      });
}

function emprestrict()
{
    $.ajax({
        url : global.settings.url + '/Restriction/restrict',
        type : 'POST',
        data : $(this).serialize(),
        dataType : 'json',
        success : function(res){

          var len = res.pages.length;
          console.log(res.pages.length);
          if(len!=null)
          {
        
            for(i=0;i<res.pages.length;i++){
              console.log(res.pages[i]);
              $("#"+res.pages[i]+"emp").attr('hidden',false);
         }
          }
            
            
        },
        error : function(xhr){
          console.log(xhr.responseText);
        }
      });
}

