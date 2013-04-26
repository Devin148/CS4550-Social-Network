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
    <script src="js/jquery-ui-1.9.2.custom.min.js" type="text/javascript"></script><script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMtevdjK0khTU88pFMJXiDyvlCXWSwQVg&sensor=false">
    </script>

    <script>
    function codeLatLng(latitude, longitude, callback) {
        var lat = parseFloat(latitude);
        var lng = parseFloat(longitude);
        var latlng = new google.maps.LatLng(lat, lng);
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'latLng': latlng}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            if (results[2]) {
                callback(results[2].formatted_address);
            }
          } else {
                alert("Please allow location services on NEU social for full functionality.");
                callback("unknown location.");
          }
        });
      }
    </script>
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
            if ($stmt = $mysqli->prepare("SELECT content, author, address FROM status
                                          WHERE author IN (SELECT friend FROM friends_with WHERE user=?)
                                                OR author=?
                                          ORDER BY time desc
                                          LIMIT 0, 25")) {
                $stmt->bind_param('ss', $user->getId(), $user->getId());
                $stmt->execute();
                $stmt->bind_result($content, $author_id, $address);
                
                // Double check we're only grabbing the first 25
                $i = 0;
                while ($stmt->fetch() && $i<=25) {
                    $i++;

                    // Create a User for the author
                    $author = getUserFromId($author_id);
                    $author_name = $author->getFirstName() . " " .
                                   $author->getLastName();
                    $author_email = $author->getEmail();
                    $author_image = $author->getImageLoc();

                    $twitter_content = "$author_name via NEU Social: $content";
                    $facebook_content = "http://www.swimmfrog.com/social/profile.php?email=$author_email";

                    ?>

                    <!-- Create a status block for them -->
                    <div class="status_wrapper">
                        <div class="profile">
                            <?php echo "<a href=\"profile.php?email=$author_email\">"?>
                                <img <?php echo "src=\"$author_image\""; ?> />
                            </a>
                        </div>
                        <div class="status_top">
                            <p><?php echo $content; ?></p>
                        </div>
                        <div class="status_bot">
                            <p>Posted from <?php echo $address; ?></p>
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
                if ($stmt = $mysqli->prepare("SELECT first_name, last_name, email, image_loc
                                              FROM users WHERE id!=?
                                                         AND id NOT IN (SELECT friend from friends_with WHERE user=?)
                                              ORDER BY RAND() LIMIT 20")) {

                    $stmt->bind_param('ss', $user->getId(), $user->getId());
                    $stmt->execute();
                    $stmt->bind_result($rand_first, $rand_last, $rand_email, $rand_image);
                    
                    while ($stmt->fetch()) {

                        ?>

                        <div class="square">
                            <?php echo "<a href=\"profile.php?email=$rand_email\"><img src=\"$rand_image\" /></a>"; ?>
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

        var latitude;
        var longitude;
        getLocation();

        // Get the user's location to add to statuses
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else{
                alert ("Geolocation is not supported by this browser.");
            }
        }
        // Set the lat and long vars
        function showPosition(position) {
            latitude = position.coords.latitude;
            longitude = position.coords.longitude;
        }

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
            // If the status box isn't empty
            if (!isEmpty($("#status_box").text())) {
                <?php
                // $json_lat = json_encode($latitude);
                // $json_long = json_encode($longitude);
                // echo "var json_latitude = $json_lat;\n";
                // echo "var json_longitude = $json_long;\n";
                ?>

                codeLatLng(latitude, longitude, function(addr) {
                    // Add the status through an ajax request to the php file
                    $.ajax({
                        type:  "POST",
                        url:   "add_status.php",
                        data:  { "status" : $.trim($("#status_box").text()),
                                 "address"  : addr },
                        async: false
                    }).done (function (ret) {
                        if (ret == "true") {
                            window.open("newsfeed.php", "_self");
                        } else {
                            alert ("Failed to post status: " + ret);
                        }
                    });
                });
            }
            return false;
        });
    });
    </script>

</body>
</html>