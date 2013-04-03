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
    <link href="css/navbar.css" rel="stylesheet" type="text/css" />
    <script src="js/form.js" type="text/javascript"></script>
    <script src="js/jquery-1.9.0.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui-1.9.2.custom.min.js" type="text/javascript"></script>
</head>

<body>

    <div id="navbar">
        <ul>
            <li><a href="navbar.php">Home</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="clear"></div>

    <div id="content_wrapper">
        <div id="sidebar">
            <img src="images/default_profile.png" />
            <ul>
                <li><a <?php echo "href=\"profile.php?email=$email\""; ?>>Profile</a></li>
                <li><a href="messages.png">Messages</a></li>
                <li><a href="friends.png">Friends</a></li>
                <li><a href="coops.png">Co-ops</a></li>
        </div>

        <div id="content">

            <?php

            include ("functions.php");
            $email = $_SESSION["email"];
            $user = getUser($email);

            $first_name = $user->getFirstName();
            $last_name = $user->getLastName();

            print "<h1> Welcome $first_name $last_name!</h1><br /><br />";

            ?>

            <form action="javascript:alert('Sucess!')" name="status_form" id="status_form">
                <table>
                    <tr><td>Status:</td></tr>
                    <tr>
                        <td>
                            <textarea cols="40" rows="5" name="status" id="status">Write something...</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="submit" id="submit" value="Submit" /></td>
                    </tr>
                </table>
            </form>

            <br /><br /> <!-- Ugh br's -->

            <?php

            // Connect to the db
            include ("connect.php");

            // Find the user and fill in the vars
            if ($stmt = $mysqli->prepare("SELECT content, author, time FROM status
                                          WHERE author IN (SELECT friend FROM friends_with WHERE user=?)
                                                OR author=?
                                          ORDER BY time desc")) {
                $stmt->bind_param('ss', $user->getId(), $user->getId());
                $stmt->execute();
                $stmt->bind_result($content, $author_id, $time);
                
                $i = 0;
                while ($stmt->fetch() && $i<=25) {
                    $i++;

                    // Create a User for the author
                    $author = getUserFromId($author_id);
                    $author_name = $author->getFirstName() . " " .
                                   $author->getLastName();
                    $author_email = $author->getEmail();
                    ?>

                    <p><?php echo $content; ?></p>
                    <p><?php echo "<a href=\"profile.php?email=$author_email\">$author_name</a>"; ?> at <?php echo $time; ?></p>
                    <hr />

                    <?php
                }

                // Close the statement
                $stmt->close();
            } else {
                // Throw exception
                print "Sorry, not gonna work.";
            }

            // Close the connection
            $mysqli->close();

            ?>

        </div>
        <div class="clear"></div>
    </div>

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
