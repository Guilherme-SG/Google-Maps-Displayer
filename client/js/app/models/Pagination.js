class Pagination {

	constructor( addressList, addressesPerPage ) {
		this._addressesPerPage = addressesPerPage
		this._addressList = addressList
		this._pages = []
	}

	get pages() {
		return [].concat( this._pages )
	}

	get addressesPerPage() {
		return this._addressesPerPage
	}

	set addressesPerPage( number ) {
		this._addressesPerPage = number
	}

	makePages() {
		let addresses = this._addressList.addresses

		while ( addresses.length > 0 ) {
			this._pages.push( addresses.splice( 0, this._addressesPerPage ) )
		}

		return [].concat( this._pages )
	}

	getPage( index ) {
		return [].concat( this._pages[index] )
	}
}