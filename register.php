<?php
session_start();
// If the session vars are set
if (isset($_SESSION["logged_in"]) && isset($_SESSION["email"])) {
    // And if logged_in is set to 1
    if ($_SESSION["logged_in"] == 1) {
        // Redirect the user to their newsfeed
        header("Location: newsfeed.php");
        exit();
    }
}
// Otherwise load the page as normal
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Northeastern Social</title>
    <link href="css/welcome.css" rel="stylesheet" type="text/css" />
    <script src="js/form.js" type="text/javascript"></script>
    <script src="js/jquery-1.9.0.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui-1.9.2.custom.min.js" type="text/javascript"></script>
</head>

<body>
    <div id="floater"></div>
    <div id="content_wrapper">
        <div id="content">
            <div class="sub_content small left red">
                <h2>Connect</h2>
                <p>With friends from Northeastern</p>

                <h2>Establish</h2>
                <p>A strong network with your colleagues</p>

                <h2>Learn</h2>
                <p>About exciting co-ops opportunities</p>

                <h2>Share</h2>
                <p>Your experiences and passions</p>
            </div>

            <div id="sign_up" class="sub_content large right">
                <?php include ("registration_form.php"); ?>
            </div>

            <div class="clear"></div>
        </div>
    </div>

    <div id="footer">
    </div>

    <script>
    // When the document is ready
    $(document).ready(function () {
        // Add years to the registration form
        addYears("year");

        // Validate registration form
        $("#registration_form").submit(function () {
            if (!isFormFilled("registration_form")) {
                return false;
            }
            if (!isEmail($("#registration_form #email").val())) {
                alert ("Please enter a valid email!");
                return false;
            }
            if (!isZip($("#registration_form #zip").val())) {
                alert ("Please enter a valid zip code!");
                return false;
            }
            var day = $("#registration_form #day").val();
            var month = $("#registration_form #month").val();
            var year = $("#registration_form #year").val();
            if (!isOldEnough(day, month, year)) {
                alert ("You must be at least 18 to sign up!");
                return false;
            }
            return true;
        });
    });
    </script>

</body>
</html>