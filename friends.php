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

// Include functions
include ("functions.php");
// Get email
$email = $_SESSION["email"];
// Get the user
$user = getUser($email);
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
    <div id="container">
        <!-- Add the nav and side bars -->
        <?php include ("navbar.php"); ?>
        <?php include ("sidebar.php"); ?>

        <div id="large_content">

            <!-- Start adding friends -->
            <?php

            // Connect to the db
            include ("connect.php");

            // Select all the statuses of people the user is friends with
            if ($stmt = $mysqli->prepare("SELECT id, email, first_name, last_name FROM users
                                          WHERE id IN (SELECT friend FROM friends_with WHERE user=?)
                                          ORDER BY first_name desc")) {
                $stmt->bind_param('s', $user->getId());
                $stmt->execute();
                $stmt->bind_result($id, $friend_email, $first_name, $last_name);
                
                // Go through all the users friends
                while ($stmt->fetch()) {
                    ?>

                    <!-- Create a status block for them -->
                    <div class="status_wrapper">
                        <div class="profile">
                            <?php echo "<a href=\"profile.php?email=$friend_email\">"; ?>
                                <img src="images/default_profile.png">
                            </a>
                        </div>
                        <div class="status_top">
                            <p><?php echo "<h2>" . $first_name . " " . $last_name . "</h2>"; ?></p>
                        </div>
                        <div class="status_bot">
                            <p>Email: <?php echo $friend_email; ?></p>
                        </div>
                    </div>

                <?php
                }

                // Close the statement
                $stmt->close();
            } else {
                // Some sort of error occured
                print "<h1>Failed to load statuses.</h1>";
            }

            // Close the connection
            $mysqli->close();

            ?>

        </div>
    </div>
</body>
</html>