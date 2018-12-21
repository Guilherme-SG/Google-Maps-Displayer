<?php 
// Inclua esse arquivo onde deseja obter a chave da api
// acesse a propriedade $apikey->key, para obter a string da chave
$apikey = json_decode(file_get_contents("../server/json/key.json")); 