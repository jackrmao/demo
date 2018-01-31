<?php
include "./phpqrcode.php";
include "./rsa.php";
include "./HttpClient.php";
//交易码
//$tranCode=$_POST["tranCode"];
//订单ID
//$orderId=$_POST["reqOrdId"];
//$encrypt=$_POST["encryptData"];
$sign=$_POST["signData"];
$xmldata=$_POST["xmlData"];
$encryptData=base64_decode($xmldata);


if(Verify($encryptData,$sign)==1){
	//验签通过
	$pos = strpos($encryptData, 'xml');
    if (!$pos) {
        die("不是xml字符串！");
    }
    $obj=simplexml_load_string($encryptData,'SimpleXMLElement', LIBXML_NOCDATA);
    if(is_object($obj)){
        $obj=get_object_vars($obj);
    } 
	//返回信息展示
	$xml =$obj['head'][0];
	$msgType=$xml->msgType;
	$reqDate=$xml->reqDate;
	$respCode=$xml->respCode;
	$respMsg=$xml->respMsg;
	$respType=$xml->respType;
	$version=$xml->version;
	
	$xml =$obj['body'][0];
	$buyerI=$xml->buyerId;
	$totalAmount=$xml->totalAmount;
	$reqOrdId=$xml->reqOrdId;
	//$myfile = fopen($reqDate.".txt", "w");
	$myfile = fopen("=订单号".$reqOrdId.".txt", "w") or die("Unable to open file!");

	fwrite($myfile, "msgType: ".$msgType."\n");
	fwrite($myfile, "reqDate: ".$reqDate."\n");
	fwrite($myfile, "respCode: ".$respCode."\n");
	fwrite($myfile, "respMsg: ".$respMsg."\n");
	fwrite($myfile, "respType: ".$respType."\n");
	fwrite($myfile, "version: ".$version."\n");
	fwrite($myfile, "totalAmount:  ".$totalAmount."\n");
	fwrite($myfile, "msgType: ".$msgType."\n");
	fwrite($myfile, "reqOrdId: ".$reqOrdId."\n");
	
	fclose($myfile);

	
	
	
	
}else{
	echo "验签未通过";
}
?>