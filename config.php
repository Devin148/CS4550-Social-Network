<?php

$mysqli = new mysqli("localhost","local_user","local_pass");
if ($mysqli->connect_errno) {
    echo ("Failed to connect to db: " . $mysqli->connect_error);
}