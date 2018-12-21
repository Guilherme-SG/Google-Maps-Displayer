<?php 
class AddressDao {
	private $crud;

	public function __construct($config) {
		$this->crud = new MySqlCRUD($config);
	}

	public function updateGeolocation($address) {
		// Atualiza os campos lat e lng nos endereços que corresponda precisamente
		// as informações contidas no objeto address
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
		// Atualiza o campo geolocalizacao_encontravel nos endereços que corresponda precisamente
		// as informações contidas no objeto address
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

	public function getAddressesWithoutGeolocation($limit) {
		// Campos a serem buscados
		$fields = ["rua", "nr", "complemento", "bairro", "cidade", "uf", "cep", "lat", "lng"];

		/*Busca endereços que ainda estão sem lat e lng, 
		e não falharam ao tentar obter essas informações anteriormente.
		Serão retornados os primeiros $limit endereços encotrados
		*/
		$clausule = "where lat is null and lng is null and geolocalizacao_encontravel = 1 LIMIT {$limit}";	

		$results = $this->crud->read("consumidores2", $clausule, $fields);

		$addresses = [];

		foreach ($results as $address) {
			// Cria um objeto Address a partir dos dados do array			
			$addresses[] = AddressFactory::createInstance($address);
		}

		return $addresses;
	}

}

?>