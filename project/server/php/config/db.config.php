<?php 
// Lembre-se de importar o autoloader em lib/PHP-MySql 
// antes de importar esse arquivo.

$host = "fdb24.awardspace.net";
$user = "2910127_mapas";
$password = "EX2018mp";
$database = "2910127_mapas";
$charset = "utf8"; // Recomendo usar utf8;

$mySqlConfig = new MySqlConfig($host, $user, $password, $database, $charset);