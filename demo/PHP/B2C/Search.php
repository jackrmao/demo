<?php

include "./DataUtil.php";
include"./HttpClient.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="hidden/html; charset=utf-8">
        <title>B2C订单查询</title>
        <script type="hidden/javascript" src="../scripts/json2.js"></script>
        <script type="hidden/javascript" src="../scripts/common.js"></script>
        <script type="hidden/javascript" src="../scripts/jquery-1.7.2.min.js"></script>
    </head>
    <body>
        <div>
            <form action="./SearchPost.php" id="form_query" method="post">
			<table class="api">
				<tr>
                <td>版本号:</td>
				<td>
				<label><?=$_POST["version"]?></label>
                <input type="hidden" name="version" id="version" value="<?=$_POST["version"]?>" >
				</td>
				</tr>
				<tr>
				<td>商户ID</td>
				<td>
				<label><?=$_POST["merchantId"]?></label>
                <input type="hidden" name="merchantId" id="merchantId" value="<?=$_POST["merchantId"]?>" >
				</td>
				</tr>
				<tr>
                <td>订单创建时间:</td>
                <td>
				<label><?=$_POST["orderTime"]?></label>
				<input type="hidden" name="orderTime" id="orderTime" value="<?=$_POST["orderTime"]?>"/>
                </td>
				</tr>
				<tr>
				<td>订单号:</td>
                <td>
				<label><?=$_POST["reqOrdId"]?></label>
				<input type="hidden" name="reqOrdId" value="<?=$_POST["reqOrdId"]?>" id="reqOrdId"/><br/>
                </td>
				</tr>
				<tr>
				<td>平台流水号:</td>
                <td>
				<label><?=$_POST["tradeNo"]?></label>
				<input type="hidden" name="tradeNo" value="<?=$_POST["tradeNo"]?>" id="tradeNo"/><br/>
				</td>
				</tr>
				<tr>
				<td>请求时间:</td>
                <td>
				<label><?=$_POST["reqDate"]?></label>
				<input type="reqDate" name="reqDate" value="<?=$_POST["reqDate"]?>" id="tradeNo"/><br/>
				</td>
				</tr>
				<tr>
				<td>支付金额（以分为单位）:</td>
				<td>
                <label><?=$_POST["totalAmount"]?></label>
				<input type="hidden" name="totalAmount" id="totalAmount" value="<?=$_POST["totalAmount"]?>" size="70"/><br/>
                </td>
				</tr>
				<tr>
				<td>银行编码:</td>
                <td>
				<label><?=$_POST["bankAbbr"]?></label>
				<input type="hidden" name="bankAbbr" id="bankAbbr" size="30" value="<?=$_POST["bankAbbr"]?>"/><br/>
				</td>
				</tr>
				<tr>
				<td>支付用户号:</td>
				<td>
                <label><?=$_POST["purchaserId"]?></label>
				<input type="hidden" name="purchaserId" id="purchaserId" size="30" value="<?=$_POST["purchaserId"]?>"/><br/>
				</td>
				</tr>
				<tr>
				<td>支付时间:</td>
				<td>
				<label><?=$_POST["payTime"]?></label>
                <input type="hidden" name="payTime" id="payTime" size="30" value="<?=$_POST["payTime"]?>"/><br/>
				</td>
				</tr>
				<tr>
				<td>费用:</td>
                <td>
				     <label><?=$_POST["fee"]?></label>
				<input type="hidden" name="fee" id="fee" size="30" value="<?=$_POST["fee"]?>"/><br/>
				</td>
				</tr>
				
				<tr>
				<td>会计日期:</td>
                <td>
				     <label><?=$_POST["acDate"]?></label>
				<input type="hidden" name="acDate" id="acDate" size="30" value="<?=$_POST["acDate"]?>"/><br/>
				</td>
				</tr>
				<tr>
				<td>支付结果:</td>
                <td>
				     <label><?=$_POST["status"]?></label>
				<input type="hidden" name="status" id="status" size="30" value="<?=$_POST["status"]?>"/><br/>
				</td>
				</tr>
				<tr>
				<td>保留参数信息:</td>
					<td>
					 <label><?=$_POST["backParam"]?></label>
                <input type="hidden" name="backParam" id="backParam" size="30" value="<?=$_POST["backParam"]?>"/><br/>
				</td>
				</tr>
				<tr>
				<td>返回地址:</td>
				<td>
                   <label><?=$_POST["returnUrl"]?></label>
				<input type="hidden" name="returnUrl" id="returnUrl" size="30" value="<?=$_POST["returnUrl"]?>"/><br/>
				</td>
				</tr>
				<tr>
				<td>异步回调地址:</td>
				<td>
				   <label><?=$_POST["offlineUrl"]?></label>
                <input type="hidden" name="offlineUrl" id="offlineUrl"  size="30" value="<?=$_POST["offlineUrl"]?>"/><br/>
                </td>
				</tr>
				<tr>
				<td>
				<input type="submit" value="查询" id="button_pay"/>
				</td>
				</tr>
				</table>
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