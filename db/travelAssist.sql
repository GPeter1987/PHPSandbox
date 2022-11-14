/* Táblák:
    UTAZÁS -> TRAVEL
    CSOMAG -> PACKAGE
    POI -> POI
    NAPLO -> DIARY
    KÖLTSÉG -> COST
    ÉRTESÍTÉS -> ALERT
    CSOMAG_TETEL_REF -> PACKAGE_PARC_REF
 */

/* Create tables */
 CREATE TABLE IF NOT EXISTS travel (
    travel_id int AUTO_INCREMENT,
    travel_name varchar(50),
    travel_start date,
    travel_end date,
    travel_type varchar(50),
    travel_data_1 varchar(200) NULL,
    travel_data_2 varchar(200) NULL,
    travel_data_3 varchar(200) NULL,
    travel_desc varchar(200) NULL,
    PRIMARY KEY (travel_id)
 );

 CREATE TABLE IF NOT EXISTS package (
    package_id int  AUTO_INCREMENT,
    package_parc_name varchar(50),
    package_weight double(3,2) NULL,
    package_travel_id int,
    package_parc_quantity int,
    package_parc_ok char(5) NULL,
    PRIMARY KEY (package_id),
    FOREIGN KEY (package_travel_id) REFERENCES travel(travel_id)
 );

CREATE TABLE IF NOT EXISTS poi (
    poi_id int AUTO_INCREMENT,
    poi_name varchar(50),
    poi_desc varchar(500),
    poi_location varchar(50),
    PRIMARY KEY (poi_id)
 );

 CREATE TABLE IF NOT EXISTS cost (
    cost_id int AUTO_INCREMENT,
    cost_name varchar(50),
    cost_cost double(7,2),
    cost_deviza char(3) NULL,
    PRIMARY KEY (cost_id)
 );

 CREATE TABLE IF NOT EXISTS alert (
    alert_id int,
    alert_date datetime,
    alert_active boolean,
    alert_travel_id int,
    PRIMARY KEY (alert_id),
    FOREIGN KEY (alert_travel_id) REFERENCES travel(travel_id)
 );

 CREATE TABLE IF NOT EXISTS diary (
    diary_id int AUTO_INCREMENT,
    diary_date date,
    diary_duration int,
    diary_activity varchar(50),
    diary_desc varchar(500) NULL,
    diary_travel_id int,
    diary_cost_id int,
    diary_poi_id int,
    diary_photo varchar(100),
    PRIMARY KEY (diary_id),
    FOREIGN KEY (diary_travel_id) REFERENCES travel(travel_id),
    FOREIGN KEY (diary_cost_id) REFERENCES cost(cost_id),
    FOREIGN KEY (diary_poi_id) REFERENCES poi(poi_id)
 );

 CREATE TABLE IF NOT EXISTS package_parc_ref (
    package_parc varchar(50),
    package_parc_weight double(3,2) NULL,
    PRIMARY KEY (package_parc)
 );

 CREATE TABLE markers (
 id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
 name VARCHAR( 60 ) NOT NULL ,
 address VARCHAR( 80 ) NOT NULL ,
 lat FLOAT( 10, 6 ) NOT NULL ,
 lng FLOAT( 10, 6 ) NOT NULL ,
 type VARCHAR( 30 ) NOT NULL
) ENGINE = MYISAM ;


/* Insertek */
INSERT INTO travel ( travel_name,
                     travel_start,
                     travel_end,
                     travel_type,
                     travel_data_1,
                     travel_data_2,
                     travel_data_3,
                     travel_desc) 
            VALUES ( "Test travel name",
                     "Test travel start",
                     "Test travel end",
                     "Test travel type",
                     "Test travel data1",
                     "Test travel data2",
                     "Test travel data3",
                     "Test travel desc");

INSERT INTO markers (name, address, lat, lng, type) VALUES ('Pan Africa Market', '1521 1st Ave, Seattle, WA', '47.608941', '-122.340145', 'restaurant');
INSERT INTO markers (name, address, lat, lng, type) VALUES ('Buddha Thai & Bar', '2222 2nd Ave, Seattle, WA', '47.613591', '-122.344394', 'bar');
INSERT INTO markers (name, address, lat, lng, type) VALUES ('The Melting Pot', '14 Mercer St, Seattle, WA', '47.624562', '-122.356442', 'restaurant');
INSERT INTO markers (name, address, lat, lng, type) VALUES ('Ipanema Grill', '1225 1st Ave, Seattle, WA', '47.606366', '-122.337656', 'restaurant');
INSERT INTO markers (name, address, lat, lng, type) VALUES ('Sake House', '2230 1st Ave, Seattle, WA', '47.612825', '-122.34567', 'bar');
INSERT INTO markers (name, address, lat, lng, type) VALUES ('Crab Pot', '1301 Alaskan Way, Seattle, WA', '47.605961', '-122.34036', 'restaurant');
INSERT INTO markers (name, address, lat, lng, type) VALUES ("Mama\'s Mexican Kitchen", '2234 2nd Ave, Seattle, WA', '47.613975', '-122.345467', 'bar');
INSERT INTO markers (name, address, lat, lng, type) VALUES ('Wingdome', '1416 E Olive Way, Seattle, WA', '47.617215', '-122.326584', 'bar');
INSERT INTO markers (name, address, lat, lng, type) VALUES ('Piroshky Piroshky', '1908 Pike pl, Seattle, WA', '47.610127', '-122.342838', 'restaurant');

INSERT INTO `diary`(`diary_id`, `diary_date`, `diary_duration`, `diary_activity`, `diary_desc`, `diary_travel_id`, `diary_cost_id`, `diary_poi_id`, `diary_photo`) VALUES (1,'10-10-2022',5,'Activity','diary desc',1,1,1,'teszt fotó')




/* Selectek */
SELECT * FROM travels;