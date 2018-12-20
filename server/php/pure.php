<meta charset="utf-8">
<?php
include "lib/PHP-MySql/autoloader.php";	
include "models/Address.class.php";
include "models/Geolocation.class.php";
include "dao/AddressDao.class.php";
include "services/GeocodeService.class.php";
include "services/AddressFactory.class.php";

set_time_limit(0);

$config = new MySqlConfig('localhost', 'root', 'usbw', 'db_exatas_mapas', 'utf8');
$dao = new AddressDao($config);

$service = new GeocodeService();

function update($dao, $service) {
	$addresses = $dao->getAddressesWithoutGeolocation();

	if(count($addresses) == 0 ) {
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
		} catch (Exception $e) {
			// Impede que o script tente encontrar a geolocalização desse endereço em consultas futuras
			$result = $dao->setAddressAsNotFound($address);
			echo "Não foi possível atualizar o endereço '{$address->getFullAddress()}'<br>";
			echo $e->getMessage();		
			echo "<br><br><br>";
		}
	}
}

function dos($dao, $service) {
	echo "Start new wave<br><hr>";
	update($dao, $service);
	echo "<br>End wave<br><hr>";
	sleep(30);
	dos($dao, $service);
}

dos($dao, $service);