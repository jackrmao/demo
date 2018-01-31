<?php

include "./phpqrcode.php";
include "./rsa.php";
include "./HttpClient.php";

//证书路径	
$path="E:/wamp/www/test/page/888022079110003_private_key_pkcs8.pem";
//数据加密
$showtime=date("YmdHis");
$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
$xml.="<merchant><head><version>";
$xml.="<![CDATA[".$_POST["version"]."]]>";//版本号
$xml.="</version><msgType>";
$xml.="<![CDATA[".$_POST["msgType"]."]]>";//支付方式1 支付宝 2 微信
$xml.="</msgType><reqDate>";
$xml.="<![CDATA[".$showtime."]]>";//退款时间
$xml.="</reqDate></head><body><refundAmount>";
$xml.="<![CDATA[".$_POST["totalAmount"]."]]>";//退款金额
$xml.="</refundAmount><refundReason>";
$xml.="<![CDATA[]]>";
$xml.="</refundReason><oriReqMsgId>";
$xml.="<![CDATA[".$_POST["orderId"]."]]>";//订单ID
$xml.="</oriReqMsgId></body></merchant>";

$reqOrdId=$_POST["orderId"];
$xmlData=base64_encode($xml);

//秘钥签名
$encryptData=redSignkey($xml);
$tranCode="SMZF004";
$url=$_POST["serverUrl"];

//post 数据组装
$post_data = array ("xmlData" => $xmlData ,"tranCode" => $tranCode,"reqOrdId" => $_POST["orderId"],"signData" => $encryptData,"merchantId" =>$_POST["merchantId"]);		
 
$signData=$encryptData;
$reqOrdId=$_POST["orderId"];
$merchantId=$_POST["merchantId"];

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
$reqdata=request_post($url,$post_data);	
echo $reqdata;
printf($reqdata);
$obj=json_decode($reqdata); 
//print_r(base64_decode("PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48bWVzc2FnZT48aGVhZD48dmVyc2lvbj4xLjA8L3ZlcnNpb24+PG1zZ1R5cGU+MDE8L21zZ1R5cGU+PHJlcU9yZElkPjIwMTcxMjI4MTgxNzIwPC9yZXFPcmRJZD48cmVxRGF0ZT4yMDE3MTIyODE4MTcyMTwvcmVxRGF0ZT48cmVzcERhdGU+MjAxNzEyMjgxODE3MTc8L3Jlc3BEYXRlPjxyZXNwVHlwZT5FPC9yZXNwVHlwZT48cmVzcENvZGU+OTAwMjwvcmVzcENvZGU+PHJlc3BNc2c+5Y6f6K6i5Y2V5pSv5LuY57G75Z6L5LiO6YCA5qy+57G75Z6L5LiN5Yy56YWNPC9yZXNwTXNnPjwvaGVhZD48L21lc3NhZ2U+"));
//$encryptData=$obj->encryptData;
/**$sign=$obj->sign;
$encryptData=base64_decode($encryptData);

//返回码公钥验签
if(Verify($encryptData,$sign)==1){
	echo $encryptData;
	//get_pictrue($https);		
	};*/
?>