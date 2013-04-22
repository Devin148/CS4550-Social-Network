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

        <div id="middle_content">

            <!-- Add the status box -->
            <div id="status_box_wrapper">
                <form action="newsfeed.php" name="status_form" id="status_form">
                    <div contenteditable="true" id="status_box">How's life?</div>
                    <input type="submit" id="submit" value="Submit" />
                </form>
            </div>

            <!-- Start adding statuses -->
            <?php

            // Connect to the db
            include ("connect.php");

            // Select all the statuses of people the user is friends with
            if ($stmt = $mysqli->prepare("SELECT content, author, time FROM status
                                          WHERE author IN (SELECT friend FROM friends_with WHERE user=?)
                                                OR author=?
                                          ORDER BY time desc
                                          LIMIT 0, 25")) {
                $stmt->bind_param('ss', $user->getId(), $user->getId());
                $stmt->execute();
                $stmt->bind_result($content, $author_id, $time);
                
                // Double check we're only grabbing the first 25
                $i = 0;
                while ($stmt->fetch() && $i<=25) {
                    $i++;

                    // Create a User for the author
                    $author = getUserFromId($author_id);
                    $author_name = $author->getFirstName() . " " .
                                   $author->getLastName();
                    $author_email = $author->getEmail();

                    $twitter_content = "$author_name via NEU Social: $content";
                    $facebook_content = "http://www.swimmfrog.com/social/profile.php?email=$author_email";
                    ?>

                    <!-- Create a status block for them -->
                    <div class="status_wrapper">
                        <div class="profile">
                            <?php echo "<a href=\"profile.php?email=$author_email\">"?>
                                <img src="images/default_profile.png">
                            </a>
                        </div>
                        <div class="status_top">
                            <p><?php echo $content; ?></p>
                        </div>
                        <div class="status_bot">
                            <p>Posted from Boston, MA at <?php echo $time; ?></p>
                        </div>
                    </div>
                    <!-- <p>
                        <a onClick="window.open('http://twitter.com/home?status=<?php echo $twitter_content; ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                        href="javascript: void(0)"><img src="images/buttons/twitter.png" /></a>
                        <a onClick="window.open('http://www.facebook.com/share.php?u=<?php echo $facebook_content; ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                        href="javascript: void(0)"><img src="images/buttons/facebook.png" /></a>
                    </p> -->

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

        <!-- Third column -->
        <div id="right_content">
            <h3>People you may know</h3>

            <div class="friend_grid">
                <?php

                // Connect to the db
                include ("connect.php");

                // Find the user and fill in the vars
                if ($stmt = $mysqli->prepare("SELECT first_name, last_name, email
                                              FROM users WHERE id!=? ORDER BY RAND() LIMIT 20")) {

                    $stmt->bind_param('s', $user->getId());
                    $stmt->execute();
                    $stmt->bind_result($rand_first, $rand_last, $rand_email);
                    
                    while ($stmt->fetch()) {

                        ?>

                        <div class="square">
                            <?php echo "<a href=\"profile.php?email=$rand_email\"><img src=\"images/default_profile.png\" /></a>"; ?>
                            <span class="tooltip"><?php echo $rand_first . " " . $rand_last; ?></span>
                        </div>

                        <?php
                    }

                    // Close the statement
                    $stmt->close();
                } else {
                    // Throw exception
                    print "Failed to find random users.";
                }

                // Close the connection
                $mysqli->close();

                ?>
            </div>

        <!-- Clear the floats -->
        <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>

    <script>
    // When the document is ready
    $(document).ready(function () {

        var focused = false;

        // When the status box is focused
        $("#status_box").focus(function() {
            if (!focused) {
                $("#status_box").html("");
                $("#status_box").css("color", "#222");
                $("#status_box").css("height", "100px");
                focused = true;
            }
        });

        // Validate and submit the status form:
        // If the user presses enter
        $("#status_form").submit(function () {
            var result = false;
            // If the status box isn't empty
            if (!isEmpty($("#status_box").text())) {
                var result = false;
                // Add the status through an ajax request to the php file
                $.ajax({
                    type:  "POST",
                    url:   "add_status.php",
                    data:  "status=" + $.trim($("#status_box").text()),
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