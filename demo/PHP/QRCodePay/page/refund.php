<?php

include "./phpqrcode.php";
include "./rsa.php";
include "./HttpClient.php";

//֤��·��	
$path="E:/wamp/www/test/page/888022079110003_private_key_pkcs8.pem";
//���ݼ���
$showtime=date("YmdHis");
$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
$xml.="<merchant><head><version>";
$xml.="<![CDATA[".$_POST["version"]."]]>";//�汾��
$xml.="</version><msgType>";
$xml.="<![CDATA[".$_POST["msgType"]."]]>";//֧����ʽ1 ֧���� 2 ΢��
$xml.="</msgType><reqDate>";
$xml.="<![CDATA[".$showtime."]]>";//�˿�ʱ��
$xml.="</reqDate></head><body><refundAmount>";
$xml.="<![CDATA[".$_POST["totalAmount"]."]]>";//�˿���
$xml.="</refundAmount><refundReason>";
$xml.="<![CDATA[]]>";
$xml.="</refundReason><oriReqMsgId>";
$xml.="<![CDATA[".$_POST["orderId"]."]]>";//����ID
$xml.="</oriReqMsgId></body></merchant>";

$reqOrdId=$_POST["orderId"];
$xmlData=base64_encode($xml);

//��Կǩ��
$encryptData=redSignkey($xml);
$tranCode="SMZF004";
$url=$_POST["serverUrl"];

//post ������װ
$post_data = array ("xmlData" => $xmlData ,"tranCode" => $tranCode,"reqOrdId" => $_POST["orderId"],"signData" => $encryptData,"merchantId" =>$_POST["merchantId"]);		
 
$signData=$encryptData;
$reqOrdId=$_POST["orderId"];
$merchantId=$_POST["merchantId"];

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
$reqdata=request_post($url,$post_data);	
echo $reqdata;
printf($reqdata);
$obj=json_decode($reqdata); 
//print_r(base64_decode("PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48bWVzc2FnZT48aGVhZD48dmVyc2lvbj4xLjA8L3ZlcnNpb24+PG1zZ1R5cGU+MDE8L21zZ1R5cGU+PHJlcU9yZElkPjIwMTcxMjI4MTgxNzIwPC9yZXFPcmRJZD48cmVxRGF0ZT4yMDE3MTIyODE4MTcyMTwvcmVxRGF0ZT48cmVzcERhdGU+MjAxNzEyMjgxODE3MTc8L3Jlc3BEYXRlPjxyZXNwVHlwZT5FPC9yZXNwVHlwZT48cmVzcENvZGU+OTAwMjwvcmVzcENvZGU+PHJlc3BNc2c+5Y6f6K6i5Y2V5pSv5LuY57G75Z6L5LiO6YCA5qy+57G75Z6L5LiN5Yy56YWNPC9yZXNwTXNnPjwvaGVhZD48L21lc3NhZ2U+"));
//$encryptData=$obj->encryptData;
/**$sign=$obj->sign;
$encryptData=base64_decode($encryptData);

//�����빫Կ��ǩ
if(Verify($encryptData,$sign)==1){
	echo $encryptData;
	//get_pictrue($https);		
	};*/
?>