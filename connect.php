<?php

require_once("config.php");

$mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
if ($mysqli->connect_errno) {
    print "Failed to connect to db: " . $mysqli->connect_error;
    exit();
}

$mysqli->select_db(MYSQL_DB);