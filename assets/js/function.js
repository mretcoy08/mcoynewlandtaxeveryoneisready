

function monthDiff(lastMonth, lastYear){

	var date = new Date();
	var month  = date.getMonth() + 1;
	var year =  date.getFullYear();
	return (((parseInt(year) - parseInt(lastYear)) * 12) + parseInt(month)) - parseInt(lastMonth);
}

function penalty(payment,penaltyPercentage,monthDiff){
	var mDiff = "";
	if(monthDiff>72)
	{
		mDiff = 72;
	}
	else{
		mDiff = monthDiff;
	}
	var penalty = (payment * ((monthDiff * penaltyPercentage)/100));
	return penalty;
}



function advYear(append)
{
	var year = new Date().getFullYear();
	var advyear = year +3;
  
    var html = "";
    for(advyear;year<advyear;year++)
    {
        html += "<option value = '"+year+"'>"+year+"</option>";
    }
	$("#"+append+"").append(html);
	console.log(advyear);
}


function year(append)
{
    var year = new Date().getFullYear();
  
    var html = "";
    for(i=2000;year>i;year--)
    {
        html += "<option value = '"+year+"'>"+year+"</option>";
    }
	$("#"+append+"").append(html);
	console.log(append);
}



function asd(number) {  
    console.log(number);

    var digit = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];  
    var elevenSeries = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];  
    var countingByTens = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];  
	var shortScale = ['', 'thousand', 'million', 'billion', 'trillion'];  
	
	number = number.toString(); 
	number = number.replace(/[\, ]/g, ''); 
	
	if (number != parseFloat(number)) return 'not a number';
	 var x = number.indexOf('.');
	 if (x == -1) x = number.length; if (x > 15) return 'too big';
	  var n = number.split('');
	  var str = ''; 
	  var sk = 0; 

	  for (var i = 0; i < x; i++) 
	  {

		if ((x - i) % 3 == 2) {
			
		   if (n[i] == '1') { 
			   str += elevenSeries[Number(n[i + 1])] + ' '; i++;
				sk = 1; }
		   else if (n[i] != 0) { str += countingByTens[n[i] - 2] + ' ';
			sk = 1; } 
			} 
		else if (n[i] != 0) 
		{ 
			str += digit[n[i]] + ' ';
			if ((x - i) % 3 == 0) str += 'hundred '; sk = 1; } 
				if ((x - i) % 3 == 1) {
					if (sk) str += shortScale[(x - i - 1) / 3] + ' ';
					sk = 0; } 
	   } 
	  

	   var amt =  str + "Pesos"; 
	   var and =  'and';
	   var cents = '';
	   var cent = '';
	   var c = 'Cents'
	   var check = '';
	   var chk = '';
		if (x != number.length) {
			var y = number.length;
		for (var i = x + 1; i < y; i++) 
		{	
				if ((y - i) % 3 == 2) {
					if (n[i] == '1') { 
						cents += elevenSeries[Number(n[i + 1])] + ' '; i++;
						 sk = 1; }
					else if (n[i] != 0) { cents += countingByTens[n[i] - 2] + ' ';
					 sk = 1; } 
				} 

				else if (n[i] != 0) 
				{ 
					cents += digit[n[i]] + ' ';
					if ((y - i) % 3 == 0) cents += 'hundred '; sk = 1; } 
				if ((y - i) % 3 == 1) {
					if (sk) cents += shortScale[(y - i - 1) / 3] + ' ';
					sk = 0; }
					check += n[i];
			} 
			cent += cents;
		}
					if (check == 00){and = ''; cent = ''; c = '';}
					if (cents ==  ''){c = '';}else{c = 'Cents';}

			return amt + " " + and +" " + cent +" "+c;
			// str = str.replace(/\number+/g, ' ');
			// return str.trim() + " Pesos "+"Only";
}




// var lastYear = $("#last_paid_assessed").val();
// var lastMonth = 1;
// var thisYear = (new Date).getFullYear();
// var diff = [];
// var payment = [];
// var penalty = [];
// var i = 0;
// for(lastYear;lastYear<thisYear;lastYear++)
// {
//      diff[i] = monthDiff(lastMonth,lastYear);
//      payment[i] = parseFloat($("#assessed_value").val()) * .01;
//      penalty[i] = penalty(payment[i],2,diff[i]);
//     i++;
// }
// console.log(diff);
// console.log(penalty);

