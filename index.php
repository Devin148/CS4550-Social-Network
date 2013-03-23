<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Northeastern Social</title>
    <script src="js/form.js" type="text/javascript"></script>
</head>

<body>
    <form action="login.php" method="post" name="login" onsubmit="return false">

        <table>
            <tr>
                <td>Email:</td>
                <td><input name="email" type="text" size="15" maxlength="100" /></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input name="password" type="password" size="15" maxlength="100" /></td>
            </tr>
            <tr>
                <td><a href="javascript:doSubmit()">Submit</a></td>
            </tr>

        </table>
    </form>

    <script>
    function doSubmit() {
        document.login.submit();
    }
    </script>

</body>
</html>