class GoogleMap {

	constructor( map ) {
		this._map = map
		this._markers = []
	}

	get markers() {
		return [].concat( this._markers )
	}

	addMarkers( addresses ) {
		addresses.forEach( address => this.addMarker( address ) )
	}

	addMarker( address ) {
		let map = this._map

		let marker = new google.maps.Marker({
			position: address.geolocation.location,
			map: map
		})

		let contentString = `			
			<div jstcache="33" class="poi-info-window gm-style">
				<div jstcache="2"> 			
					<div jstcache="4" jsinstance="0" class="address-line full-width" 
						jsan="7.address-line,7.full-width">
						${address.streetName}, ${address.streetNumber}</div>
					<div jstcache="4" jsinstance="2" class="address-line full-width" 
						jsan="7.address-line,7.full-width">${address.cep}</div>
					<div jstcache="4" jsinstance="2" class="address-line full-width" 
						jsan="7.address-line,7.full-width">${address.city} - ${address.uf}</div>
				</div>
			</div>
		`

		let infowindow = new google.maps.InfoWindow({
			content: contentString
		});

		marker.addListener('click', function() {
   			infowindow.open( map, marker );
  		})

		this._markers.push ( marker )
	}


	clusterization() {
		new MarkerClusterer(this._map, this._markers,
            {imagePath: 'img/m'})
	}
}