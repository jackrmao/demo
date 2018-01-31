<?php
 function  addString($signData,$data,$name){
	 
	return $signData."<".$name."><![CDATA[".$data."]]></".$name.">";
}
function _getPublicKey($file)  
    {  
        $key_content = $this->_readFile($file);  
        if ($key_content) {  
            $this->pubKey = openssl_get_publickey($key_content);  
        }  
    }  
 function _getPrivateKey($file)  
    {  
        $key_content = $this->_readFile($file);  
        if ($key_content) {  
            $this->priKey = openssl_get_privatekey($key_content);  
        }  
    }
	function redSignkey($data){	
	$key = openssl_pkey_get_private(file_get_contents('E:/wamp/www/test/network/888022079110003_private_key_pkcs8.pem'));
	openssl_sign($data, $sign, $key, OPENSSL_ALGO_SHA1);
	$sign = base64_encode($sign);
	return $sign;
}   
?>