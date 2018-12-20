class HttpService {

	get( url, data ) {
		return fetch( url, {
			headers: { 'Content-type': 'application/json' },
			method: 'get'
		})
		.then( response => this._handleErros( response ))
		.then( response => response.json() )
	}

	post( url, data ) {
		return fetch( url, {
			headers: { 'Content-type': 'application/json' },
			method: 'post',
			body: JSON.stringify( data )
		})
		.then( response => this._handleErros( response ) )
		.then( response => response.json() )
	}

	_handleErros( response ) {
		if( !response.ok ) throw new Error( response.statusText )
		return response
	}
}