class PaginationView extends View {

	constructor( element ) {
		super( element )		
		this.currentPage = -1
	}

	_template( model ) {
		if( model.length == 1 ) {
			return `
				<ul class="pagination">
					<li class='page-item current-page active'>
						<a class='page-link' href='javascript:controller.pagination(0)'>1</a>
					</li>
				</ul>
			`
		}

		return `
			<ul class="pagination my-0">
				<li id='previous-page' class='page-item' onclick="controller.previusPage()">
		    		<a class='page-link' href='javascript:void(0)' aria-label=Next>Anterior</span></a>
		    	</li>
				${ model.map( ( a, index ) => {
					if ( index == 0 ) {
						return `							
					    	<li class='page-item current-page active'>
								<a class='page-link' href='javascript:controller.pagination(0)'>1</a>
							</li>
						`
					}

					return `
					<li class='page-item current-page'>
						<a class='page-link' href='javascript:controller.pagination(${index})'> ${index + 1}</a>
					</li>

				`}).join('')}
				<li id='next-page' class='page-item' onclick="controller.nextPage( this )">
		    		<a class='page-link' href='javascript:void(0)' aria-label=Next>Próximo</span></a>
		    	</li>
			</ul>
		`
	}
}