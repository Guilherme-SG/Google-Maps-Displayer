<?php 
class AddressFactory {
	public static function createInstance( $data ) {
		return new Address( $data["rua"],
			$data["nr"],
			$data["complemento"],
			$data["bairro"],
			$data["cidade"],
			$data["uf"],
			$data["cep"],
			new Geolocation( $data["lat"], $data["lng"] )
			);
	}
}
?>