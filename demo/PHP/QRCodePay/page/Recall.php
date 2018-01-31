
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
            <form action="callBack.php" id="form_query" method="post">
                <span>待验签:</span>
                <input type="text" name="encryptData" id="encryptData" value="PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48bWVyY2hhbnQ+PGhlYWQ+PG1zZ1R5cGU+PCFbQ0RBVEFbWkZCWkZdXT48L21zZ1R5cGU+PHJlcURhdGU+PCFbQ0RBVEFbMjAxODAxMDIxNTI5MDJdXT48L3JlcURhdGU+PHJlc3BDb2RlPjwhW0NEQVRBWzAwMDAwMF1dPjwvcmVzcENvZGU+PHJlc3BNc2c+PCFbQ0RBVEFb5oiQ5YqfXV0+PC9yZXNwTXNnPjxyZXNwVHlwZT48IVtDREFUQVtTXV0+PC9yZXNwVHlwZT48dmVyc2lvbj48IVtDREFUQVsxLjAuMF1dPjwvdmVyc2lvbj48L2hlYWQ+PGJvZHk+PGJ1eWVySWQ+PCFbQ0RBVEFbMjA4ODAyMjI2NzA4OTI2NF1dPjwvYnV5ZXJJZD48cmVxT3JkSWQ+PCFbQ0RBVEFbMjAxODAxMDIxNTI4MjRdXT48L3JlcU9yZElkPjx0b3RhbEFtb3VudD48IVtDREFUQVsxXV0+PC90b3RhbEFtb3VudD48L2JvZHk+PC9tZXJjaGFudD4="/><br/>
                <span>签名:</span>
                <input type="text" name="sign" id="sign" value="PaRvIAeOBnE40K9KXwMxy2bBYIv8pUcKLlRhOr+nzSyp9vhQhXG48wwoXg+RYx6MR3HkGHVYzDWEjtybq4kCql/mhoq/a57pbHsdY0WZeqFbKrDS8nG0qS4E8ESZEClfbSHo0xKokpkN6rydLM4fJr0IgYcOphQRMjaSOpCq19v3H02VqgVxbIyk21ETS1k76OVc+/wrxicwrDAJd6sgizzbqt6w8ssuNWcDBWAovecCy4MfodHSlM2msqSNsR6QUIGFoN5UjLRR7aJDrDMjiVVsjVc2bA9C/05E067nB8kcHVPQaFwpmAxsKdRR/b3yTA9U+E+1n+VlfB39H9a+Ng=="/><br/>
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
    </script>
</html>