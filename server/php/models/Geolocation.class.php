<?php 
class Geolocation {
	private $lat;
	private $lng;

	public function __construct($lat = null, $lng = null) {
		$this->lat = $lat;
		$this->lng = $lng;
	}

	public function getLat() {
		return $this->lat;
	}

	public function getLng() {
		return $this->lng;
	}

	public function setLocation( $lat, $lng ) {
		$this->lat = $lat;
		$this->lng = $lng;
	}
}
?>