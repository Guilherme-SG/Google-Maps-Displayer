<?php 
class GeocodeService {
	public function searchAddressGeolocation($address){
 
	   $urlAdressParam = str_replace (" ", "+", urlencode($address->getFullAddress()));

	   $details_url = "https://maps.googleapis.com/maps/api/geocode/json?address="
	   .$urlAdressParam
	   ."&key=AIzaSyBCxZVYxgrPSJLIzXfY_8Ac5MhcI8VWxrQ";
	 
	   $ch = curl_init();
	   curl_setopt($ch, CURLOPT_URL, $details_url);
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	   $response = json_decode(curl_exec($ch), true);
	 
	   //var_dump($response);
	 
	   // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
	   if ($response['status'] != 'OK') {
	   		if( $response['error_message'] ) {
	    		throw new Exception("{$response['status']} -> {$response['error_message']}", 1);	
	   		} else {
	   			throw new Exception("{$response['status']} -> endereço não reconhecido", 1);
	   		}
	   }
	 
	    $lat = $response['results'][0]['geometry']['location']['lat'];
	    $lng = $response['results'][0]['geometry']['location']['lng'];
	 
	    return new Geolocation( $lat, $lng );
	 
	}
}
?>