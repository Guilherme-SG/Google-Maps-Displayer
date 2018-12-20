class AddressList {

	constructor() {
		this._addresses = []
	}

	add( address ) {
		this._addresses.push( address )
	}

	getRandomAddress() {
		return this._addresses[Math.floor( Math.random() * this._addresses.length )]
	}

	get addresses() {
		return [].concat( this._addresses )
	}


}