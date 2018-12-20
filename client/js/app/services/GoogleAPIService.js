class GoogleAPIService {

	constructor() {
		this._geocoder = new google.maps.Geocoder()
		this._QUERIESPERSECOND = 50

		Object.freeze( this )
	}

	getGeocodeFromAdressesLimitedByQueriesPerSecond( addresses ) {		
		return new Promise( ( resolve, reject ) => {
			const intervalTimeInMiliseconds = 4 * 1000
			let results = []
			let isWaiting = false

			let interval = setInterval( () => {
				if ( !isWaiting ) {
					isWaiting = true

					this.getAllGeocodesFromAdresses( addresses.splice( 0, 50 ) )
						.then( addresses => {
							console.log(addresses)
							results.push( addresses ) 
							isWaiting = false
						})
						.catch( err => reject( err ) ) 
				}

				if ( addresses.length == 0 ) {
					clearInterval( interval )

					resolve( addresses.reduce( ( acc, cur ) => acc.concat( cur ), [] ) )
				}
			}, intervalTimeInMiliseconds )
		})
	}

	getAllGeocodesFromAdresses( addresses ) {
		return new Promise( ( resolve, reject ) => {
			const IntervalTimeInMiliseconds = 2 * 1000

			let promises = []

			let interval = setInterval( () => {
				promises.push( this.getGeocodeFromAddress( addresses.shift() ) )

				if ( addresses.length == 0 ) {
					clearInterval( interval )

					Promise
						.all( promises )
						.then( addresses => resolve( addresses.filter( address => 
							address.geolocation && 
							address.geolocation.lat && 
							address.geolocation.lng 
						) ) )
						.catch( err => reject( err ) )
				}
			}, IntervalTimeInMiliseconds )
		})	
	}

	getGeocodeFromAddress( address ) {
		if( !address instanceof Address ) {
			throw new Error( "Endereço inválido" )
		}

		return new Promise( ( resolve, reject ) => {
			console.log( address.fullAddress )
			this._geocoder.geocode({ address: `${address.fullAddress}, Brasil`, 'region': 'BR' }, 
				( results, status ) => {

				console.log( status, results )
				if ( status == google.maps.GeocoderStatus.OK ) {
					if ( results[0] ) {
						address.geolocation.location = results[0].geometry.location.toJSON()
						resolve( address )
					}
				}

				if ( status == "ZERO_RESULTS" ) {
					resolve( new Address() )
				}

				reject( "Não foi possível obter a geolocalização do endereço" )
			})	
		})
	}
}