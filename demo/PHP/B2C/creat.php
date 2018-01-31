<?php
header("content-type:text/html;charset=UTF-8");
include "./DataUtil.php";
include"./HttpClient.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>订单信息填写-收银台</title>
</head>
<body>
	<font color='red'>收银台页面下单</font>
	<form action="./post.php" target="post">
	<table class="api">
				<tr>
                  <td >版本号：</td>
                  <td>   
				  <label><?=$_GET["version"]?></label>
                     <input type="hidden" name="version" value="<?=$_GET["version"]?>">
                     <font color="red">不能为空，确保正确的商户号</font>
                  </td>
				</tr>
               
                <tr>
                  <td >请求时间</td>
				     <td>
				     <label><?=$_GET["reqDate"]?></label>
				   <input type="hidden" name="reqDate" value="<?=$_GET["reqDate"]?>">             
                  </td>
               </tr> 
               
               <tr>
                  <td >金额：</td>
				  <td>
                     <label><?=$_GET["totalAmount"]?></label>
				    <input type="hidden" name="totalAmount" maxlength='20' value="<?=$_GET["totalAmount"]?>">
                     <font color="red">*订单金额，以分为单位</font>
                  </td>
               </tr>
                <tr>
                  <td >卡类型</td>
				  <td> 
                     <label><?=$_GET["cardType"]?></label>
				  <!-- <select name="charsets">
                        <option value="00">GBK</option>
                        <option value="01">GB2312</option>
                        <option value="02">UTF-8</option>
                     </select>-->
                    <input type="hidden" name="cardType"  value="<?=$_GET["cardType"]?>">
                     <font color="red"></font>
                  </td>
               </tr>
               <tr>
                  <td >产品名称</td>
				  <td>
                     <label><?=$_GET["productName"]?></label>
                     <input type="hidden" name="productName" value="<?=$_GET["productName"]?>">
                     <font color="red">*</font>
                  </td>
               </tr>
			    <tr>
                  <td >产品ID</td>
				  <td>
                     <label><?=$_GET["productId"]?></label>
                     <input type="hidden" name="productId" value="<?=$_GET["productId"]?>" >
                     <font color="red">*</font>
                  </td>
               </tr> <tr>
                  <td >产品描述</td>
				  <td>
                     <label><?=$_GET["productDesc"]?></label>
                     <input type="hidden" name="productDesc" value="<?=$_GET["productDesc"]?>" >
                     <font color="red">*</font>
                  </td>
               </tr> <tr>
                  <td >展示地址</td>
				  <td>
                     <label><?=$_GET["showUrl"]?></label>
                     <input type="hidden" name="showUrl" value="<?=$_GET["showUrl"]?>" >
                     <font color="red">*</font>
                  </td>
               </tr>
			    </tr> <tr>
                  <td >银行编码
				  </td>
				  <td>
                     <label><?=$_GET["bankAbbr"]?></label>
                     <input type="hidden" name="bankAbbr" value="<?=$_GET["bankAbbr"]?>">
                     <font color="red">*</font>
                  </td>
               </tr>  <tr>
                  <td >同步回调地址</td>
				  <td>
                     <label><?=$_GET["pageReturnUrl"]?></label>
                     <input type="hidden" name="pageReturnUrl" value="<?=$_GET["pageReturnUrl"]?>">
                     <font color="red">*</font>
                  </td>
               </tr> 
			    <tr>
                  <td >请求地址</td>
				  <td>
                     <label><?=$_GET["postUrl"]?></label>
                     <input type="hidden" name="postUrl" value="<?=$_GET["postUrl"]?>" >
                     <font color="red">*</font>
                  </td>
               </tr>
			   <tr>
                  <td >后台回调地址</td>
				  <td>
                     <label><?=$_GET["offlineNotifyUrl"]?></label>
                     <input type="hidden" name="offlineNotifyUrl" value="<?=$_GET["offlineNotifyUrl"]?>" >
                     <font color="red">*</font>
                  </td>
               </tr>
			   <tr>
                  <td >交易码</td>
				  <td>
                     <label><?=$_GET["tranCode"]?></label>
                     <input type="hidden" name="tranCode" value="<?=$_GET["tranCode"]?>">
                     <font color="red">*</font>
                  </td>
               </tr>  <tr>
                  <td >买者标识</td>
				 <td>
					   <label><?=$_GET["purchaserId"]?></label>
                     <input type="hidden" name="purchaserId" value="<?=$_GET["purchaserId"]?>" >
                     <font color="red">*</font>
                  </td>
               </tr>  <tr>
                  <td >订单号</td>
				  <td>
                     <label><?=$_GET["reqOrdId"]?></label>
                     <input type="hidden" name="reqOrdId" value="<?=$_GET["reqOrdId"]?>" >
                     <font color="red">*</font>
                  </td>
               </tr> 
			   <tr>
                  <td >商户号</td>
				  <td>
                     <label><?=$_GET["merchantId"]?></label>
                     <input type="hidden" name="merchantId" value="<?=$_GET["merchantId"]?>">
                     <font color="red">*</font>
                  </td>
                </tr>
				   <tr>
                  <td >订单有效单位 只能取以下枚举值 00-分  01-小时 02-日 03-月</td>
				 <td>
					   <label><?=$_GET["validUnit"]?></label>
                     <input type="hidden" name="validUnit" value="<?=$_GET["validUnit"]?>">
                     <font color="red">*</font>
                  </td>
                </tr>
				   <tr>
                  <td >订单有效数量</td>
				  <td>
                     <label><?=$_GET["validNum"]?></label>
                     <input type="hidden" name="validNum" value="<?=$_GET["validNum"]?>">
                     <font color="red">*</font>
                  </td>
                </tr>
				   <tr>
                  <td >原样返回的商户数据</td>
				  <td>
                     <label><?=$_GET["backParam"]?></label>
                     <input type="hidden" name="backParam" value="<?=$_GET["backParam"]?>" >
                     <font color="red">*</font>
                  </td>
                </tr>
				      <tr>
                  <td >币种</td>
                  <td>
				   <label><?=$_GET["currency"]?></label>
                      <input type="hidden" name="currency" value="<?=$_GET["currency"]?>" >
                  </td>
				  </tr>
				<tr>
	                  <td><input type="submit" value="下单"></td>
                  </tr>
		</table>
	</form>
	

</body>
</html>