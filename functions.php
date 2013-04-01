<?php

include ("User.php");

// Return a User object for the user with the given email
function getUser($email) {
	if (userExists($email)) {
		return new User($email);
	} else {
		return null;
	}
}

// Does a user exist with the given email?
function userExists($email) {
	return true;
}
