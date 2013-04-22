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
$email = $_SESSION["email"];

// If the email in GET doesn't exist
if (!userWithEmailExists($profile_email)) {
    header("Location: profile.php?email=$email");
    exit();
}

// User of the profile
$user = getUser($profile_email);
$profile_id = $user->getId();

// Check if the current user is the profile user
$visible = false; // false by default
$your_profile = false;
if ($email == $profile_email) {
    $visible = true;
    $your_profile = true;
} else {
    // If there are any rows from the query then current user is a friend of profile user
    $current_user = getUser($email);
    $visible = areFriends($current_user->getId(), $profile_id);
}

// Get profile information
$first_name = $user->getFirstName();
$last_name = $user->getLastName();
$dob = $user->getDob();
$street = $user->getStreet();
$city = $user->getCity();
$state = $user->getState();
$zip = $user->getZip();
$id = $user->getId();

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

    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMtevdjK0khTU88pFMJXiDyvlCXWSwQVg&sensor=false">
    </script>
    <script type="text/javascript">
    // Maps vars
    var geocoder;
    var map;

    // Initialize the google maps with the profile's address
    function initialize() {
        <?php
        $full_address = $street . " " . $city . ", " . $state . " " . $zip;
        $json_address = json_encode($full_address);
        echo "var address = $json_address;";
        ?>
        geocoder = new google.maps.Geocoder();
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var mapOptions = {
                    center: results[0].geometry.location,
                    zoom: 15,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                map = new google.maps.Map(document.getElementById("map-canvas"),
                    mapOptions);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location,
                    animation: google.maps.Animation.DROP,
                    draggable: false
                });
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    </script>
</head>

<body>
    <div id="container">
        <!-- Add the nav and side bars -->
        <?php include ("navbar.php"); ?>
        <?php include ("sidebar.php"); ?>

        <div id="large_content">
            <div id="header">
                <img src="images/profile/cover.png" class="cover" />
                <img src="images/default_profile.png" class="profile" />
                <div id="name">
                    <h1><?php echo $first_name . " " . $last_name; ?></h1>
                    <h2><?php echo $street . " " . $city . ", " . $state; ?></h2>
                </div>
                <div id="stats">
                    <?php if ($visible) { ?>
                        <ul>
                            <li>
                                <div class="fui-man-24"></div>
                                <?php echo numFriends($id); ?></li>
                            <li>
                                <div class="fui-heart-24"></div>
                            </li>
                            <li>
                                <div class="fui-new-24"></div>
                                <?php echo numStatuses($id); ?>
                            </li>
                            <?php if(!$your_profile) { ?>
                                <li class="unfollow">
                                    <form action="profile.php" name="deletefriend" id="deletefriend">
                                        <input type="hidden" name="email" <?php echo "value=\"$profile_email\""; ?> />
                                        <input type="submit" name="deletefriend" value="Unfollow">
                                    </form>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <form action="profile.php" name="addfriend" id="addfriend">
                            <input type="hidden" name="email" <?php echo "value=\"$profile_email\""; ?> />
                            <input type="submit" name="addfriend" value="Follow">
                        </form>
                    <?php } ?>

                </div>
                <div class="clear"></div>
            </div>

            <div id="map-canvas" style="width: 800px; height: 300px"></div>
        </div>

        <div class="clear"></div>
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