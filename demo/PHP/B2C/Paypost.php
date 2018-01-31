<?php
header("content-type:text/html;charset=UTF-8");
include "./DataUtil.php";
include"./HttpClient.php";
echo $_GET["cardType"];
#加密
$version="1.0.0";
$signData = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
$signData.="<merchant><head>";
$signData=addString($signData,$_GET["version"],"version");
$signData=addString($signData,$_GET["reqDate"],"reqDate");
$signData.="</head><body>";
$signData=addString($signData,$_GET["totalAmount"],"totalAmount");
$signData=addString($signData,$_GET["cardType"],"cardType");
$signData=addString($signData,$_GET["productName"],"productName");
$signData=addString($signData,$_GET["productId"],"productId");
$signData=addString($signData,$_GET["productDesc"],"productDesc");
$signData=addString($signData,$_GET["showUrl"],"showUrl");
$signData=addString($signData,$_GET["bankAbbr"],"bankAbbr");
$signData=addString($signData,$_GET["pageReturnUrl"],"pageReturnUrl");
$signData=addString($signData,$_GET["offlineNotifyUrl"],"offlineNotifyUrl");
$signData=addString($signData,$_GET["tranCode"],"tranCode");
$signData=addString($signData,$_GET["purchaserId"],"purchaserId");
$signData=addString($signData,$_GET["merchantId"],"merchantId");
$signData=addString($signData,$_GET["validUnit"],"validUnit");
$signData=addString($signData,$_GET["currency"],"currency");
$signData=addString($signData,$_GET["validNum"],"validNum");
$signData=addString($signData,$_GET["backParam"],"backParam");
$signData=$signData."</body></merchant>";

$encryptData=base64_encode($signData);

//秘钥签名
$signData=redSignkey($signData);
$tranCode=$_GET["tranCode"];

$url=$_GET["postUrl"];


$reqOrdId=$_GET["reqOrdId"];
$merchantId=$_GET["merchantId"];
//post 数据组装
$post_data = array ("xmlData" => $encryptData ,"tranCode" => $tranCode,"reqOrdId" => $_GET["reqOrdId"],"signData" => $signData,"merchantId" =>$_GET["merchantId"]);		
request_post($url , $post_data);
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
	 echo $data;  
     return $data;  
}   


?>
