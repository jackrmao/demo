<%@ page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>退款</title>
        <script type="text/javascript" src="../scripts/json2.js"></script>
        <script type="text/javascript" src="../scripts/common.js"></script>
        <script type="text/javascript" src="../scripts/jquery-1.7.2.min.js"></script>
    </head>
    <body>
        <div>
            <form action="${pageContext.request.contextPath}/ScanCodePay/refund.html" id="form_query" method="post">
                <span>版本号:</span><input type="text" name="version" id="version" value="1.0.0"/><br/>
                <span>交易类型:</span><input type="text" name="msgType" value="01" id="msgType"/>(支付宝01 微信02)<br/>
                <span>商户编号:</span><input type="text" name="merchantId" value="888022079110003" id="merchantId"/><br/>
                <span>商户原始订单号:</span><input type="text" name="orderId" id="orderId" size="50"/><br/>
                <span>请求的url:</span>
                <input type="text" name="serverUrl" id="serverUrl" value="http://114.255.252.192:8899/mfhcd_merchant/scan/refund.do" size="50"/><br/>
                <span>退款金额（单位：分）:</span><input type="text" name="totalAmount" id="totalAmount" value="1"/><br/>
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
        })
    </script>
</html>