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
if ($user_email == $profile_email) {
	$visible = true;
} else {
	// If there are any rows from the query then current user is a friend of profile user
    $current_user = getUser($user_email);
	$visible = areFriends($current_user->getId(), $profile_id);
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Northeastern Social - Profile</title>
    <script src="js/form.js" type="text/javascript"></script>
    <script src="js/jquery-1.9.0.min.js" type="text/javascript"></script>
</head>

<body>

    <?php 

    $first_name = $user->getFirstName();
    $last_name = $user->getLastName();
    $dob = $user->getDob();
    $street = $user->getStreet();
    $city = $user->getCity();
    $state = $user->getState();
    $zip = $user->getZip();

    // Display Current Profile User Information
	echo $first_name . " " . $last_name;

    // If the current user is not a friend of the profile user show Add Friend option
    if (!$visible) {
        ?>
    	<!-- Button to add friend executes add_friend.php -->
        <form action="javascript:alert('Success!')" name="addfriend" id="addfriend">
            <input type="submit" name="addfriend" value="Add Friend">
        </form>
    <?php
    } else {
        ?>
    	<!-- Button to delete friend executes delete_friend.php -->
        <form action="javascript:alert('Success!')" name="deletefriend" id="deletefriend">
            <input type="submit" name="deletefriend" value="Delete Friend">
        </form>
      	<?php } ?>
        
    <p>Upload a profile picture:</p>
    <form action='upload.php' method='POST' enctype='multipart/form-data'>
    File: <input type='file' name="myfile"> <input type='submit' name='submit' value='Upload'></form>

    <p>About</p>

    <p>
    <?php
    	// Only show if current user is a friend of profile user
    	if ($visible) { // Or if current user is the profile user
    		echo $dob."<br>".$street."<br>".$city."<br>".$state."<br>".$zip;
    	}
    ?>
    </p>
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