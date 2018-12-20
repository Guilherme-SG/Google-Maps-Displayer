<?php
include "lib/PHP-MySql/autoloader.php";

$borought = json_decode(file_get_contents("php://input"));	

$config = new MySqlConfig('localhost', 'root', 'usbw', 'db_exatas_mapas', 'utf8');
$crud = new MySqlCRUD($config);

$fields = ["rua", "nr", "complemento", "bairro", "cidade", "uf", "cep", "lat", "lng"];
$result = $crud->read("consumidores2", "where lat is not null and lng is not null and bairro like '%{$borought}%'", $fields);

echo json_encode($result);