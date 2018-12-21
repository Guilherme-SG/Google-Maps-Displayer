class AddressList {
	/**
	 * Create a AddresList.
	 * @constructor
	 *
	*/
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
		/*Retorna uma cópia sem a referencia do array, 
		para que manipulações externas não afetem o array original*/
		return [].concat( this._addresses )
	}


}