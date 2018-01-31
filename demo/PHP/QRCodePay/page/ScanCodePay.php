
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>扫码支付预下单</title>
        <script type="text/javascript" src="../scripts/json2.js"></script>
        <script type="text/javascript" src="../scripts/common.js"></script>
        <script type="text/javascript" src="../scripts/jquery-1.7.2.min.js"></script>
    </head>
    <body>
        <div>
            <form action="ScanCodePaySubmit.php" id="form_query" method="post">
                <span>版本号:</span>
                <input type="text" name="version" id="version" value="1.0.0"/><br/>
                <span>商户编号:</span>
                <input type="text" name="merchantId" value="888022079110003" id="merchantId"/><br/>
                <span>商户订单号:</span>
                <input type="text" name="orderId" id="orderId"  size="50"/><br/>
                <span>订单时间:</span>
                <input type="text" name="orderTime" id="orderTime"/><br/>
                <span>订单总金额（单位：分  整数）:</span>
                <input type="text" name="totalAmount" id="totalAmount" value="1"/><br/>
                <span>商品名称:</span>
                <input type="text" name="productName" id="productName" value="payproductName"/><br/>
                <span>商品描述:</span>
                <input type="text" name="productDesc" id="productDesc" value="pay_productDesc"/><br/>
                <span>服务器地址:</span>       
                <input type="text" name="serverUrl" id="serverUrl" value="http://192.168.210:7002/mfhcd_merchant/scan/create.do" size="70"/><br/> 
                <span>支付回调地址:</span>
                <input type="text" name="callBack" id="callBack" value="http://118.114.253.212:8083/test/page/callBack.php" size="50"/><br/>
                <span>支付方式:</span>
                <select name="payWay" id="payWay">
                    <option value="01">支付宝</option>
                    <option value="02">微信</option>
                </select><br/>
                <span>终端IP:</span>
                <input type="text" name="terminalIp" id="terminalIp" size="30" value="127.0.0.1"/><br/>
                <span>附加信息:</span>
                <input type="text" name="attach" id="attach" size="50" value="xianDaiJinKong"/><br/>
                <input type="submit" value="生成预付订单" id="button_pay"/>
            </form>
        </div>
    </body>
    <script>
        //提示到服务器
        $(function () {
            var current = CurentTime();
            var merc_id = $("#merchantId").val();
            $("#orderId").val(current);
            $("#orderTime").val(current);
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