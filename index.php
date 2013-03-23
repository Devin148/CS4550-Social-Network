<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Northeastern Social</title>
    <script src="js/form.js" type="text/javascript"></script>
    <script src="js/jquery-1.9.0.min.js" type="text/javascript"></script>
</head>

<body>
    <form action="login.php" method="post" name="login" id="login">
        <table>
            <tr>
                <td>Email:</td>
                <td><input name="email" id="email" type="text" size="15" maxlength="100" /></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input name="password" id="password" type="password" size="15" maxlength="100" /></td>
            </tr>
            <tr>
                <td><input type="submit" id="submit" value="Submit" /></td>
            </tr>

        </table>
    </form>

    <script>
    $("#login").submit(function () {
        return !isFormEmpty("login") && isEmail($("input#email").val());
    });

    </script>

</body>
</html>