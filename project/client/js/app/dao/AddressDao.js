class AddressDao {
	constructor() {
		this._http = new HttpService();
	}
	
	getAll() {
		return this._getAddresses( "../server/php/getAllAddresses.php" )
			.catch( err => {
				console.log( err )
				throw new Error( 'Não foi possível obter os endereços' )
			})
	}

	getAddressesBySex( sex ) {
		return this._getAddresses( "../server/php/getAddressesBySex.php", sex )
			.catch( err => {
				console.log( err )
				throw new Error( 'Não foi possível obter os endereços filtrados por sexo' )
			})	
	}

	getAddressesByBorough( borough ) {
		return this._getAddresses( "../server/php/getAddressesByBorough.php", borough )
			.catch( err => {
				console.log( err )
				throw new Error( 'Não foi possível obter os endereços filtrados por bairro' )
			})	
	}

	_getAddresses( url, data ) {
		return new Promise( ( resolve, reject ) => {
			this._http
				.post( url, data )
				.then( response => resolve( 
					response.map( AddressFactory.createInstance ) 
					) 
				)									
		})
	}

}