CREATE DATABASE everyday;

CREATE TABLE users(
	id INT(10) AUTO_INCREMENT PRIMARY KEY,
	fname VARCHAR(255),
	sname VARCHAR(255),
	username VARCHAR(255),
	pass VARCHAR(255),
	email VARCHAR(255)
);