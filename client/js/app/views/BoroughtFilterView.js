class BoroughtFilterView extends View {

	constructor( element ) {
		super( element )
	}

	_template( model ) {
		return`
			<input class="form-control" type='text' placeholder='Digite o nome do bairro'>
		`
	}
}