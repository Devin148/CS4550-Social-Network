<?php

include ("User.php");

// Return a User object for the user with the given email
function getUser($email) {
	if (userWithEmailExists($email)) {
		$user = new User();
		$user->createUserFromEmail($email);
		return $user;
	} else {
		return null;
	}
}

function getUserFromId($id) {
	if (userWithIdExists($id)) {
		$user = new User();
		$user->createUserFromId($id);
		return $user;
	} else {
		return null;
	}
}

// Does a user exist with the given email?
function userWithEmailExists($email) {
	// Connect to the db
    include ("connect.php");

    // Query if the users are friends
    if ($stmt = $mysqli->prepare("SELECT EXISTS(SELECT 1 FROM users WHERE email=?)")) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($exists);
    	$stmt->fetch();

        // If the row exists, so does the user
        if ($exists) {
        	$stmt->close();
        	$mysqli->close();
        	return true;
        }
        $stmt->close();
        $mysqli->close();
        return false;
    } else {
        // Some sort of exception, return false
        $mysqli->close();
        return false;
    }
}

// Does a user exist with the given id?
function userWithIdExists($id) {
	// Connect to the db
    include ("connect.php");

    // Query if the users are friends
    if ($stmt = $mysqli->prepare("SELECT EXISTS(SELECT 1 FROM users WHERE id=?)")) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($exists);
    	$stmt->fetch();

        // If the row exists, so does the user
        if ($exists) {
        	$stmt->close();
        	$mysqli->close();
        	return true;
        }
        $stmt->close();
        $mysqli->close();
        return false;
    } else {
        // Some sort of exception, return false
        $mysqli->close();
        return false;
    }
}


// Is the given user friends with the given friend
function areFriends($user_id, $friend_id) {
	// Connect to the db
    include ("connect.php");

    // Query if the users are friends
    if ($stmt = $mysqli->prepare("SELECT EXISTS(SELECT 1 FROM friends_with WHERE user=? AND friend=?)")) {
        $stmt->bind_param('ii', $user_id, $friend_id);
        $stmt->execute();
        $stmt->bind_result($exists);
    	$stmt->fetch();

        // If the row exists, they are friends
        if ($exists) {
        	$stmt->close();
        	$mysqli->close();
        	return true;
        }
        $stmt->close();
        $mysqli->close();
        return false;
    } else {
        // Some sort of exception, return false
        $mysqli->close();
        return false;
    }
}

// Returns the number of friends user with the given id has
function numFriends($id) {
    // Connect to the db
    include ("connect.php");

    // Query number of friends
    if ($stmt = $mysqli->prepare("SELECT COUNT(*) FROM friends_with WHERE user=?")) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($num);

        if ($stmt->fetch()) {
            $stmt->close();
            $mysqli->close();
            return $num;
        }
        $stmt->close();
        $mysqli->close();
        return 0;
    } else {
        // Some sort of exception, return 0
        $mysqli->close();
        return 0;
    }
}

// Returns the number of statuses user with the given id has
function numStatuses($id) {
    // Connect to the db
    include ("connect.php");

    // Query number of friends
    if ($stmt = $mysqli->prepare("SELECT COUNT(*) FROM status WHERE author=?")) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($num);

        if ($stmt->fetch()) {
            $stmt->close();
            $mysqli->close();
            return $num;
        }
        $stmt->close();
        $mysqli->close();
        return 0;
    } else {
        // Some sort of exception, return 0
        $mysqli->close();
        return 0;
    }
}

// Returns the number of statuses user with the given id has
function numCoops($id) {
    // Connect to the db
    include ("connect.php");

    // Query number of friends
    if ($stmt = $mysqli->prepare("SELECT COUNT(*) FROM coop WHERE student=?")) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($num);

        if ($stmt->fetch()) {
            $stmt->close();
            $mysqli->close();
            return $num;
        }
        $stmt->close();
        $mysqli->close();
        return 0;
    } else {
        // Some sort of exception, return 0
        $mysqli->close();
        return 0;
    }
}