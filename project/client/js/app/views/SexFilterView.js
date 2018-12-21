class SexFilterView extends View {

	constructor( element ) {
		super( element )
	}

	_template( model ) {
		return`
			<select class="form-control">
				<option disabled="true" selected="true" value=null>Escolha o sexo</option>
				<option value="M">Masculino</option>
				<option value="F">Feminino</option>
			</select>
		`
	}
}