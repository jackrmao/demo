<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>B2C订单查询</title>
        <script type="text/javascript" src="./scripts/jquery-1.7.2.min.js"></script>
    </head>
    <body>
        <div>
            <form action="./Search.php" id="form_query" method="post">
                <span>版本号:</span>
                <input type="text" name="version" id="version" value="1.0.0"/>
				<font color="red">* 目前版本1.0.0</font><br/>		
				<span>请求时间:</span>
                <input type="text" name="reqDate" id="reqDate" /><br/>
				<span>商户编码</span>
				<input type="text" name="merchantId" id="merchantId"/><br/>
                <span>订单创建时间:</span>
                <input type="text" name="orderTime" id="orderTime" /><br/>
                <span>订单号:</span>
                <input type="text" name="reqOrdId"  id="reqOrdId"/><br/>
                <span>平台流水号:</span>
                <input type="text" name="tradeNo"  id="tradeNo"/><br/>
                <span>支付金额:</span>
                <input type="text" name="totalAmount" id="totalAmount"  size="70"/>
				<font color="red">* 以分为单位</font><br/>		
                <span>银行编码:</span>
                <input type="text" name="bankAbbr" id="bankAbbr" size="30" /><br/>
				<span>支付用户号:</span>
                <input type="text" name="purchaserId" id="purchaserId" size="30" /><br/>
				<span>支付时间:</span>
                <input type="text" name="payTime" id="payTime" size="30" /><br/>
				<span>费用:</span>
                <input type="text" name="fee" id="fee" size="30" /><br/>
				<span>会计日期:</span>
                <input type="text" name="acDate" id="acDate" size="30" /><br/>
				<span>支付结果:</span>
                <input type="text" name="status" id="status" size="30" /><br/>
				<span>保留参数信息:</span>
                <input type="text" name="backParam" id="backParam" size="30" /><br/>
				<span>返回地址:</span>
                <input type="text" name="returnUrl" id="returnUrl" size="30" /><br/>
				<span>异步回调地址:</span>
                <input type="text" name="offlineUrl" id="offlineUrl" size="30"/><br/>
                <input type="submit" value="查询" id="button_pay"/>
            </form>
        </div>
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