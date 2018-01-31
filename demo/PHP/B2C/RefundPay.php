<?php
$datetime=date('YmdHis');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>退款</title>
    </head>
    <body>
        <div>
            <form action="./refund.php" id="form_query" method="post">
                <span>版本号:</span><input type="text" name="version" id="version" value="1.0.0"/><br/>
                <span>请求时间:</span><input type="text" name="reqDate" value="<?=$datetime?>" id="reqDate"/><br/>
                <span>交易类型:</span><input type="text" name="tranCode" id="tranCode" value="WGZF002" size="50"/><br/>
				<span>订单号码:</span><input type="text" name="reqOrdId" id="reqOrdId" size="50"/><br/>
				<span>商户ID:</span><input type="text" name="merchantId" id="merchantId" value="888010080430021" size="50"/><br/>
                <span>请求地址</span>
                <input type="text" name="serverUrl" id="serverUrl" value="http://localhost:8085/mfhcd_merchant/gateway/pay.do" size="50"/><br/>
                <span>退款金额（单位：分）:</span><input type="text" name="refundAmount" id="refundAmount" value="1"/><br/>
                <input type="submit" value="提交订单" id="button_pay" method="post" />
            </form>
        </div>
    </body>
</html>