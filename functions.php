<?php

include ("User.php");

// Return a User object for the user with the given email
function getUser($email) {
	if (userExists($email)) {
		$user = new User();
		$user->createUserFromEmail($email);
		return $user;
	} else {
		return null;
	}
}

function getUserFromId($id) {
	if (userExists($id)) {
		$user = new User();
		$user->createUserFromId($id);
		return $user;
	} else {
		return null;
	}
}

// Does a user exist with the given email?
function userExists($email) {
	return true;
}
