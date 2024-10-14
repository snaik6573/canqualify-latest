    function initializeMap(lat, long, updateMap) {
	var latlng = new google.maps.LatLng(lat, long);
	var map = new google.maps.Map(document.getElementById('map'), {
	  center: latlng,
	  zoom: 3
	});

	var geocoder = new google.maps.Geocoder();

	var marker = new google.maps.Marker({ 
	  map: map,
	  //position: latlng,
	  draggable: true,
	  anchorPoint: new google.maps.Point(0, -29)
	});

	var infowindow = new google.maps.InfoWindow();

	if(updateMap) {
	var searchInput = document.getElementById('searchInput');
	//map.controls[google.maps.ControlPosition.TOP_LEFT].push(searchInput);

	geocoder.geocode({'address': searchInput.value}, function(results, status) {
	    infowindow.close();
	    marker.setVisible(false);
	    if (status == google.maps.GeocoderStatus.OK) {
	      if (results[0]) {
		marker.setPosition(results[0].geometry.location);
		map.setCenter(results[0].geometry.location);
		marker.setVisible(true);

		//bindDataToForm(results[0].formatted_address, results[0].geometry.location.lat(), results[0].geometry.location.lng());

		infowindow.setContent(results[0].formatted_address);
		infowindow.open(map, marker);
	      }
	    }
	});

	var autocomplete = new google.maps.places.Autocomplete(searchInput);

	autocomplete.bindTo('bounds', map);
	autocomplete.addListener('place_changed', function() {
	    infowindow.close();
	    marker.setVisible(false);
	    var place = autocomplete.getPlace();
	    if (!place.geometry) {
		window.alert("Autocomplete's returned place contains no geometry");
		return;
	    }
	    // If the place has a geometry, then present it on a map.
	    if (place.geometry.viewport) {
		map.fitBounds(place.geometry.viewport);
	    } else {
		map.setCenter(place.geometry.location);
		map.setZoom(17);
	    }
	   
	    marker.setPosition(place.geometry.location);
	    marker.setVisible(true);
	
	    bindDataToForm(place.formatted_address,place.geometry.location.lat(),place.geometry.location.lng());
	    infowindow.setContent(place.formatted_address);
	    infowindow.open(map, marker);
	});

	// this function will work on marker move event into map 
	google.maps.event.addListener(marker, 'dragend', function() {
	    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
	    if (status == google.maps.GeocoderStatus.OK) {
	      if (results[0]) {	
		  bindDataToForm(results[0].formatted_address,marker.getPosition().lat(),marker.getPosition().lng());
		  infowindow.setContent(results[0].formatted_address);
		  infowindow.open(map, marker);
	      }
	    }
	    });
	});
	} //if updateMap
    }

    function bindDataToForm(address,lat,lng){
	document.getElementById('searchInput').value = address;
	document.getElementById('latitude').value = lat;
	document.getElementById('longitude').value = lng;
    }

    function updateMap() {
	var lat = document.getElementById('latitude').value;
	var long = document.getElementById('longitude').value;
	initializeMap(lat, long);
    }

    if(document.getElementById('map')) {
	var lat = 40.478245001658;
	var long = -99.387606240625;
	var updateMap = false;

	if(document.getElementById('latitude')!=null && document.getElementById('longitude')!=null) {
		lat = document.getElementById('latitude').value;
		long = document.getElementById('longitude').value;
		updateMap = true;
	}
	google.maps.event.addDomListener(window, 'load', initializeMap(lat, long, updateMap));
    }
