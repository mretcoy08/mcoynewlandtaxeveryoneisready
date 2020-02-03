<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------

function numberTowords($num)
{
$ones = array(
0 =>"ZERO",
1 => "ONE",
2 => "TWO",
3 => "THREE",
4 => "FOUR",
5 => "FIVE",
6 => "SIX",
7 => "SEVEN",
8 => "EIGHT",
9 => "NINE",
10 => "TEN",
11 => "ELEVEN",
12 => "TWELVE",
13 => "THIRTEEN",
14 => "FOURTEEN",
15 => "FIFTEEN",
16 => "SIXTEEN",
17 => "SEVENTEEN",
18 => "EIGHTEEN",
19 => "NINETEEN",
014 => "FOURTEEN"
);
$tens = array( 
0 => "ZERO",
1 => "TEN",
2 => "TWENTY",
3 => "THIRTY", 
4 => "FORTY", 
5 => "FIFTY", 
6 => "SIXTY", 
7 => "SEVENTY", 
8 => "EIGHTY", 
9 => "NINETY" 
); 
$hundreds = array( 
"HUNDRED", 
"THOUSAND", 
"MILLION", 
"BILLION", 
"TRILLION", 
"QUARDRILLION" 
); /*limit t quadrillion */
$num = number_format($num,2,".",","); 
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr,1); 
$rettxt = ""; 
foreach($whole_arr as $key => $i){
	
while(substr($i,0,1)=="0")
        $i=substr($i,1,5);
        
if($i < 20){ 
/* echo "getting:".$i; */
$rettxt .= $ones[$i]; 
}elseif($i < 100){ 
if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
}else{ 
if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
} 
if($key > 0){ 
$rettxt .= " ".$hundreds[$key]." "; 
}
} 
if($decnum > 0){
$rettxt .= " PESOS and ";
if($decnum < 20){
$rettxt .= $ones[$decnum];
}elseif($decnum < 100){
$rettxt .= $tens[substr($decnum,0,1)];
$rettxt .= " ".$ones[substr($decnum,1,1)];
$rettxt .= ' '.'CENTS';
}
}
if($decnum > 0){
    return $rettxt;
}else{
    return $rettxt.' '.'PESOS';
}
   
}

if ( ! function_exists('monthDiff')) {

    function monthDiff($lastMonth,$lastYear){	

        $diff = ((date("Y")- $lastYear)*12)+(date("m") - $lastMonth);
        return $diff;
    }
}

if ( ! function_exists('penalty'))
{
    function penalty($payment,$penaltyPercentage,$monthDiff){
        $monthDiff = $monthDiff*$penaltyPercentage;
        $mDiff = "";
        if($monthDiff>72)
        {
            $mDiff = 72;
        }
        else{
            $mDiff = $monthDiff;
        }
        $penalty = ($payment * ($mDiff /100));
        return $penalty;
    }
}

if ( ! function_exists('discount'))
{
    function discount($payment){
        $penalty = ($payment * (10 /100)*(-1));
        return $penalty;
    }
}

if ( ! function_exists('saveMoney'))
{
     function saveMoney($money){
        return str_replace(",","",$money);
    }
}

if ( ! function_exists('showMoney')){
     function showMoney($money){
        return number_format($money,2);
    }
}



if ( ! function_exists('encrypt')) {

    function encrypt($string) {
        $output = FALSE;

        $encrypt_method = "AES-256-CBC";
        $secret_key = '$6$/!@#$%$3cr3tk3y%$#@!';
        $secret_iv = '$6$/!@#$%$3cr3tIV%$#@!';

        // hash
        $key = hash('sha256', $secret_key);
        
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);

        return $output;
    }
}

if ( ! function_exists('decrypt')) {

    function decrypt($string) {
        $output = FALSE;

        $encrypt_method = "AES-256-CBC";
        $secret_key = '$6$/!@#$%$3cr3tk3y%$#@!';
        $secret_iv = '$6$/!@#$%$3cr3tIV%$#@!';
        // hash
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }
}

if ( ! function_exists('clean_data')) {
	function clean_data($value) {
	   $value = trim($value);
    $value = str_replace('\\','',$value);
    $value = strtr($value,array_flip(get_html_translation_table(HTML_ENTITIES)));
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    return $value;
	}
}


if ( ! function_exists('test')) {
    function test() {
        return "fuck";
    }
}


if ( ! function_exists('hash_password')) {
	function hash_password($password) {
		$options = array(
		    'cost' => 11,
		);
		return password_hash($password, PASSWORD_BCRYPT, $options);
	}

}

if ( ! function_exists('check_privilege')) {
	function check_privilege($page_privilege,$privilege) {
		$privilege_array = explode(',',$privilege);
		$exists = in_array($page_privilege,$privilege_array);
		return $exists;
	}

}

if ( ! function_exists('logged_in')) {
    function logged_in(CI_Controller $controller) {
        if(isset($controller->session->id))
            return true;
        else
            return false;
    }

}

if ( ! function_exists('post')) {
    function post($name) {
        $controller = & get_instance();
        return $controller->input->post($name);
    }
}





?>