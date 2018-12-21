<?php
include "lib/PHP-MySql/autoloader.php";
include "config/db.config.php";

$borought = json_decode(file_get_contents("php://input"));	

$crud = new MySqlCRUD($mySqlConfig);
$fields = ["rua", "nr", "complemento", "bairro", "cidade", "uf", "cep", "lat", "lng"];
$result = $crud->read("consumidores2", "where lat is not null and lng is not null and bairro like '%{$borought}%'", $fields);

// Retorna um array com os endereços encontrados
echo json_encode($result);