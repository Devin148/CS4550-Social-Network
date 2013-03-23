CREATE TABLE users
(
	id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	email varchar(255) NOT NULL,
	password varchar(255) NOT NULL,
	first_name varchar(255) NOT NULL,
	last_name varchar(255) NOT NULL,
	address int NOT NULL,
	FOREIGN KEY (address) REFERENCES address(id)
);

CREATE TABLE address
(
	id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	num int NOT NULL,
	street varchar(255) NOT NULL,
	city varchar(255) NOT NULL,
	state varchar(255) NOT NULL,
	zip varchar(255) NOT NULL
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