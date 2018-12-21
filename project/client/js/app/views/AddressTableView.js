class AddressTableView extends View {

	constructor( element ) {
		super( element )
	}

	_template( model ) {
		return `
		<div class='table-responsive'>
			<table class='table table-hover table-bordered table-sm'>
				<thead>
					<th class="text-center align-middle">Rua</th>
					<th class="text-center align-middle">Nº da rua</th>
					<th class="text-center align-middle">Complemento</th>
					<th class="text-center align-middle">Bairro</th>
					<th class="text-center align-middle">Cidade</th>
					<th class="text-center align-middle">UF</th>
					<th class="text-center align-middle">CEP</th>
				</thead>
				<tbody>
					${model.addresses.map( address => `
						<tr scope="row">
							<td class="text-center align-middle">${address.streetName}</td>
							<td class="text-center align-middle">${address.streetNumber}</td>
							<td class="text-center align-middle">${address.complement}</td>
							<td class="text-center align-middle">${address.borough}</td>
							<td class="text-center align-middle">${address.city}</td>
							<td class="text-center align-middle">${address.uf}</td>
							<td class="text-center align-middle">${address.cep}</td>
						</tr>
					`).join( '' )}
				</tbody>
			</table>
		</div>
		`
	}
}