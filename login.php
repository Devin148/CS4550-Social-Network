<?php

require_once("config.php");
include("connect.php");

if (!isset($_POST["email"]) || !isset($_POST["password"])) {
    header("Location: index.php");
}

$email = $_POST["email"];
$pass = $_POST["password"];

print $email;
print "<br />";
print $pass;
print "<br /><br />";

print "Salt: " . SALT;
print "<br /><br />";

$hash = crypt($pass, SALT);
print "Hashed Pass: " . $hash;
print "<br /><br />";

if ($stmt = $mysqli->prepare("SELECT EXISTS(SELECT 1 FROM users WHERE email=? AND password=?)")) {
    $stmt->bind_param('ss', $email, $hash);
    $stmt->execute();
    $stmt->bind_result($exists);
    $stmt->fetch();

    if ($exists) {
        print "Logged in.";
        session_start();
        $_SESSION["logged_in"] = 1;
        $_SESSION["email"] = $email;
    } else {
        print "No user with that email and password found.";
    }
} else {
    print "Failed to create prepared statement (" . $mysqli->errno . ") " . $mysqli->error;
    exit();
}