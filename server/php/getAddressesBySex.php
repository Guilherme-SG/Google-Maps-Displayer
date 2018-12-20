<?php
include "lib/PHP-MySql/autoloader.php";

$sex = json_decode(file_get_contents("php://input"));	

$config = new MySqlConfig('localhost', 'root', 'usbw', 'db_exatas_mapas', 'utf8');$crud = new MySqlCRUD($config);

// This method return false or a 2D associative array
// register x field
$fields = ["rua", "nr", "complemento", "bairro", "cidade", "uf", "cep", "lat", "lng"];
$result = $crud->read("consumidores2", "where lat is not null and lng is not null and sexo = '{$sex}'", $fields);

echo json_encode($result);