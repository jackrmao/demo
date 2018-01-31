
<?php
include "./phpqrcode.php";
include "./rsa.php";
include "./HttpClient.php";
header("content-type:text/html;charset=UTF-8");
//证书路径	
$path="E:/wamp/www/test/page/888022079110003_private_key_pkcs8.pem";

//数据加密
$showtime=date('YmdHis');

$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
$xml.="<merchant><head><version>";
$xml.="<![CDATA[".$_POST["version"]."]]>";
$xml.="</version><msgType>";
$xml.="<![CDATA[".$_POST["msgType"]."]]>";
$xml.="</msgType><reqDate>";
$xml.="<![CDATA[".$showtime."]]>";
$xml.="</reqDate></head><body><oriReqMsgId>";
$xml.="<![CDATA[".$_POST["orderId"]."]]>";
$xml.="</oriReqMsgId></body></merchant>";
$url=$_POST["serverUrl"];
$xmlData=base64_encode($xml);
//秘钥签名
$encryptData=redSignkey($xml);
$tranCode="SMZF006";
//post数据
$post_data = array ("xmlData" => $xmlData ,"tranCode" => $tranCode,"reqOrdId" => $_POST["orderId"],"signData" => $encryptData,"merchantId" =>$_POST["merchantId"]);	

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

$obj=json_decode($reqdata); 

$encryptData=$obj->encryptData;
$sign=$obj->sign;
$encryptData=base64_decode($encryptData);
if(Verify($encryptData,$sign)==1){
	//echo "验签通过";
	//echo $encryptData;
	};
$pos = strpos($encryptData, 'xml');
    if (!$pos) {
        die("不是xml字符串！");
    }
    $obj=simplexml_load_string($encryptData,'SimpleXMLElement', LIBXML_NOCDATA);
    if(is_object($obj)){
        $obj=get_object_vars($obj);
    } 
	$one =$obj['head'][0];
?>
<html>
<head>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
        <title>扫码支付预下单</title>
    </head>
    <body>
        <div>
            <form>
                <span>版本号:</span>
                <input type="text" name="version" id="version" value=<?=$one->version?> /><br/>
                <span>支付方式:</span>
                <input type="text" name="merchantId" value=<?=$one->msgType?> id="merchantId"/><br/>
                <span>订单号:</span>
                <input type="text" name="orderId" value=<?=$one->reqOrdId?>  id="orderId" size="50"/><br/>
                <span>订单时间:</span>
                <input type="text" name="orderTime" value=<?=$one->reqDate?>  id="orderTime"/><br/>
                <span>回执时间:</span>
                <input type="text" name="serverUrl" id="serverUrl" value=<?=$one->respDate?>  size="50"/><br/>
                <span>回执类型:</span>
				<input type="text" name="respType" id="respType" value=<?=$one->respType?> size="50"/><br/>
				<span>回执编码:</span>
                <input type="text" name="respCode" id="respCode" value=<?=$one->respCode?> size="50"/><br/>
                <span>回执信息</span>
                <input type="text" name="respMsg" id="respMsg" value=<?=$one->respMsg?> size="50"/><br/>
            </form>
        </div>
    </body>
</html>
