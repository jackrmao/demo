<?php
include "./rsa.php";
include "./HttpClient.php";
//֤��·��	
$path="E:/wamp/www/test/page/888022079110003_private_key_pkcs8.pem";
//���ݼ���
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
//��Կǩ��
$encryptData=redSignkey($xml);
$tranCode="WGZF002";
$url=$_POST["serverUrl"];

//post ������װ
$post_data = array ("xmlData" => $xmlData ,"tranCode" => $tranCode,"reqOrdId" => $_POST["reqOrdId"],"signData" => $encryptData,"merchantId" =>$_POST["merchantId"]);		
$reqdata=request_post($url,$post_data);	
function request_post($url , $post_data) {//urlΪ�ش�  ����õ�ַ����Ҫ�����Ͳ���  
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
     $ch = curl_init();//��ʼ��curl  
     curl_setopt($ch, CURLOPT_URL,$url);
     curl_setopt($ch, CURLOPT_HEADER, 0);//����header  
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//Ҫ����Ϊ�ַ������������Ļ��  
     curl_setopt($ch, CURLOPT_POST, 1);//post�ύ��ʽ  
     if(!empty($post_data))curl_setopt($ch, CURLOPT_POSTFIELDS, $params);  
     $data = curl_exec($ch);//����curl  
     curl_close($ch);  
     return $data;  
} 

echo $reqdata;
printf($reqdata);
$obj=json_decode($reqdata); 
?>