<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------


function numtowords($x)
{
    $oneto19 = array("","ONE","TWO","THREE","FOUR","FIVE","SIX","SEVEN","EIGHT","NINE","TEN","ELEVEN","TWELVE","THIRTEEN","FOURTEEN","FIFTEEN","SIXTEEN","SEVENTEEN","EIGHTEEN","NINETEEN");
    $tens = array("","","TWENTY","THIRTY","FOURTY","FIFTY","SIXTY","SEVENTY","EIGHTY","NINETY");
    $hundreds = array("","ONE HUNDRED","TWO HUNDRED","THREE HUNDRED", "FOUR HUNDRED", "FIVE HUNDRED", "SIX HUNDRED", "SEVEN HUNDRED" ,"EIGHT HUNDRED" ,"NINE HUNDRED");
    $scale = array("","","THOUSAND", "MILLION");

    $num = number_format($x,2,".",","); 
    $num_arr = explode(".",$num); 

    $numwords = "";
   
        $wholenum = $num_arr[0]; 
        $decnum = $num_arr[1]; 
        $whole_arr = explode(",",$wholenum); 

        $whole_count = count($whole_arr);
        $scaleCounter = $whole_count;
        for($i=0;$i<$whole_count;$i++)
        {
            $digitcount = strlen($whole_arr[$i]); 

            switch($digitcount)
            {
                case "3": 
                    $digit3 = substr($whole_arr[$i],0,1);
                    $whole_arr[$i] = $whole_arr[$i] - ($digit3 * 100);
                    $numwords .= "".$hundreds[$digit3]." ";
                case "2":
                    $digit2 = substr($whole_arr[$i],0,1);
                    if($digit2 < 2)
                    {
                        $digit1 = substr($whole_arr[$i],1,1);
                        $digit21 = $digit2."".$digit1;
                        $numwords .= $oneto19[$digit21]." ";
                    break;  
                    }
                    else
                    {
                        $digit2 = substr($whole_arr[$i],0,1);
                        $whole_arr[$i] = $whole_arr[$i] - ($digit2 * 10);
                        $numwords .= $tens[$digit2]." ";
                    }
                case "1": 
                    $digit1 = substr($whole_arr[$i],0,1);
                    $whole_arr[$i] = $whole_arr[$i] - ($digit1 * 1);
                    $numwords .= $oneto19[$digit1]." ";
                 
                break;
            }
            $numwords .= $scale[$scaleCounter]." ";
            $scaleCounter--;
        }
        if($decnum > 0){
            $numwords .= " PESOS and ";
                if($decnum < 20 ){
                   
                    if($decnum<10)
                    {
                       $decnum = str_replace(0,"",$decnum);
                        $numwords .= $oneto19[$decnum];
                    }
                    else{
                        $numwords .= $oneto19[$decnum];
                    }
                }elseif($decnum < 100){
                    $numwords .= $tens[substr($decnum,0,1)];
                    $numwords .= " ".$oneto19[substr($decnum,1,1)];
                   
                }
                $numwords .= ' '.'CENTS';
            }

    else{
        $numwords .= 'PESOS';
    }
            

  
        return $numwords;
       
      
    
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