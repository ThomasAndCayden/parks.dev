<?php 
require 'Park.php';


// Park::count();

$park = new Park();
$park->name = "Yeah";
$park->location = "Yes";
$park->dateEstablished = "1999-01-01";
$park->areaInAcres = 11111;
$park->description = "asdklfasd;l";
$park->insert();

echo $park->id;
?>