<?php
function login($nomor){
	$host = "bimaplus.tri.co.id";        
    $data = '{"imei":"Android 93488a982824b403","language":1,"msisdn":"'.$nomor.'"}';
    
    $ceknom = request($host,"POST",'/api/v1/login/otp-request', $data);
    return $ceknom;
}
function otplogin($nomor,$otp){
	$host = "bimaplus.tri.co.id";        
    $data = '{"deviceManufactur":"Samsung","deviceModel":"SMG991B","deviceOs":"Android","imei":"Android 93488a982824b403","msisdn":"'.$nomor.'","otp":"'.$otp.'"}';

    $ceknom = request($host,"POST",'/api/v1/login/login-with-otp', $data);
    return $ceknom;
}

function profile($nomor, $plan, $secret){
    $host = "bimaplus.tri.co.id";        
    $data = '{"callPlan":"'.$plan.'","deviceManufactur":"Samsung","deviceModel":"SMG991B","deviceOs":"Android","imei":"Android 93488a982824b403","language":0,"msisdn":"'.$nomor.'","page":1,"secretKey":"'.$secret.'","subscriberType":"Prepaid"}';

    $ceknom = request($host,"POST",'/api/v1/homescreen/profile', $data);
    return $ceknom;
}

function check($prodid){
	$host = "my.tri.co.id";        
    $data = '{"imei":"WebSelfcare","language":"","callPlan":"","msisdn":"","secretKey":"","subscriberType":"","productId":"'.$prodid.'"}';

    $ceknom = request($host,"POST",'/apibima/product/product-detail', $data);
    return $ceknom;
}


function buy($nomor, $plan, $secret, $prodid){
    $host = "bimaplus.tri.co.id";        
    $data = '{"addonMenuCategory":"","addonMenuSubCategory":"","balance":"","callPlan":"'.$plan.'","deviceManufactur":"Samsung","deviceModel":"SMG991B","deviceOs":"Android","imei":"Android 93488a982824b403","language":0,"menuCategory":"3","menuCategoryName":"TriProduct","menuIdSource":"","menuSubCategory":"","menuSubCategoryName":"","msisdn":"'.$nomor.'","paymentMethod":"00","productAddOnId":"","productId":"'.$prodid.'","secretKey":"'.$secret.'","servicePlan":"Default","sms":true,"subscriberType":"Prepaid","totalProductPrice":"","utm":"","utmCampaign":"","utmContent":"","utmMedium":"","utmSource":"","utmTerm":"","vendorId":"11"}';

    $ceknom = request($host,"POST",'/api/v1/purchase/purchase-product', $data);
    return $ceknom;
}

function request($host, $method, $url, $data = null){ 

    $headers[] = 'Host: '.$host;
	$headers[] = 'App-Version: 4.2.6';
    $headers[] = 'Content-Type: application/json; charset=UTF-8';
    $headers[] = 'User-Agent: okhttp/4.9.0';
    
    $c = curl_init("https://".$host.$url);  
    switch ($method){
        case "GET":
        curl_setopt($c, CURLOPT_POST, false);
        break;
        case "POST":               
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $data);
        break;
        case "PUT":               
        curl_setopt($c, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($c, CURLOPT_POSTFIELDS, $data);
        break;
    }
    
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_HEADER, true);
    curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($c, CURLOPT_TIMEOUT, 20);
    $response = curl_exec($c);
    $httpcode = curl_getinfo($c);
    if (!$httpcode){
        return false;
    }
    else {
        $headers = substr($response, 0, curl_getinfo($c, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($c, CURLINFO_HEADER_SIZE));
    }
    
    curl_close($c);
    $json = json_decode($body, true);
    return $json;
}

function color($color = "default" , $text = "") {
    $arrayColor = array(
        'grey'      => '1;30',
        'red'       => '1;31',
        'green'     => '1;32',
        'yellow'    => '1;33',
        'blue'      => '1;34',
        'purple'    => '1;35',
        'nevy'      => '1;36',
        'white'     => '1;0',
    );  
    return "\033[".$arrayColor[$color]."m".$text."\033[0m";
}

function save_config($json) {
    $f = @fopen('config.json', "a+");
    @fwrite($f, $json);
    @fclose($f);
}

function load_config() {
    $g = @file_get_contents("config.json");

    return json_decode($g, 1);
}