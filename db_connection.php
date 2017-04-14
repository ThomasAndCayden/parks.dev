<?php 
require_once 'constants.php';
			
try {

	$connection = new PDO(
		'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, 
		DB_USER, 
		DB_PASSWORD
	);

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $connection;


} catch (PDOException $e) {
	// Exception
	// comes from exceptional. - Something you cannot control
    echo  $e->getMessage() .  PHP_EOL;
}

?>