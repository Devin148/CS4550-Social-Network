<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
session_start();
// If the session vars are set
if (isset($_SESSION["logged_in"]) && isset($_SESSION["email"])) {
    // And if logged_in is set to 0
    if ($_SESSION["logged_in"] == 0) {
        // Redirect them to the login page
        header("Location: index.php");
        exit();
    }
// If the vars aren't set, to the login page they go
} else {
    header("Location: index.php");
    exit();
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Northeastern Social</title>
    <link href="css/index.css" rel="stylesheet" type="text/css" />
    <script src="js/form.js" type="text/javascript"></script>
    <script src="js/jquery-1.9.0.min.js" type="text/javascript"></script>
</head>

<body>

    <?php

    include ("functions.php");
    $email = $_SESSION["email"];
    $user = getUser($email);

    $first_name = $user->getFirstName();
    $last_name = $user->getLastName();

    print "<h1> Welcome $first_name $last_name!</h1>";

    ?>

    <form action="javascript:alert('Sucess!')" name="status_form" id="status_form">
        <table>
            <tr>
                <td>Status:</td>
                <td>
                    <textarea cols="40" rows="5" name="status" id="status">Write something...</textarea>
                </td>
            </tr>
            <tr>
                <td><input type="submit" id="submit" value="Submit" /></td>
            </tr>
        </table>
    </form>

    <script>
    // When the document is ready
    $(document).ready(function () {
        // Validate status form
        $("#status_form").submit(function () {
            if (!isEmpty($("#status").val())) {
                var result = false;
                // Add the status through an ajax request to the php file
                $.ajax({
                    type:  "POST",
                    url:   "add_status.php",
                    data:  "status=" + $("#status").val(),
                    async: false
                }).done (function (ret) {
                    if (ret == "true") {
                        result = true;
                    }
                });
            }
            return result;
        });
    });
    </script>

</body>
</html>
