<?php
include "./phpqrcode.php";
include "./rsa.php";
include "./HttpClient.php";
echo $_POST["totalAmount"];
//证书路径	
$path="E:/wamp/www/test/network/888022079110003_private_key_pkcs8.pem";
//数据加密
$showtime=date("YmdHis");
$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
$xml.="<merchant><head><version>";
$xml.="<![CDATA[".$_POST["version"]."]]>";
$xml.="</version><msgType>";
$xml.="<![CDATA[".$_POST["payWay"]."]]>";
$xml.="</msgType><reqDate>";
$xml.="<![CDATA[".$showtime."]]>";
$xml.="</reqDate></head><body><totalAmount>";
$xml.="<![CDATA[".$_POST["totalAmount"]."]]>";
$xml.="</totalAmount><subject>";
$xml.="<![CDATA[".$_POST["productName"]."]]>";
$xml.="</subject><desc>";
$xml.="<![CDATA[".$_POST["productDesc"]."]]>";
$xml.="</desc><notifyUrl>";
$xml.="<![CDATA[".$_POST["callBack"]."]]>";
$xml.="</notifyUrl></body></merchant>";
$reqOrdId=$_POST["orderId"];
$encryptData=base64_encode($xml);

//秘钥签名
$signData=redSignkey($xml);
$tranCode="SMZF002";
$url=$_POST["serverUrl"];
$reqOrdId=$_POST["orderId"];
$merchantId=$_POST["merchantId"];

//post 数据组装
$post_data = array ("xmlData" => $encryptData ,"tranCode" => $tranCode,"reqOrdId" => $_POST["orderId"],"signData" => $signData,"merchantId" =>$_POST["merchantId"]);		
 

function request_post($url , $post_data) {//url为必传  如果该地址不需要参数就不传  
     if (empty($url)) {  
         return false;  
     }      
    if(!empty($post_data)){  
     $params = '';  
      foreach ( $post_data as $k => $v )   
      {   
          $params.= "$k=" . urlencode($v). "&" ;  
         // $params.= "$k=" . $v. "&" ;  
      }  
      $params = substr($params,0,-1);  
    }   
     $ch = curl_init();//初始化curl  
     curl_setopt($ch, CURLOPT_URL,$url);
     curl_setopt($ch, CURLOPT_HEADER, 0);//设置header  
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上  
     curl_setopt($ch, CURLOPT_POST, 1);//post提交方式  
     if(!empty($post_data))curl_setopt($ch, CURLOPT_POSTFIELDS, $params);  
     $data = curl_exec($ch);//运行curl  
     curl_close($ch);  
     return $data;  
}  
#$reqdata=request_post($url,$post_data);
#$obj=json_decode($reqdata); 
##$encryptData=$obj->encryptData;
#$sign=$obj->sign;
#$encryptData=base64_decode($encryptData);


//返回码公钥验签
	if(Verify($encryptData,$sign)==1){
	
		if($_POST["payWay"]=="1"){
			$https=strstr( $encryptData, 'https:');
		}else{
			$https=strstr($encryptData, 'weixin:' );
		}
			$pos = strpos($encryptData, 'xml');
		if (!$pos) {
        die("不是xml字符串！");
		}
		$obj=simplexml_load_string($encryptData,'SimpleXMLElement', LIBXML_NOCDATA);
		if(is_object($obj)){
        $obj=get_object_vars($obj);
		} 
		$data =$obj['body'][0];
		$http=$data->qrCode;
		get_pictrue($http);
	};
	
?>





