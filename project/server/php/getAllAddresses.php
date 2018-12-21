<?php
// Importa a configuração do banco de dados
include "lib/PHP-MySql/autoloader.php";	
include "config/db.config.php";

$crud = new MySqlCRUD($mySqlConfig);
$fields = ["rua", "nr", "complemento", "bairro", "cidade", "uf", "cep", "lat", "lng"];
$result = $crud->read("consumidores2", "where lat is not null and lng is not null", $fields);

// Retorna um array com os endereços encontrados
echo json_encode($result);