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

$email = $_SESSION["email"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Northeastern Social</title>
    <link href="css/index.css" rel="stylesheet" type="text/css" />
    <script src="js/form.js" type="text/javascript"></script>
    <script src="js/jquery-1.9.0.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui-1.9.2.custom.min.js" type="text/javascript"></script>
</head>

<body>

    <?php

        include ("functions.php");
        $email = $_SESSION["email"];
        $user = getUser($email);

    ?>

    <div id="container">
        <?php include ("navbar.php"); ?>
        <?php include ("sidebar.php"); ?>

        <div id="large_content">
            <form action="add_coop_script.php" method="post" name="add_coop_form" id="add_coop_form">
                <table>
                    <tr>
                        <td>Company Name:</td>
                        <td><input name="name" id="name" type="text" size="25" maxlength="200" /></td>
                    </tr>
                    <tr>
                        <td>Your Rating:</td>
                        <td><input name="rating" id="rating" type="text" size="2" maxlength="2" />/10</td>
                    </tr>
                    <tr><td>Description:</td></tr>
                    <tr><td colspan="2"><textarea name="description" id="description" rows="10" cols="50" form="add_coop_form"></textarea></td></tr>
                    <tr>
                        <td><input type="submit" id="submit" value="Submit" /></td>
                    </tr>

                </table>
            </form>
        </div>
        <div class="clear"></div>
    </div>

    <script>
    // When the document is ready
    $(document).ready(function () {
        // Validate login form
        $("#add_coop_form").submit(function () {
            if (!isFormFilled("add_coop_form")) {
                return false;
            }
            if ($("#rating").val() >= 0 && $("#rating").val() <= 10) {
                return true;
            } else {
                alert ("Rating must be between 0 and 10.");
                return false;
            }
            return true;
        });
    });
    </script>
</body>
</html>