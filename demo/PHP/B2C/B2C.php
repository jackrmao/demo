
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>订单信息填写-收银台</title>
</head>
<body>
	<font color='red'>收银台页面下单</font>
	 <script type="text/javascript" src="./jquery-1.7.2.min.js"></script>
	<form action="./creat.php" target="post">
	<table class="api">
				<tr>
                  <td >版本号：</td>
                  <td>
                     <input type="text" name="version" value="1.0.0">
                     <font color="red">版本号默认为1.0.0</font>
                  </td>
             	</tr>
               
                <tr>
                  <td >请求时间</td>
                  <td>
				   <input type="text" name="reqDate" id="reqDate" >             
                  </td>
               </tr> 
               
               <tr>
                  <td >金额：</td>
                  <td>
				    <input type="text" name="totalAmount" maxlength='20' value="22">
                     <font color="red">*订单金额，以分为单位</font>
                  </td>
               </tr>
                <tr>
                  <td >卡类型</td>
                  <td> 
				  <!-- <select name="charsets">
                        <option value="00">GBK</option>
                        <option value="01">GB2312</option>
                        <option value="02">UTF-8</option>
                     </select>-->
                    <input type="text" name="cardType" >
                     <font color="red"></font>
                  </td>
               </tr>
               <tr>
                  <td >产品名称</td>
                  <td>
                     <input type="text" name="productName" >
                     <font color="red">*</font>
                  </td>
               </tr>
			    <tr>
                  <td >产品ID</td>
                  <td>
                     <input type="text" name="productId" >
                     <font color="red">*</font>
                  </td>
               </tr> <tr>
                  <td >产品描述</td>
                  <td>
                     <input type="text" name="productDesc" >
                     <font color="red">*</font>
                  </td>
               </tr> <tr>
                  <td >展示地址</td>
                  <td>
                     <input type="text" name="showUrl" >
                     <font color="red">*</font>
                  </td>
               </tr>
			    </tr> <tr>
                  <td >银行编码
				  </td>
                  <td>
                     <input type="text" name="bankAbbr" >
                     <font color="red">*</font>
                  </td>
               </tr>  <tr>
                  <td >同步回调地址</td>
                  <td>
                     <input type="text" name="pageReturnUrl" >
                     <font color="red">*</font>
                  </td>
               </tr>  <tr>
                  <td >后台回调地址</td>
                  <td>
                     <input type="text" name="offlineNotifyUrl" >
                     <font color="red">*</font>
                  </td>
               </tr>
			   <tr>
                  <td >请求地址</td>
                  <td>
                     <input type="text" name="postUrl" >
                     <font color="red">*</font>
                  </td>
               </tr>
			   <tr>
                  <td >交易码</td>
                  <td>
                     <input type="text" name="tranCode" >
                     <font color="red">*</font>
                  </td>
               </tr>  <tr>
                  <td >买者标识</td>
                  <td>
                     <input type="text" name="purchaserId" >
                     <font color="red">*</font>
                  </td>
               </tr>  <tr>
                  <td >订单号</td>
                  <td>
                     <input type="text" name="reqOrdId" id="reqOrdId">
                     <font color="red">*</font>
                  </td>
               </tr> 
			   <tr>
                  <td >商户号</td>
                  <td>
                     <input type="text" name="merchantId" >
                     <font color="red">*</font>
                  </td>
                </tr>
				   <tr>
                  <td >订单有效单位 </td>
                  <td>
                     <input type="text" name="validUnit" >
                     <font color="red">* 只能取以下枚举值 00-分  01-小时 02-日 03-月</font>
                  </td>
                </tr>
				   <tr>
                  <td >订单有效数量</td>
                  <td>
                     <input type="text" name="validNum" >
                     <font color="red">*</font>
                  </td>
                </tr>
				   <tr>
                  <td >原样返回的商户数据</td>
                  <td>
                     <input type="text" name="backParam" >
                     <font color="red">*</font>
                  </td>
                </tr>
				      <tr>
                  <td >币种</td>
                  <td>
                      <input type="text" name="currency" >
                  </td>
				  </tr>
				<tr>
	                  <td><input type="submit" value="下单"></td>
                  </tr>
		</table>
	</form>
</body>
 <script>
        //提示到服务器
        $(function () {
            var current = CurentTime();
            $("#reqOrdId").val(current);
            $("#reqDate").val(current);
        });
		function CurentTime(){ 
        var now = new Date();
        var year = now.getFullYear();       //年
        var month = now.getMonth() + 1;     //月
        var day = now.getDate();            //日
       
        var hh = now.getHours();            //时
        var mm = now.getMinutes();          //分
        var ss = now.getSeconds();     //获取当前秒数(0-59)
        var clock = year+"";
       
        if(month < 10)
            clock += "0";
       
        clock += month;
       
        if(day < 10)
            clock += "0";
           
        clock += day;
       
        if(hh < 10)
            clock += "0";
           
        clock += hh;
        if (mm < 10) clock += "0"; 
        clock += mm; 
         if (ss < 10) clock += "0"; 
        clock += ss; 
        return(clock); 
    } 
    </script>
</html>