<?php
function redSignkey($data){	
	$key = openssl_pkey_get_private(file_get_contents('E:/wamp/www/test/network/888022079110003_private_key_pkcs8.pem'));
	openssl_sign($data, $sign, $key, OPENSSL_ALGO_SHA1);
	$sign = base64_encode($sign);
	return $sign;
}   
 function Verify($data, $sign){
	$sign = base64_decode($sign);
	$key = openssl_pkey_get_public(file_get_contents("D:/idea/project/smzf_xdjk_demo/WebContent/network/xdjk_kf_rsa_public_key_2048.pem"));
	$result = openssl_verify($data, $sign, $key, OPENSSL_ALGO_SHA1) ;
	return $result;
} 
function get_pictrue($value ){  

	$errorCorrectionLevel = "H"; // 纠错级别：L、M、Q、H  
	$matrixPointSize = "3"; // 点的大小：1到10  
	QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize);  
} 

function png111($text, $outfile, $level, $size, $margin, $saveandprint)    
{   
    $enc = QRencode::factory($level, $size, $margin);   
    return $enc->encodePNG($text, $outfile, $saveandprint=false);   
}

function signKey($data,$path){	
	$key = openssl_pkey_get_private(file_get_contents($path));
	openssl_sign($data, $sign, $key, OPENSSL_ALGO_SHA1);
	$sign = base64_encode($sign);
	return $sign;
}  



























?>
