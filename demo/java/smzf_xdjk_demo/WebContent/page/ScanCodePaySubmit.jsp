<%@ page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>扫码支付订单确认</title>
    </head>
    <body>
        <font color="red" size="7">扫码支付订单确认</font><br/>
        <form action="${pageContext.request.contextPath}/ScanCodePay/submit.html">
            <table class="api" width="2100">
                <tr>
                    <td width="200">版本：</td>
                    <td>
                        <label>${date.version}</label>
                        <input type="hidden" name="version" value="${date.version}"/>
                    </td>
                </tr>
                <tr>
                    <td width="200">商户编号：</td>
                    <td>
                        <label>${date.merchantId}</label>
                        <input type="hidden" name="merchantId" value="${date.merchantId}"/>
                    </td>
                </tr>
                <tr>
                    <td width="200">商户订单号：</td>
                    <td>
                        <label>${date.orderId}</label>
                        <input type="hidden" name="orderId" value="${date.orderId}"/>
                    </td>
                </tr>
                <tr>
                    <td width="200">订单时间：</td>
                    <td>
                        <label>${date.orderTime}</label>
                        <input type="hidden" name="orderTime" value="${date.orderTime}"/>
                    </td>
                </tr>
                <tr>
                    <td width="200">订单总金额：(元)</td>
                    <td>
                        <label>${date.totalAmount}</label>
                        <input type="hidden" name="totalAmount" value="${date.totalAmount}"/>
                    </td>
                </tr>
                <tr>
                    <td width="200">商品名称：</td>
                    <td>
                        <label>${date.productName}</label>
                        <input type="hidden" name="productName" value="${date.productName}"/>
                    </td>
                </tr>
                <tr>
                    <td width="200">商品描述：</td>
                    <td>
                        <label>${date.productDesc}</label>
                        <input type="hidden" name="productDesc" value="${date.productDesc}"/>
                    </td>
                </tr>
                <tr>
                    <td width="200">服务器地址：</td>
                    <td>
                        <label>${date.serverUrl}</label>
                        <input type="hidden" name="serverUrl" value="${date.serverUrl}"/>
                    </td>
                </tr>
                <tr>
                    <td width="200">商户回调地址：</td>
                    <td>
                        <label>${date.callBack}</label>
                        <input type="hidden" name="callBack" value="${date.callBack}"/>
                    </td>
                </tr>
                <tr>
                    <td width="200">支付方式：</td>
                    <td>
                        <label>${date.payWay}</label>
                        <input type="hidden" name="payWay" value="${date.payWay}"/>
                    </td>
                </tr>
                <tr>
                    <td width="200">终端ip：</td>
                    <td>
                        <label>${date.terminalIp}</label>
                        <input type="hidden" name="terminalIp" value="${date.terminalIp}"/>
                    </td>
                </tr>
                <tr>
                    <td width="200">附加信息：</td>
                    <td>
                        <label>${date.attach}</label>
                        <input type="hidden" name="attach" value="${date.attach}"/>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" value="下单"></td>
                </tr>
            </table>
        </form>
    </body>
</html>