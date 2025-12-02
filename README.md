**Project Goal: Develop a CRUD (Create, Read/Select, Update/Edit, Delete) application for a cruise ticketing system using PHP and CSS with mySQL database which contains 6 tables (ferry, country, ownership, room, passenger, crew), 4 of which (ferry, room, passenger, crew) having Foreign Keys to other tables where a booked/occupied room could no longer be selected for another passenger/crew member to occupy.**

**Table Information**
- Total Tables: 6
- Tables with Foreign Key(s): 4

Ownership Table Query:
CREATE TABLE ownership (
	id int AUTO_INCREMENT PRIMARY KEY,
	name varchar(50),
	networth int
);
Country Table Query: 
CREATE TABLE country (
    id int AUTO_INCREMENT PRIMARY KEY,
    name varchar(20),
    continent varchar(15),
    ports int
);

Ferry Table Query:
CREATE TABLE ferry (
    id int AUTO_INCREMENT PRIMARY KEY,
    name varchar(50),
    capacity int,
    ticketfee int, 
    transit varchar(75),
    destination varchar(75),
    ownership_id int,
    country_id int,
    FOREIGN KEY (ownership_id) REFERENCES ownership(id),
    FOREIGN KEY (country_id) REFERENCES country(id)
    ); 
    
Room Table Query:
CREATE TABLE room (
    id int AUTO_INCREMENT PRIMARY KEY,
    name varchar(4),
    type varchar(25),
    floor int,
    ferry_id int,
    FOREIGN KEY (ferry_id) REFERENCES ferry(id)
 );
 
Passenger Table Query:
CREATE TABLE passenger (
	id int AUTO_INCREMENT PRIMARY KEY,
    	name varchar(35), 
    	departuretime varchar(4),
	ferry_id int,
	room_id int,
    	FOREIGN KEY (ferry_id) REFERENCES ferry(id),
	FOREIGN KEY (room_id) REFERENCES room(id) 
	);
  
Crew Table Query:
CREATE TABLE crew (
    id int AUTO_INCREMENT PRIMARY KEY,
    name varchar(50),
    position varchar(35),
    salary int,
    ferry_id int,
    room_id int,
    FOREIGN KEY (ferry_id) REFERENCES ferry(id),
    FOREIGN KEY (room_id) REFERENCES room(id)
);

**More info can be found in the following report:**
https://docs.google.com/document/d/1wgXHyfE57bF3jh4gsum2gpZ4e3BkA3ln/edit?usp=drivesdk&ouid=102002154122297180970&rtpof=true&sd=true
