<?php

session_start();
// If the user is logged in and the status var is set
if (isset($_SESSION["logged_in"]) && isset($_SESSION["email"]) && isset($_POST["status"])) {
	$email = $_SESSION["email"];
	$status = $_POST["status"];

	include ("functions.php");
	$user = getUser($email);
	if ($user == null) {
		echo "false"; // Echo the result for ajax
	} else {
		// Connect to the db
		include ("connect.php");

		// Insert a status
		if ($stmt = $mysqli->prepare("INSERT INTO status (author, content)
	                        		  VALUES (?, ?)")) {
		    $stmt->bind_param('is', $user->getId(), $status);
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
