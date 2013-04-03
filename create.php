<?php

require_once("config.php");
include("connect.php");

// Check that all the post vars are set
// otherwise redirect the user to the register page
if (!isset($_POST["first"]) ||
    !isset($_POST["last"]) ||
    !isset($_POST["email"]) ||
    !isset($_POST["password"]) ||
    !isset($_POST["day"]) ||
    !isset($_POST["month"]) ||
    !isset($_POST["year"]) ||
    !isset($_POST["street"]) ||
    !isset($_POST["city"]) ||
    !isset($_POST["state"]) ||
    !isset($_POST["zip"])) {
    header("Location: index.php");
    exit();
}

// Assemble the variables
$first = $_POST["first"];
$last = $_POST["last"];
$email = $_POST["email"];
$pass = $_POST["password"];
$day = $_POST["day"];
$month = $_POST["month"];
$year = $_POST["year"];
$street = $_POST["street"];
$city = $_POST["city"];
$state = $_POST["state"];
$zip = $_POST["zip"];

// Change the form date to the mysql format
$date = new DateTime($month . " " . $day . "," . $year);
$mysqldate = $date->format("Y-m-d H:i:s");

// Create hashed pass
$hash = crypt($pass, SALT);

//
// Insert address
//
if ($stmt = $mysqli->prepare("INSERT INTO address (street, city, state, zip)
                              VALUES (?, ?, ?, ?)")) {
    $stmt->bind_param('ssss', $street, $city, $state, $zip);
    if ($stmt->execute()) {
        // Address has been created, no need to display anything to user
    } else {
        // If it fails, the address already exists
        // Probably bad form, I'd like to redo this when there's time
    }

    // Close the statement
    $stmt->close();
} else {
    print "Failed to create address prepared statement (" . $mysqli->errno . ") " . $mysqli->error;
}

//
// Check for address id regardless
//
if ($stmt = $mysqli->prepare("SELECT ID FROM address
                              WHERE street=? AND city=? AND state=? AND zip=?")) {
    $stmt->bind_param('ssss', $street, $city, $state, $zip);
    $stmt->execute();
    // Bind the address id to var $address_id
    $stmt->bind_result($address_id);
    $stmt->fetch();

    // Close the statement
    $stmt->close();
} else {
    print "Failed to create address_id prepared statement (" . $mysqli->errno . ") " . $mysqli->error;
}

//
// Add user
//
if ($stmt = $mysqli->prepare("INSERT INTO users (email, password, dob, first_name, last_name, address)
                              VALUES (?, ?, ?, ?, ?, ?)")) {
    $stmt->bind_param('sssssi', $email, $hash, $mysqldate, $first, $last, $address_id);
    if ($stmt->execute()) {
        print "User created.<br/>";
    } else {
        // If it fails, a user with that email already exists
        // Probably bad form, I'd like to redo this when there's time
        print "User with that email already exists.<br/>";
    }

    // Close the statement
    $stmt->close();
} else {
    print "Failed to create user prepared statement (" . $mysqli->errno . ") " . $mysqli->error;
}

// Close the connection
$mysqli->close();
