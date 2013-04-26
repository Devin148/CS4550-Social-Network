<?php

session_start();
// If the user is logged in and the status var is set
if (isset($_SESSION["logged_in"]) && isset($_SESSION["email"]) && isset($_POST["status"]) && isset($_POST["address"])) {
	$email = $_SESSION["email"];
	$status = $_POST["status"];
	$address = $_POST["address"];

	include ("functions.php");
	$user = getUser($email);
	if ($user == null) {
		echo "Error Code 1"; // Echo the result for ajax
	} else {
		// Connect to the db
		include ("connect.php");

		// Insert a status
		if ($stmt = $mysqli->prepare("INSERT INTO status (author, content, address)
	                        		  VALUES (?, ?, ?)")) {
		    $stmt->bind_param('iss', $user->getId(), $status, $address);
		    if ($stmt->execute()) {
		    	$stmt->close();
		    	$mysqli->close();
		    	echo "true";
		    } else {
		    	$stmt->close();
		    	$mysqli->close();
		    	echo "Error Code 2";
		    }
		} else {
			$mysqli->close();
			echo "Error Code 3";
		}
	}
} else {
	echo "Error Code 4";
}
