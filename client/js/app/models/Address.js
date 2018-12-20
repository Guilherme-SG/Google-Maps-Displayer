class Address {

	constructor( streetName,
		streetNumber,
		complement,
		borough,
		city,
		uf,
		cep,
		geolocation 
	) {
		this._streetName = streetName
		this._streetNumber = streetNumber
		this._complement = complement
		this._borough = borough
		this._city = city
		this._uf = uf
		this._cep = cep
		this._geolocation = geolocation

		Object.freeze( this )
	}

	get streetName() {
		return this._streetName
	}

	get streetNumber() {
		return this._streetNumber
	}

	get complement() {
		return this._complement
	}

	get borough() {
		return this._borough
	}

	get city() {
		return this._city
	}

	get uf() {
		return this._uf
	}

	get cep() {
		return this._cep
	}

	get geolocation() {
		return this._geolocation
	}

	get fullAddress() {
		return `${this._streetName}, ${this._streetNumber} ${this._borough} ${this._cep} ${this._city} - ${this._uf}`
	}
}