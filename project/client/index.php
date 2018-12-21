<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Google Maps</title>
	<meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">	
</head>
<body>
	<header class="container mb-5">		
		<h1 class="text-center">Visualize endereços pelo mapa</h1>
	</header>

	<main class="container mb-auto">
		<div class="row">
			<div class="col-sm-12 col-md-6">	
				<form id="filterForm" class="form-inline" onsubmit="controller.searchAddresses( event )">
	  				<label>Buscar: </label>		
		  			<div class="form-group">
						<select id="filterMode" class="form-control col-xs-2 col-sm-2" 
							onchange="controller.changeFilter( event )">
							<option value="0">Todos</option>
							<option value="1">Por sexo</option>
							<option value="2">Por bairro</option>
						</select>
					</div>

					<!-- View é carregada para exibir a opção de filtro -->
					<div id="filterSearch" class="form-group mx-sm-3 mb-5"></div>							
						
					<!-- Clique aqui depois de escolher os filtros -->
	        		<button class="btn btn-default" type="submit">
	        			<i class="glyphicon glyphicon-search"></i>
	        		</button>
				</form>
			</div>

			<div class="col-sm-12 col-md-6">
				<form class="form-inline pull-right">
					<label>Mostrar endereços</label>
					<!-- Adicione mais options para controlar a quantidade de itens por páginas.
						 O controller se encarrega de fazer a lógica para novas opções
					 -->
					<select id="paginationSelector" class="custom-select custom-select-sm form-control form-control-sm" 
						onchange="controller.changeItensPerPage( event )">
						<option>10</option>
						<option>20</option>
						<option>50</option>
						<option>100</option>
					</select>	
				</form>
			</div>			
		</div>
		
 		<div class="row">
 			<br>
 			<!-- O controller gera a tabela de endereços e a coloca aqui -->
 			<div id="addressTableView"></div>	
 		</div>

 		<div class="row" >
 			<div class="col-md-6 col-sm-12">
				<!-- O controller gera a páginação e o coloca aqui -->
				<div id="paginationView" style="vertical-align: middle"></div>	 				
 			</div>
 			<div id="btnCreateMap"
 				class="col-md-6 col-sm-12 mh-100s" style="vertical-align: top; display: none;">
 				<button 
 					class="btn btn-success col-md-3 pull-right align-middle" 
 					onclick="controller.createMap()">
 					<i class="fas fa-search-location"></i>
 					Gerar mapa
 				</button>
 			</div>
		</div>
	</main>	

	<div id="map"></div>

	<!-- Scripts do Bootstrap -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  	<!-- Scripts do Google Api -->
	<script src="https://maps.googleapis.com/maps/api/js?key=<?php 
		include "../server/php/config/getAPIKey.php"; 
		echo $apikey->key;
	?>"></script>
	<script src="js/app/lib/markerclusterer.js"></script>

	<!-- Scripts do projeto -->
	<script src="js/app/models/GoogleMap.js"></script>
	<script src="js/app/models/Address.js"></script>	
	<script src="js/app/models/AddressList.js"></script>
	<script src="js/app/models/Geolocation.js"></script>			
	<script src="js/app/models/Pagination.js"></script>			
	<script src="js/app/dao/AddressDao.js"></script>
	<script src="js/app/views/View.js"></script>
	<script src="js/app/views/AddressTableView.js"></script>
	<script src="js/app/views/SexFilterView.js"></script>
	<script src="js/app/views/BoroughtFilterView.js"></script>
	<script src="js/app/views/NoFilterView.js"></script>
	<script src="js/app/views/PaginationView.js"></script>
	<script src="js/app/services/AddressFactory.js"></script>
	<script src="js/app/services/HttpService.js"></script>
	<script src="js/app/controllers/AddressController.js"></script>

	<!-- Controller que comanda a página -->
	<script type="text/javascript">
		let controller = new AddressController()
	</script>

</body>
</html>