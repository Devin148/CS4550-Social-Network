<?php

session_start();
// If the user is logged in and the status var is set
if (isset($_SESSION["logged_in"]) && isset($_SESSION["email"]) && isset($_POST["friend_id"])) {
	$email = $_SESSION["email"];
	$friend_id = $_POST["friend_id"];

	include ("functions.php");
	$user = getUser($email);
	if ($user == null) {
		echo "false"; // Echo the result for ajax
	} else {
		// Connect to the db
		include ("connect.php");

		// Add friendship
		if ($stmt = $mysqli->prepare("INSERT INTO friends_with (user, friend)
	                        		  VALUES (?, ?)")) {
		    $stmt->bind_param('ii', $user->getId(), $friend_id);
		    if ($stmt->execute()) {
		    	$stmt->close();
		    	$mysqli->close();
		    	echo "true";
		    } else {
		    	$stmt->close();
		    	$mysqli->close();
		    	echo "false";
		    }
		} else {
			$mysqli->close();
			echo "false";
		}
	}
}