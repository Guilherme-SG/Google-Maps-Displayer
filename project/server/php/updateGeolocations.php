<meta charset="utf-8">

<?php
include "lib/PHP-MySql/autoloader.php";	
include "config/db.config.php";
include "config/getAPIKey.php";
include "models/Address.class.php";
include "models/Geolocation.class.php";
include "dao/AddressDao.class.php";
include "services/GeocodeService.class.php";
include "services/AddressFactory.class.php";

// Permite que o script execute sem limite de execução
set_time_limit(0);

$dao = new AddressDao($mySqlConfig);

$service = new GeocodeService($apikey->key);

// Quanto maior o limite, mais endereços de uma vez ele busca, causando lentidão no banco.
// 1400 endereços é o máximo de endereços da cota diária para avaliação gratuita.
// Atualize sua conta do google para premium para extraploar esse limite.
$limit = 1400;

$addresses = $dao->getAddressesWithoutGeolocation($limit);

if(count($addresses) == 0 ) {
	echo "Sem endereços para buscar geolocalizações";
	exit();
}

foreach ($addresses as $address) {
	try {
		$address->setGeolocation($service->searchAddressGeolocation($address));

		if ( $address->getGeolocation()->getLat() && $address->getGeolocation()->getLng() ) {
			$result = $dao->updateGeolocation($address);
		} 

		if($result) {
			echo "Endereço '{$address->getFullAddress()}' foi atualizado com sucesso<br>";
		} else {
			echo "Não foi possível atualizar o endereço '{$address->getFullAddress()}'<br>";
		}
	} catch (ErrorException $e) {
		// Essa exceção será lançada quando a cota diária ou o limite de queries for atingido
		// a exceção será parada para evitar novas requisições em exito
		echo "Não foi possível atualizar o endereço '{$address->getFullAddress()}'<br>";
		echo $e->getMessage();	

		exit();

	} catch (Exception $e) {
		// Impede que o script tente encontrar a geolocalização desse endereço em consultas futuras
		$result = $dao->setAddressAsNotFound($address);

		echo "Não foi possível atualizar o endereço '{$address->getFullAddress()}'<br>";
		echo $e->getMessage();		
		echo "<br><br><br>";
	}
}