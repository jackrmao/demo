<?php
//����phpqrcode
include "./phpqrcode.php";
//ǩ��

function addString($one,$other){
	return $one."".other;
}

//��ǩ
function decrypt($content,$path) {
 //��ȡ�̻�˽Կ
 $priKey = file_get_contents($path);
  
 //ת��Ϊopenssl��Կ��������û�о���pkcs8ת����˽Կ
 $res = openssl_get_privatekey($priKey);
  
 //���������ַ�������
 $result = '';
  
 //ѭ������128λ����
 for($i = 0; $i < strlen($content)/128; $i++ ) {
  $data = substr($content, $i * 128, 128);
    
 //��ֿ�����Ϊ128���ַ���Ƭ��ͨ��˽Կ���н��ܣ�����$decrypt�����������
  openssl_private_decrypt($data, $decrypt, $res);
  
 //����Ƭ��ƴ��
  $result .= $decrypt;
 }
 //�ͷ���Դ
 openssl_free_key($res);
  
 //��������
 return $result;
}

//�ַ���
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
	* ��Կ�ļ���·�� 
	*/  
	$privateKeyFilePath = 'E:/wamp/www/test/page/888022079110003_private_key_pkcs8.pem';   
	  
	extension_loaded('openssl') or die('php��Ҫopenssl��չ֧��');  
	  
	(file_exists($privateKeyFilePath))  
	or die('��Կ���߹�Կ���ļ�·������ȷ');  
	/** 
	* ����Resource���͵���Կ�������Կ�ļ����ݱ��ƻ���openssl_pkey_get_private��������false 
	*/  
	$privateKey = openssl_pkey_get_private(file_get_contents($privateKeyFilePath));  

	($privateKey) or die('��Կ���߹�Կ������');  
	/** 
	* ԭ���� 
	*/  
	//$originalData = '�ҵ��ʺ���:shiki,������:matata';  
	/** 
	* �����Ժ�����ݣ���������·�ϴ��� 
	*/  
	$encryptData = '';  
	  
	//echo 'ԭ����Ϊ:', $originalData, PHP_EOL;  
	  
	///////////////////////////////��˽Կ����////////////////////////  
	if (openssl_private_encrypt($originalData, $encryptData, $privateKey)) {  
		/** 
		 * ���ܺ� ����base64_encode�󷽱�����ַ�д��� ���ߴ�ӡ  �����ӡΪ���� 
		 */  
		//echo '���ܳɹ������ܺ�����(base64_encode��)Ϊ:', base64_encode($encryptData), PHP_EOL;  
	    return $encryptData;
	} else {  
		die('����ʧ��');  
	}  
	  
 	
} 
function HttpPost($url,$post_data){

	$ch = curl_init(); //��ʼ��curl

	curl_setopt($ch, CURLOPT_URL, $url);//��������

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//�����Ƿ񷵻���Ϣ

	curl_setopt($ch, CURLOPT_POST, 1);//����ΪPOST��ʽ

	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);//POST����

	$response = curl_exec($ch);//���շ�����Ϣ

	echo $response;
	if(curl_errno($ch)){//��������ʾ������Ϣ

	echo curl_error($ch);
	}
}
/**function vpost($url,$data){ // ģ���ύ���ݺ���
    $curl = curl_init(); // ����һ��CURL�Ự
    curl_setopt($curl, CURLOPT_URL, $url); // Ҫ���ʵĵ�ַ
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // �Զ�����Referer
    curl_setopt($curl, CURLOPT_POST, 1); // ����һ�������Post����
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data); // Post�ύ�����ݰ�
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // ���ó�ʱ���Ʒ�ֹ��ѭ��
    curl_setopt($curl, CURLOPT_HEADER, 0); // ��ʾ���ص�Header��������
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // ��ȡ����Ϣ���ļ�������ʽ����
    $tmpInfo = curl_exec($curl); // ִ�в���
    if (curl_errno($curl)) {
       echo 'Errno'.curl_error($curl);//��ץ�쳣
    }
	echo $tempInfo;
    curl_close($curl); // �ر�CURL�Ự
    return $tmpInfo; // ��������
	}*/

?>