<?php

require_once("config.php");
include("connect.php");

if (!isset($_POST["email"]) || !isset($_POST["password"])) {
    header("Location: index.php");
    exit();
}

$email = $_POST["email"];
$pass = $_POST["password"];

if ($stmt = $mysqli->prepare("SELECT EXISTS(SELECT 1 FROM users WHERE email=? AND password=?)")) {
    $stmt->bind_param('ss', $email, $hash);
    $stmt->execute();
    $stmt->bind_result($exists);
    $stmt->fetch();

    if ($exists) {
        // Start the session and add some vars
        session_start();
        $_SESSION["logged_in"] = 1;
        $_SESSION["email"] = $email;

        // Redirect the user to the newsfeed
        header("Location: newsfeed.php");
    } else {
        print "No user with that email and password found.";
    }
} else {
    print "Failed to create prepared statement (" . $mysqli->errno . ") " . $mysqli->error;
    exit();
}

// Close the connection
$mysqli->close();
