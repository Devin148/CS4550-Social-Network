CREATE TABLE address
(
	id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	street varchar(255) NOT NULL,
	city varchar(255) NOT NULL,
	state varchar(2) NOT NULL,
	zip varchar(5) NOT NULL,
	UNIQUE(street, city, state, zip)
);

CREATE TABLE users
(
	id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	email varchar(255) NOT NULL,
	password varchar(100) NOT NULL,
	dob date NOT NULL,
	first_name varchar(100) NOT NULL,
	last_name varchar(100) NOT NULL,
	address int NOT NULL,
	image_loc varchar(200) NOT NULL DEFAULT "http://www.swimmfrog.com/social/images/profile/default_profile.png",
	FOREIGN KEY (address) REFERENCES address(id),
	UNIQUE(email)
);

CREATE TABLE friends_with
(
	id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	user int NOT NULL,
	friend int NOT NULL,
	FOREIGN KEY (user) REFERENCES users (id),
	FOREIGN KEY (friend) REFERENCES users (id)
);

CREATE TABLE status
(
	id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	author int NOT NULL,
	content varchar(255) NOT NULL,
	time timestamp DEFAULT CURRENT_TIMESTAMP,
	latitude varchar(50),
	longitude varchar(50),
	FOREIGN KEY (author) REFERENCES users (id)
);

CREATE TABLE post
(
	id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	author int NOT NULL,
	wall int NOT NULL,
	FOREIGN KEY (author) REFERENCES users (id),
	FOREIGN KEY (wall) REFERENCES users (id)
);