<?php

//
// User class to represent a row in the users table
//
class User {
	private $email;
	private $first_name;
	private $last_name;
	private $dob;
	private $address_id;

	private $street;
	private $city;
	private $state;
	private $zip;

	// Give the constructor an email
	function __construct($email) {
		$this->email = $email;
		$this->createUser();
	}

	// Hidden helper
	private function createUser() {
		// Connect to the db
		include ("connect.php");

		// Find the user and fill in the vars
		if ($stmt = $mysqli->prepare("SELECT dob, first_name, last_name, address FROM users WHERE email=?")) {
		    $stmt->bind_param('s', $this->email);
		    $stmt->execute();
		    $stmt->bind_result($dob, $first_name, $last_name, $address_id);
		    
		    if ($stmt->fetch()) {
		    	$this->first_name = $first_name;
		    	$this->last_name = $last_name;
		    	$this->dob = $dob;
		    	$this->address_id = $address_id;
		    } else {
		    	// Throw exception
		    }

		    // Close the statement
		    $stmt->close();
		} else {
			// Throw exception
		}

		// Find the address and fill in the vars
		if ($stmt = $mysqli->prepare("SELECT street, city, state, zip FROM address WHERE id=?")) {
		    $stmt->bind_param('i', $this->address_id);
		    $stmt->execute();
		    $stmt->bind_result($street, $city, $state, $zip);
		    
		    if ($stmt->fetch()) {
		    	$this->street = $street;
		    	$this->city = $city;
		    	$this->state = $state;
		    	$this->zip = $zip;
		    } else {
		    	// Throw exception
		    }

		    // Close the statement
		    $stmt->close();
		} else {
			// Throw exception
		}

		// Close the connection
		$mysqli->close();
	}

	// Return the email of this user
	public function getEmail() {
		return $this->email;
	}

	// Return the first name of this user
	public function getFirstName() {
		return $this->first_name;
	}

	// Return the last name of this user
	public function getLastName() {
		return $this->last_name;
	}

	// Return the dob of this user
	public function getDob() {
		return $this->dob;
	}

	// Return the street of this user
	public function getStreet() {
		return $this->street;
	}

	// Return the city of this user
	public function getCity() {
		return $this->city;
	}

	// Return the state of this user
	public function getState() {
		return $this->state;
	}

	// Return the zip of this user
	public function getZip() {
		return $this->zip;
	}

}