class AddressController {

	constructor() {
		let $ = document.querySelector.bind( document )

		this._filterModeInput = $( "#filterMode" )
		this._filterSearchInput = $( "#filterSearch" )

		this._sexFilterView = new SexFilterView( this._filterSearchInput  )
		this._boroughtFilterView = new BoroughtFilterView( this._filterSearchInput  )
		this._noFilterView = new NoFilterView( this._filterSearchInput )

		this._map = $( "#map" )
		this._googleMap = null

		this._addressList = new AddressList()
		this._addressView = new AddressView( $( "#addressView" ) )
		this._addressDAO = new AddressDao()

		this._paginationView = new PaginationView( $( "#paginationView" ) )
		this._pagination = null
		this._pagesToShow = 5

		this._paginationSelector = $( "#paginationSelector" )
		this._addressPerPage = Number( this._paginationSelector.value )


		this._googleApiService = new GoogleAPIService()
	}

	changeFilter() {
		switch ( this._filterModeInput.options.selectedIndex ) {
			case 0:
				this._noFilterView.update()
				break

			case 1:
				this._sexFilterView.update()
				break

			case 2:
				this._boroughtFilterView.update()
				break
			default:
				throw new Error( "Escolha uma opção de busca válida" )
				break
		}
	}

	searchAddresses( event ) {
		event.preventDefault()

		this._searchAddressesBySelectedFilter()
			.then( addresses => {
				this._addressList = new AddressList()
				addresses.forEach( address => this._addressList.add( address ) ) 

				this.makePagination()

				$( "#btnCreateMap" ).show()

			})
			.catch( err => console.log( err ) )
	}

	_searchAddressesBySelectedFilter() {
		let $ = document.querySelector.bind( document )

		switch ( this._filterModeInput.options.selectedIndex ) {
			case 0:
				return this._addressDAO.getAll()
				break

			case 1:
				return this._addressDAO.getAddressesBySex( $( "#filterSearch > select" ).value )
				break

			case 2:
				return this._addressDAO.getAddressesByBorough( $( "#filterSearch > input" ).value )
				break
			default:
				throw new Error( "Escolha uma opção de busca válida" )
				break
		}
	}		

	makePagination() {
		this._addressPerPage = Number( this._paginationSelector.value )

		this._pagination = new Pagination( this._addressList, this._addressPerPage )
		this._paginationView.update( this._pagination.makePages() )
		this.pagination( 0 )
	}

	pagination( index ) {	
		let paginationAddressList = new AddressList()
		this._pagination.getPage( index ).forEach( address => paginationAddressList.add( address ) )
		this._addressView.update( paginationAddressList )

		let totalPages = this._pagination.pages.length

		// Atualiza a navegação da paginação
  		this.displayPaginationItens( index, totalPages, this._pagesToShow )

		// Desativa o númerador atual
		$(".pagination li").removeClass('active') 

		// Ativa o número da página selecionada
		$(".pagination li.current-page:eq(" + ( index ) + ")").addClass('active')
	}

	nextPage() {
		// Função para navegar para próxima página quando o usuário clicnar no botão "próximo"
		
		// Identifica a página ativa
	  	let currentPage = $(".pagination li.active").index() - 1
	  	let totalPages = this._pagination.pages.length

		// Garante que a próxima página não excede o total de páginas
		if ( currentPage === totalPages ) {
	  		return false 
		} else {
	  		currentPage++

	  		// Desativa o númerador atual
			$(".pagination li").removeClass('active') 

	  		// Mostra as combinações da pagina
    		this.pagination( currentPage )

		  	// Ativa o número da página seguinte
			$(".pagination li.current-page:eq(" + ( currentPage  ) + ")").addClass('active')
		}
		
	}

	previusPage() {
		// Função para navegar para página anterior quando o usuário clicnar no botão "anterior"	 	
 		// Identifica a página ativa
	    let currentPage = $(".pagination li.active").index() - 1

	    let totalPages = this._pagination.pages.length

	    // Garante que a próxima página não excede o total de páginas
	    if (currentPage === 1) {
     		return false 
	    } else {
	    	currentPage-- 

	    	// Desativa o númerador atual
			$(".pagination li").removeClass('active') 

    		// Mostra as combinações da pagina
    		this.pagination( currentPage )

	    	// Ativa o número da página seguinte
			$(".pagination li.current-page:eq(" + ( currentPage ) + ")").addClass('active')
	    }
	}

	displayPaginationItens( currentPage, totalPages, totalPagesToShow ) {	
		let startPage, endPage
		if ( totalPages <= totalPagesToShow ) {
			// Mostra todas as páginas de navegação
	        startPage = 1
	        endPage = totalPages
	    } else {
	        // Calcula de onde começa até onde termina as páginas na navegação
	        if ( currentPage + 1 == totalPagesToShow ) {
	        	startPage = currentPage
	        	endPage = currentPage + totalPagesToShow - 1
	    	} 
	        else if ( currentPage < totalPagesToShow ) {
	        	startPage = 1
	            endPage = totalPagesToShow
	        } else if ( currentPage + totalPagesToShow - 1 >= totalPages ) {
	        	startPage = totalPages - totalPagesToShow + 1
	            endPage = totalPages
	        } else {
	        	startPage = currentPage
	            endPage = currentPage + totalPagesToShow - 1
	        }
   		}

	    // Mostra apenas as páginas dnetro do intervalo [startPage - , endPage[
		$(".pagination li.current-page:lt(" + ( startPage - 1 ) + ")").hide()
		$(".pagination li.current-page:gt(" + ( endPage - 1 ) + ")").hide() 
		$(".pagination li.current-page").slice( startPage - 1, endPage ).show() 	
	}

	changeItensPerPage() {
		if( this._addressList.addresses.length > 0 ) {
			this._addressPerPage = Number( this._paginationSelector.value )
			this.makePagination()
		}		
	}

	createMap() {
		// Revela o mapa
		this._map.style.display = "inline-block"

		this._googleMap = new GoogleMap( 
			new google.maps.Map( this._map, {
				zoom: 4,
				center: this._addressList.getRandomAddress().geolocation.location
			}) 	
		)

		this._googleMap.addMarkers( this._addressList.addresses	)

		this._googleMap.clusterization()

		$('html,body').animate({
        	scrollTop: $("#map").offset().top
   		}, 'slow')
	}

	
}