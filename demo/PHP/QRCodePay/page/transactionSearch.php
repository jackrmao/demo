

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>扫码支付预下单</title>
        <script type="text/javascript" src="../scripts/json2.js"></script>
        <script type="text/javascript" src="../scripts/common.js"></script>
        <script type="text/javascript" src="../scripts/jquery-1.7.2.min.js"></script>
    </head>
    <body>
        <div>
            <form action="./search.php" id="form_query" method="post">
                <span>版本号:</span>
                <input type="text" name="version" id="version" value="1.0.0"/><br/>
                <span>交易类型:</span>
                <input type="text" name="msgType" id="msgType" value="01"/>(01支付宝，02 微信)<br/>
                <span>商户编号:</span>
                <input type="text" name="merchantId" value="888022079110003" id="merchantId"/><br/>
                <span>商户订单号:</span>
                <input type="text" name="orderId" id="orderId" size="50"/><br/>
                <span>请求地址:</span>
                 <input type="text" name="serverUrl" id="serverUrl" value="http://118.114.253.212:7002/mfhcd_merchant/scan/query.do" size="70"/><br/>
                <span>终端IP:</span>
                <input type="text" name="terminalIp" id="terminalIp" size="30" value="127.0.0.1"/><br/>
                <input type="submit" value="查询" id="button_pay"/>
            </form>
        </div>
    </body>
    <script>
        $(function () {
            var current = CurentTime();
            var merc_id = $("#merchantId").val();
            $("#orderId").val(current);
            $("#orderTime").val(current);
        });
    </script>
</html>