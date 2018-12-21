<?php 
class GeocodeService {
	private $key;

	public function __construct($key) {
		$this->key = $key;	
	}

	public function searchAddressGeolocation($address){
 
		$urlAdressParam = str_replace (" ", "+", urlencode($address->getFullAddress()));
		$url = "https://maps.googleapis.com/maps/api/geocode/json?address={$urlAdressParam}&key={$this->key}";

		$reponse = $this->requestGeolocation($url);

		// If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
		if ($response['status'] != 'OK') {
			$this->throwError($response);
		}

		$lat = $response['results'][0]['geometry']['location']['lat'];
		$lng = $response['results'][0]['geometry']['location']['lng'];

		return new Geolocation( $lat, $lng );	 
	}

	private function requestGeolocation($url) {
		$ch = curl_init();
	   	curl_setopt($ch, CURLOPT_URL, $url);
	   	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	   	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	   	return json_decode(curl_exec($ch), true);
	}

	private function throwError($error) {
		if( $error['error_message'] && $response['status'] == "OVER_QUERY_LIMIT") {
    		throw new ErrorException("{$response['status']} -> {$response['error_message']}", 1);	
   		} else if( $error['error_message'] ) {
    		throw new Exception("{$response['status']} -> {$response['error_message']}", 1);	
   		} else {
   			throw new Exception("{$response['status']} -> endereço não reconhecido", 1);
   		}
	}
}
?>