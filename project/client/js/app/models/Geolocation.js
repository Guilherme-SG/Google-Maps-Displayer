/**
 * Representing a geolocation
 * @public
 * @class
*/
class Geolocation {
	/**
	 * Create a geolocation.
	 * @constructor
	 * @param {float} lat - The street name.
	 * @param {float} streetNumber - The street number.
	 */
	constructor( lat, lng ) {
		this._lat = Number( lat )
		this._lng = Number( lng )
	}

	get lat() {
		return this._lat
	}

	get lng() {
		return this._lng
	}

	get location() {
		return {
			lat: this._lat,
			lng: this._lng
		}
	}

	set location( location ) {
		this._lat = location.lat
		this._lng = location.lng
	}
}