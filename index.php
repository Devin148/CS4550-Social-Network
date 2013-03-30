<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Northeastern Social</title>
    <link href="css/index.css" rel="stylesheet" type="text/css" />
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

            <div class="sub_content large right">
                <h1>Welcome to the</h1>
                <h1 class="strong">Northeastern</h1>
                <h1>Social Network</h1>

                <a href="login_form.php" class="button red grey">Login</a>
                <a href="register.php" class="button red red">Sign Up</a>
            </div>
            <div class="clear"></div>

        </div>
    </div>

    <div id="footer">
    </div>

</body>
</html>