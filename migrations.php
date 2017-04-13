<?php 
require_once 'db_connection.php';

// Create the query and assign to var 
$createUsersTable = 'CREATE TABLE if not exists users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    email VARCHAR(240) NOT NULL,
    name VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
)';

$connection->exec($createUsersTable);

$createRolesTable = 'CREATE TABLE if not exists roles (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name varchar(150),
    PRIMARY KEY (id)
)';

$connection->exec($createRolesTable);

?>