<?php

include ("User.php");

function getUser($email) {
	if (userExists($email)) {
		return new User($email);
	}
}

function userExists($email) {
	return true;
}