var year;
var dataTable;

$(document).ready(function(){

    year();
    clearance_table();



    // $('.gogoprint').click(function(){
    //     alert('asd');   
    // });


    
// $('#year').change(function(){
//     year = $(this).val();
//     $('#posts').dataTable().fnDestroy();
//     clearance_table(year);
//     // alert(year);.
// });



// function year()
// {
//     var year = new Date().getFullYear();

//     var html = "";
//     for(i=2000;year>i;year--)
//     {
//         html += "<option value = '"+year+"'>"+year+"</option>";
//     }
//     $("#year").append(html);
// }




function clearance_table(year)
{

    
    $(document).ready(function () {
        dataTable = $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            
            "ajax":{
             data: {year:year},
             "url": global.settings.url + "Clearance/clearance_table",
             "dataType": "json",
             "type": "POST",
             
                           },
        "columns": [
                  
                  { "data": "owner"},
                  { "data": "pin" },
                  { "data": "tax_dec_no"},
                  { "data": "action" },
               ]    
        });
    })
    
}


});



function print(val){
    $("#pin").val(val);
    $('#printData').modal('show');
}

// $("#print_data").submit(function(e){
//     e.preventDefault();
//     console.log($('#print_data').serializeArray());
//     // $.ajax({   
//     //     type: 'POST',  
//     //     url: global.settings.url + '/Clearance_print/clearance', 
//     //     data:$('#print_data').serializeArray(),
//     //     xhrFields: {responseType: 'blob'},
//     //     success: function(res) {
//     //         var url = window.URL.createObjectURL(res);
//     //         $("#printData").modal("hide");
//     //         $('#myframe').attr('src',url);
//     //         $("#printclearance").modal("show");
//     //     }
//     //             });

//     $('#printData').modal('hide');
             

//                 $('#printclearance').modal({
//                     backdrop: 'static',
//                     keyboard: false
//                 })
        
//                 $('#printclearance').modal('show');	
//                 $.ajax({  
//                     type: 'POST',  
//                     url: global.settings.url + '/Clearance_print/clearance', 
//                     data: $('#print_data').serialize(),
//                     xhrFields: {
//                         responseType: 'blob'
//                     },
//                     success: function(res) {
//                         console.log(res);
//                         var url = window.URL.createObjectURL(res);
//                         $('#myframe').attr('src',url);
//                     },
//                     error: function(xhr){
//                         xhr.responseText()
//                     }
//                     });
               
//             });

function printmodalshow()
{
    $.ajax({  
        type: 'POST',  
        url: global.settings.url + '/Clearance_print/clearance_print', 
        data: $('#print_data').serialize(),
        xhrFields: {
            responseType: 'blob'
        },
        success: function(res) {
            console.log(res);
            var url = window.URL.createObjectURL(res);
            $('#myframe').attr('src',url);
        },
        error: function(xhr){
            xhr.responseText()
        }
        });
   
}








function clearance(val){
    
    $('#printData').modal('show');
    $("#tax_idd").val(val);

}

$("#print_data").submit(function(e){
    e.preventDefault();

   
    $.ajax({  
        type: 'POST',  
        url: global.settings.url + '/Clearance/verifyClearance', 
        data: $('#print_data').serialize(),
        dataType: "json",
        
        success: function(data){

           
           if(data == "success"){

            console.log("test");
            $('#printclearance').modal('show');	
            $.ajax({  
                type: 'POST',  
                url: global.settings.url + '/Clearance/viewClearance', 
                data: $('#print_data').serialize(),
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(res) {
                    console.log(res);
                    $('#printData').modal('hide');
                    var url = window.URL.createObjectURL(res);
                    $('#myframe').attr('src',url);
                },
                error: function(xhr){
                    xhr.responseText()
                }
                });

           }
           else{

                 
            Swal.fire({
                icon: 'error',
                title: 'Wrong O.R Number',
                text: 'Please input the correct O.R number',
               
            });
           }
          
        },
        error: function(xhr){
            xhr.responseText()
        }
        });
   
});


function printmodalshow()
{
    $.ajax({  
        type: 'POST',  
        url: global.settings.url + '/Clearance/clearance_print', 
        data: $('#print_data').serialize(),
        xhrFields: {
            responseType: 'blob'
        },
        success: function(res) {
            console.log(res);
            var url = window.URL.createObjectURL(res);
            $('#myframe').attr('src',url);

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
                    

                    $.ajax({
                        type : 'POST',
                        url : global.settings.url + 'Clearance/clearance_clear',
                        // data:{},
                        dataType:"json",
                        success: function(data) {
                            console.log(data);


                            
                        },
                    });
                }
              })


        },
        error: function(xhr){
            xhr.responseText()
        }
        });
}











