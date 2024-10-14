function createMarker(map, infowindow, latlng, infoCnt, iconColor){
	var marker = new google.maps.Marker({
		position: latlng,
		icon: {
			  url: "//maps.google.com/mapfiles/ms/icons/"+iconColor+"-dot.png"
		},
		map: map
	});
	google.maps.event.addListener(marker, 'mouseover', function(event) { 
		infowindow.setContent(infoCnt);
		infowindow.open(map, marker);
	});		
	google.maps.event.addListener(marker, 'mouseout', function(event) { 
		infowindow.close();
	});
}

function addMarkerIndo(map, geocoder, infowindow, markers, iconColor) {
	for( i = 0; i < markers.length; i++ ) {
		if(markers[i][1]!=null && markers[i][2]!=null) {
			latlng = new google.maps.LatLng(markers[i][1], markers[i][2]);
			createMarker(map, infowindow, latlng, markers[i][3], iconColor);
		}
		else {
			geocoder.geocode({
				'address': markers[i][0]
			}, (function(markers, i) { return function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) {
					createMarker(map, infowindow, results[0].geometry.location, markers[i][3], iconColor);
				}
			}
			}}(markers, i)));
		}
	} //loop
}

function bindDataToForm(address,lat,lng){
	document.getElementById('searchInput').value = address;
	document.getElementById('latitude').value = lat;
	document.getElementById('longitude').value = lng;
}

function initializeMap() {
	var lat = 40.478245001658;
	var long = -99.387606240625;
	var updateLocationPage = false;
	var serachByloc = true;
	if(document.getElementById('latitude')!=null && document.getElementById('longitude')!=null) {
		updateLocationPage = true;
		lat = document.getElementById('latitude').value;
		long = document.getElementById('longitude').value;
		if(lat!='' && long!='' ) {
			var serachByloc = false;
		}
	}
	var latlng = new google.maps.LatLng(lat, long);
	var map = new google.maps.Map(document.getElementById('map'), {
		center: latlng,
		zoom: 3
	});

	var geocoder = new google.maps.Geocoder();
	var infowindow = new google.maps.InfoWindow();
	var infoCnt = '';

	if(updateLocationPage) {
		map.setZoom(8);
		var marker = new google.maps.Marker({ 
			map: map,
			//position: latlng,
			draggable: true,
			icon: {
				  url: "//maps.google.com/mapfiles/ms/icons/green-dot.png"
			},
			anchorPoint: new google.maps.Point(0, -29)
		});

		var searchInput = document.getElementById('searchInput');

		// Bias the SearchBox results towards current map's viewport.
		var searchBox = new google.maps.places.SearchBox(searchInput);
		map.addListener('bounds_changed', function() {
			searchBox.setBounds(map.getBounds());
		});

		//map.controls[google.maps.ControlPosition.TOP_LEFT].push(searchInput);
		if(serachByloc) {
			geocoder.geocode({'address': searchInput.value}, function(results, status) {
			marker.setVisible(false);
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) {
					marker.setPosition(results[0].geometry.location);
					marker.setVisible(true);
					map.setCenter(results[0].geometry.location);
					infoCnt = results[0].formatted_address;
				}
			}
			});
		}
		else {
			marker.setPosition(latlng);
			infoCnt = searchInput.value;
		}

		/*var autocomplete = new google.maps.places.Autocomplete(searchInput);
		autocomplete.bindTo('bounds', map);
		autocomplete.addListener('place_changed', function() {
			marker.setVisible(false);
			var place = autocomplete.getPlace();
			if (!place.geometry) {
				window.alert("Autocomplete's returned place contains no geometry");
				returns;
			}
			map.setCenter(place.geometry.location);
				 
			marker.setPosition(place.geometry.location);
			marker.setVisible(true);
	
			bindDataToForm(place.formatted_address,place.geometry.location.lat(),place.geometry.location.lng());
			infoCnt = place.formatted_address;
		});*/
		
		searchBox.addListener('places_changed', function() {
			map.setZoom(15);

			var places = searchBox.getPlaces();
			if (places.length == 0) {
				return;
			}

			places.forEach(function(place) {
				marker.setVisible(false);
				if (!place.geometry) {
					console.log("Returned place contains no geometry");
					return;
				}
				map.setCenter(place.geometry.location);					 
				marker.setPosition(place.geometry.location);
				marker.setVisible(true);
	
				bindDataToForm(place.formatted_address,place.geometry.location.lat(),place.geometry.location.lng());
				infoCnt = place.formatted_address;
			});
		});


		// this function will work on marker move event into map 
		google.maps.event.addListener(marker, 'dragend', function() {
		geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			if (results[0]) {	
				bindDataToForm(results[0].formatted_address,marker.getPosition().lat(),marker.getPosition().lng());
				infoCnt = results[0].formatted_address;
			}
		}
		});
		});

		google.maps.event.addListener(marker, 'mouseover', function(event) { 
			infowindow.setContent(infoCnt);
			infowindow.open(map, marker);
		});		
		google.maps.event.addListener(marker, 'mouseout', function(event) { 
			infowindow.close();
		});
	}
	else {
		if(typeof contractor_markers !== 'undefined') {
			addMarkerIndo(map, geocoder, infowindow, contractor_markers, 'green');
		}
		if(typeof client_markers !== 'undefined') {
			addMarkerIndo(map, geocoder, infowindow, client_markers, 'blue');
		}		
		//addMarkerIndo(map, geocoder, infowindow);
	}
}

if(document.getElementById('map')) {
	google.maps.event.addDomListener(window, 'load', initializeMap());
}

//2173 w kimber lane riverton utah 84065, united states
