<%@ page language="java" contentType="text/html; charset=GBK" pageEncoding="GBK"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>现代金控-支付宝扫码</title>
    </head>
    <body>
        <form action="">
        <img alt="二维码" src="${pageContext.request.contextPath}/images/qrCodePath/${qrcode}"/>
        </form>
    </body>
</html>