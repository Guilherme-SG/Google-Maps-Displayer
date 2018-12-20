class View {

	constructor( element ) {
		this._element = element
	}

	_template( model ) {

	}

	update( model ) {
		this._element.innerHTML = this._template( model )
	}
}