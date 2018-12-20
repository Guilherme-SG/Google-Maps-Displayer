<?php 
class AddressDao {
	private $crud;

	public function __construct($config) {
		$this->crud = new MySqlCRUD($config);
	}

	public function updateGeolocation($address) {
		$data = [
			"lat" => $address->getGeolocation()->getLat(),
			"lng" => $address->getGeolocation()->getLng(),
		];

		$clausule = "where rua = '{$address->getStreetName()}'"
		." and nr = '{$address->getStreetNumber()}'"
		." and complemento = '{$address->getComplement()}'"
		." and bairro = '{$address->getBorough()}'"
		." and cidade = '{$address->getCity()}'"
		." and uf = '{$address->getUf()}'"
		." and cep = '{$address->getCep()}'";


		return $this->crud->update("consumidores2", $data, $clausule);
	}

	public function setAddressAsNotFound($address) {
		$data = [ "geolocalizacao_encontravel" => 0 ];

		$clausule = "where rua = '{$address->getStreetName()}'"
		." and nr = '{$address->getStreetNumber()}'"
		." and complemento = '{$address->getComplement()}'"
		." and bairro = '{$address->getBorough()}'"
		." and cidade = '{$address->getCity()}'"
		." and uf = '{$address->getUf()}'"
		." and cep = '{$address->getCep()}'";


		return $this->crud->update("consumidores2", $data, $clausule);
	}

	public function getAddressesWithoutGeolocation() {
		$fields = ["rua", "nr", "complemento", "bairro", "cidade", "uf", "cep", "lat", "lng"];
		$clausule = "where lat is null and lng is null and geolocalizacao_encontravel = 1 LIMIT 0 , 200";		
		$results = $this->crud->read("consumidores2", $clausule, $fields);

		$addresses = [];

		foreach ($results as $address) {			
			$addresses[] = AddressFactory::createInstance($address);
		}

		return $addresses;
	}

}

?>