--Adatvázis létrehozás
CREATE DATABASE autoshowroom CHARACTER SET utf8 COLLATE utf8_general_ci;

--Felhasználók tárolására users tábla létrehozás
CREATE TABLE users(
	id INT(3) PRIMARY KEY AUTO_INCREMENT,
	firstn VARCHAR(255),
	secondn VARCHAR(255),
	email VARCHAR(255),
	username VARCHAR(255),
	pass VARCHAR(255)
);
--Létező felhasználónév ellenőrzése
SELECT username FROM users
WHERE username=?;

--Létező e-mail cím ellenőrzése
SELECT username FROM users
WHERE email=?;

--Felhasználó regisztrálása
INSERT INTO users(firstn, secondn, email, username, pass)
VALUES(?,?,?,?,?);


--Autók tábla, egy autóért csak egy alkalmazott felelős.
CREATE TABLE car(
	id INT(3) PRIMARY KEY AUTO_INCREMENT,
	mark VARCHAR(255),
	price INT(255),
	model VARCHAR(255),
	em_id INT(3),
	FOREIGN KEY (em_id) REFERENCES employee(id)
);

--Autók listázása a felelős alkalmazottal
SELECT mark, price, model, firstn, secondn FROM employee, car
WHERE car.em_id=employee.id
ORDER BY mark;

--Autó hozzáadás
INSERT INTO car(mark, price, model, em_id)
VALUES(?, ?, ?, ?);

--Autók módosítása
UPDATE car SET
mark=?,	price=?, model=?, em_id=?
WHERE id=?;

--Alkalmazottak tábla létrehozása
CREATE TABLE employee(
	id INT(3) PRIMARY KEY AUTO_INCREMENT,
	firstn VARCHAR(255),
	secondn VARCHAR(255),
	email VARCHAR(255)
);

--Alkalmazottak listázása
SELECT id, firstn, secondn, email FROM employee
ORDER BY firstn;

--Alkalmazott beillesztése
INSERT INTO employee(firstn, secondn, email)
VALUES(?, ?, ?);

--Alkalmazott módosítása
UPDATE employee SET
firstn=?, secondn=?, email=?
WHERE id=?;

--VEVŐ tábla létrehozása
CREATE TABLE customer(
	id INT(3) PRIMARY KEY AUTO_INCREMENT,
	firstn VARCHAR(255),
	secondn VARCHAR(255),
	email VARCHAR(255)
);

--Vevők listázása
SELECT id, firstn, secondn, email FROM customer
ORDER BY firstn;

--Vevők beillesztése
INSERT INTO customer(firstn, secondn, email)
VALUES(?, ?, ?);

--Vevők módosítása
UPDATE customer SET
firstn=?, secondn=?, email=?
WHERE id=?;