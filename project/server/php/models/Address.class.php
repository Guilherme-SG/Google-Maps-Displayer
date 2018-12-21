<?php
class Address {
	public function __construct( $streetName,
		$streetNumber,
		$complement,
		$borough,
		$city,
		$uf,
		$cep,
		$geolocation 
	) {
		$this->streetName = $streetName;
		$this->streetNumber = $streetNumber;
		$this->complement = $complement;
		$this->borough = $borough;
		$this->city = $city;
		$this->uf = $uf;
		$this->cep = $cep;
		$this->geolocation = $geolocation;
	}

	public function getStreetName() {
		return $this->streetName;
	}

	public function getStreetNumber() {
		return $this->streetNumber;
	}

	public function getComplement() {
		return $this->complement;
	}

	public function getBorough() {
		return $this->borough;
	}

	public function getCity() {
		return $this->city;
	}

	public function getUf() {
		return $this->uf;
	}

	public function getCep() {
		return $this->cep;
	}

	public function getGeolocation() {
		return $this->geolocation;
	}

	public function setGeolocation($geolocation) {
		$this->geolocation = $geolocation;
	}

	public function getFullAddress() {
		return "{$this->streetName}, {$this->streetNumber} {$this->borough} {$this->cep} {$this->city} - {$this->uf}";
	}
}