<?php
include "./rsa.php";
include "./HttpClient.php";
//证书路径	
$path="E:/wamp/www/test/page/888022079110003_private_key_pkcs8.pem";
//数据加密
$showtime=date("YmdHis");
$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
$xml.="<merchant><head><version>";
$xml.="<![CDATA[".$_POST["version"]."]]></version><reqDate>";
$xml.="<![CDATA[".$_POST["reqDate"]."]]></reqDate></head><body><tranCode>";
$xml.="<![CDATA[".$_POST["tranCode"]."]]></tranCode><merchantId>";
$xml.="<![CDATA[".$_POST["merchantId"]."]]></merchantId><refundAmount>";
$xml.="<![CDATA[".$_POST["refundAmount"]."]]></refundAmount><reqOrdId>";
$xml.="<![CDATA[".$_POST["reqOrdId"]."]]></reqOrdId></body></merchant>";

$xmlData=base64_encode($xml);
//秘钥签名
$encryptData=redSignkey($xml);
$tranCode="WGZF002";
$url=$_POST["serverUrl"];

//post 数据组装
$post_data = array ("xmlData" => $xmlData ,"tranCode" => $tranCode,"reqOrdId" => $_POST["reqOrdId"],"signData" => $encryptData,"merchantId" =>$_POST["merchantId"]);		
$reqdata=request_post($url,$post_data);	
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

echo $reqdata;
printf($reqdata);
$obj=json_decode($reqdata); 
?>