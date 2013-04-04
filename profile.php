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

include ("functions.php");

// Get the email vars
$profile_email = $_GET["email"];
$user_email = $_SESSION["email"];

// If the email in GET doesn't exist, redirect them to their own profile
if (!userWithEmailExists($profile_email)) {
    header("Location: profile.php?email=$user_email");
    exit();
}

// User of the profile
$user = getUser($profile_email);
$profile_id = $user->getId();

// Check if the current user is the profile user
$visible = false; // false by default
$your_profile = false;
if ($user_email == $profile_email) {
	$visible = true;
    $your_profile = true;
} else {
	// If there are any rows from the query then current user is a friend of profile user
    $current_user = getUser($user_email);
	$visible = areFriends($current_user->getId(), $profile_id);
}
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
    <?php include ("navbar.php"); ?>
    <div class="clear"></div>

    <div id="content_wrapper">
        <div id="content" class="full">
            <div id="profile_head">
                <?php 
                $first_name = $user->getFirstName();
                $last_name = $user->getLastName();
                $dob = $user->getDob();
                $street = $user->getStreet();
                $city = $user->getCity();
                $state = $user->getState();
                $zip = $user->getZip();
                ?>

                <!-- Display Current Profile User Information -->
                <img src="images/default_profile.png" />
                <div class="info">
                    <?php
                	echo "<h1>$first_name  $last_name</h1>";

                    // If the current user is not a friend of the profile user show Add Friend option
                    if (!$visible) {
                        ?>
                    	<!-- Button to add friend executes add_friend.php -->
                        <form <?php echo "action=\"profile.php?email=$profile_email\""; ?> name="addfriend" id="addfriend">
                            <input type="submit" name="addfriend" value="Add Friend">
                        </form>
                    <?php
                    } else if ($visible && !$your_profile) {
                        ?>
                    	<!-- Button to delete friend executes delete_friend.php -->
                        <form action="javascript:alert('Success!')" name="deletefriend" id="deletefriend">
                            <input type="submit" name="deletefriend" value="Delete Friend">
                        </form>
                      	<?php
                    }
                    if (false) { // if it's $your_profile
                        ?>
                        <form action='upload.php' method='POST' enctype='multipart/form-data'>
                        <input type='file' name="myfile"> <input type='submit' name='submit' value='Upload'></form>
                        <?php
                    } ?>

                    <p>About</p>

                    <p>
                    <?php
                    	// Only show if current user is a friend of profile user
                    	if ($visible) { // Or if current user is the profile user
                    		echo $dob."<br>".$street."<br>".$city."<br>".$state."<br>".$zip;
                    	}
                    ?>
                    </p>
                </div>
                <div class="clear"></div>
            </div>

            <!-- Get list of friends -->
            <div id="friends">
                <h1>Friends</h1>
                <hr />

                <?php

                // Connect to the db
                include ("connect.php");

                // Find the user and fill in the vars
                if ($stmt = $mysqli->prepare("SELECT friend FROM friends_with WHERE user=?")) {
                    $stmt->bind_param('s', $profile_id);
                    $stmt->execute();
                    $stmt->bind_result($friend_id);
                    
                    $i = 0;
                    while ($stmt->fetch() && $i<=5) {
                        $i++;

                        $friend = getUserFromId($friend_id);
                        $friend_name = $friend->getFirstName() . " " . $friend->getLastName();
                        $friend_email = $friend->getEmail();
                        ?>

                        <p><a <?php echo "href=\"profile.php?email=$friend_email\"";?>>
                            <?php echo $friend_name; ?>
                        </a></p>

                        <?php
                    }

                    if ($i==0) {
                        print "<p>This user has no friends.</p>";
                    }

                    // Close the statement
                    $stmt->close();
                } else {
                    // Throw exception
                    print "<p>There was an error generating statuses.";
                }

                // Close the connection
                $mysqli->close();

                ?>

            </div>

            <!-- Get user's statuses -->
            <div id="statuses">
                <h1>Statuses</h1>
                <hr />

                <?php

                // Connect to the db
                include ("connect.php");

                // Find the user and fill in the vars
                if ($stmt = $mysqli->prepare("SELECT content, time FROM status
                                              WHERE author=? ORDER BY time desc")) {
                    $stmt->bind_param('s', $profile_id);
                    $stmt->execute();
                    $stmt->bind_result($content, $time);
                    
                    $i = 0;
                    while ($stmt->fetch() && $i<=25) {
                        $i++;
                        ?>

                        <p><?php echo $content; ?></p>
                        <p>At <?php echo $time; ?></p>
                        <hr />

                        <?php
                    }

                    // Close the statement
                    $stmt->close();
                } else {
                    // Throw exception
                    print "<p>There was an error generating statuses.";
                }

                // Close the connection
                $mysqli->close();

                ?>

            </div>
            <div class="clear"></div>

        </div>
    </div>

    <script>
    // When the document is ready
    $(document).ready(function () {
        // The form with id="addfriend" is submitted
        $("#addfriend").submit(function () {
            var result = false;

            // Convert php var to js
            <?php
            $json_friend_id = json_encode($user->getId());
            echo "var friend_id = $json_friend_id;";
            ?>

            // Submit the friend request via ajax
            $.ajax({
                type:  "POST",
                url:   "add_friend.php",
                data: "friend_id=" + friend_id,
                async: false
            }).done (function (ret) {
                if (ret == "true") {
                    result = true;
                }
            });

            return result;
        });

        // And the form with id="deletefriend" is submitted
        $("#deletefriend").submit(function () {
            var result = false;

            // Convert php var to js
            <?php
            $json_friend_id = json_encode($user->getId());
            echo "var friend_id = $json_friend_id;";
            ?>

            // Submit the friend request via ajax
            $.ajax({
                type:  "POST",
                url:   "delete_friend.php",
                data: "friend_id=" + friend_id,
                async: false
            }).done (function (ret) {
                if (ret == "true") {
                    result = true;
                }
            });

            return result;
        });
    });
    </script>
</body>
</html>