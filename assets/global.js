  var global = {
  settings : {

    
    // url : 'http://localhost/NEWLANDTAX/'
    url: 'http://192.168.3.24:8000/'
  },
}

var counter = 0;
var data_user;


(user_id != 0) ? $.ajax({
  url : global.settings.url + '/Datamanager/getUserCredentials',
  type : 'POST',
  data : {
    user_id : user_id
  },
  dataType : 'json',
  success : function(res){
    console.log(res);
    // console.log();
  },
  error : function(xhr){
    console.log(xhr.responseText);
  }
}) : logout();

function logout() {
  alert('You have logged out. Please Login Again');
  window.location.href = global.settings.url + '/pages/login';
}

function jsUcfirst(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function notify(msg,type) {
  setTimeout(function() {
                  $.bootstrapGrowl(msg, {
                      type: type,
                      align: 'right',
                      width: 'auto',
                      allow_dismiss: false
                  });
              }, 500);

}

function createCommas(x) {
  var parts = num.toString().split(".");
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

  return parts.join(".");
}

function money(x){
  var num =  parseFloat(x).toFixed(2);
  var parts = num.toString().split(".");
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

  return parts.join(".");
}


function moneyToNum(x)
{
  return x.replace(",","");
}

function addMoney(num1,num2){
  var num1 = num1.replace(",", "");
  var num2 = num2.replace(",", "");

  return parseFloat(num1) + parseFloat(num2);
}

function subMoney(num1,num2){
  var num1 = num1.replace(",", "");
  var num2 = num2.replace(",", "");

  return parseFloat(num1) - parseFloat(num2);
}

function mulMoney(num1,num2){
  var num1 = num1.replace(",", "");
  var num2 = num2.replace(",", "");

  return parseFloat(num1) * parseFloat(num2);
}

function divMoney(num1,num2){
  var num1 = num1.replace(",", "");
  var num2 = num2.replace(",", "");

  return parseFloat(num1) / parseFloat(num2);
}