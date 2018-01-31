<?php
//引入phpqrcode
include "./phpqrcode.php";
//签名

function addString($one,$other){
	return $one."".other;
}

//验签
function decrypt($content,$path) {
 //读取商户私钥
 $priKey = file_get_contents($path);
  
 //转换为openssl密钥，必须是没有经过pkcs8转换的私钥
 $res = openssl_get_privatekey($priKey);
  
 //声明明文字符串变量
 $result = '';
  
 //循环按照128位解密
 for($i = 0; $i < strlen($content)/128; $i++ ) {
  $data = substr($content, $i * 128, 128);
    
 //拆分开长度为128的字符串片段通过私钥进行解密，返回$decrypt解析后的明文
  openssl_private_decrypt($data, $decrypt, $res);
  
 //明文片段拼接
  $result .= $decrypt;
 }
 //释放资源
 openssl_free_key($res);
  
 //返回明文
 return $result;
}

//字符集
function fixEncoding($in_str)

{

$cur_encoding = mb_detect_encoding($in_str) ;

if($cur_encoding == "UTF-8" && mb_check_encoding($in_str,"UTF-8"))

return $in_str;

else

return utf8_encode($in_str);

} 
/**function picture_show($value){
	$value="http://www.jb51.net"; 
	$errorCorrectionLevel = "L"; 
	$matrixPointSize = "4"; 
	QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize); 
	exit; 
}*/
function sign($originalData){
	/** 
	* 密钥文件的路径 
	*/  
	$privateKeyFilePath = 'E:/wamp/www/test/page/888022079110003_private_key_pkcs8.pem';   
	  
	extension_loaded('openssl') or die('php需要openssl扩展支持');  
	  
	(file_exists($privateKeyFilePath))  
	or die('密钥或者公钥的文件路径不正确');  
	/** 
	* 生成Resource类型的密钥，如果密钥文件内容被破坏，openssl_pkey_get_private函数返回false 
	*/  
	$privateKey = openssl_pkey_get_private(file_get_contents($privateKeyFilePath));  

	($privateKey) or die('密钥或者公钥不可用');  
	/** 
	* 原数据 
	*/  
	//$originalData = '我的帐号是:shiki,密码是:matata';  
	/** 
	* 加密以后的数据，用于在网路上传输 
	*/  
	$encryptData = '';  
	  
	//echo '原数据为:', $originalData, PHP_EOL;  
	  
	///////////////////////////////用私钥加密////////////////////////  
	if (openssl_private_encrypt($originalData, $encryptData, $privateKey)) {  
		/** 
		 * 加密后 可以base64_encode后方便在网址中传输 或者打印  否则打印为乱码 
		 */  
		//echo '加密成功，加密后数据(base64_encode后)为:', base64_encode($encryptData), PHP_EOL;  
	    return $encryptData;
	} else {  
		die('加密失败');  
	}  
	  
 	
} 
function HttpPost($url,$post_data){

	$ch = curl_init(); //初始化curl

	curl_setopt($ch, CURLOPT_URL, $url);//设置链接

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置是否返回信息

	curl_setopt($ch, CURLOPT_POST, 1);//设置为POST方式

	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);//POST数据

	$response = curl_exec($ch);//接收返回信息

	echo $response;
	if(curl_errno($ch)){//出错则显示错误信息

	echo curl_error($ch);
	}
}
/**function vpost($url,$data){ // 模拟提交数据函数
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
       echo 'Errno'.curl_error($curl);//捕抓异常
    }
	echo $tempInfo;
    curl_close($curl); // 关闭CURL会话
    return $tmpInfo; // 返回数据
	}*/

?>