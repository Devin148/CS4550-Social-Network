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

// Initialize Values.
$email = $_SESSION['email'];
$user = getUser($email);
$id = $user->getId();
$src = NULL;
$ext = "";

// Based upon file, convert for use in database.
if (($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg"))
{
	$ext = "jpg";
	$src = imagecreatefromjpeg($_FILES['file']['tmp_name']);

}
else if ($_FILES["file"]["type"] == "image/png")
{
	$ext = "png";
	$src = imagecreatefrompng($_FILES['file']['tmp_name']);
}
else if ($_FILES["file"]["type"] == "image/gif")
{
	$ext = "gif";
	$src = imagecreatefromgif($_FILES['file']['tmp_name']);
}

// Make sure it was a valid file, if not complain. 
if ((($ext == "jpg") || ($ext == "png") || ($ext == "gif")) && ($_FILES["file"]["size"] < 5000000))
  {
  	
  	// Check for errors, make sure upload worked.
  	if ($_FILES["file"]["error"] > 0)
    	{
    	echo "Error Code: ";
    	echo $_FILES["file"]["error"];
    	echo "<br />";
    	}
 	 else
    	{
		// Upload pic to server
		imagejpeg($src,$_FILES["file"]["tmp_name"], 100);
		imagedestroy($src);
		
 		// Move pic.
		$picturelocation = "images/profile/$id.$ext";
		move_uploaded_file($_FILES["file"]["tmp_name"], "$picturelocation");
      	
      	// Connect to DB
        include ("connect.php");

        // Make pic the default
        if ($stmt = $mysqli->prepare("UPDATE users SET image_loc=? WHERE id=?")) {
            $stmt->bind_param('ss', $picturelocation, $user->getId());
            if ($stmt->execute()) {
                $stmt->close();
                $mysqli->close();
            } else {
                $stmt->close();
                $mysqli->close();
                echo "Failed to update profile picture.";
                echo $mysqli->error;
            }
        } else {
            $mysqli->close();
                echo "Failed to update profile picture.";
                echo $mysqli->error;
        }

		header("location: profile.php?email=$email");

      } 
}
else
	{
  echo "Invalid file, unable to upload.";
	}
?>