<?php

session_start();
require_once("config.php");
include("connect.php");
include ("functions.php");

if (!isset($_POST["name"]) || !isset($_POST["rating"]) || !isset($_POST["description"]) || !isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION["email"];
$name = $_POST["name"];
$rating = $_POST["rating"];
$description = $_POST["description"];

$user = getUser($email);
$id = $user->getId();

if ($stmt = $mysqli->prepare("INSERT INTO coop (student, name, rating, description)
                              VALUES (?, ?, ?, ?)")) {
    $stmt->bind_param('isss', $user->getId(), $name, $rating, $description);
    if ($stmt->execute()) {
        $stmt->close();
        $mysqli->close();
        header("Location: coops.php");
    } else {
        $stmt->close();
        echo "Failed to add a co-op.";
        print $mysqli->error;
        $mysqli->close();
    }
} else {
    echo "Failed to add a co-op.";
    print $mysqli->error;
    $mysqli->close();
}

// Close the connection
$mysqli->close();
