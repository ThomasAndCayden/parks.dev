<?php 
require_once 'db_connection.php';

$dropNationalParksTable = 'DROP TABLE IF EXISTS national_parks';
$connection->exec($dropNationalParksTable);

$createNationalParksTable = 'CREATE TABLE IF NOT EXISTS national_parks (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name varchar(150) NOT NULL,
	location varchar(150) NOT NULL,
	date_established date NOT NULL,
	area_in_acres double NOT NULL,
	description varchar(1000) NOT NULL, 
	PRIMARY KEY (id)
)';


$connection->exec($createNationalParksTable);

?>