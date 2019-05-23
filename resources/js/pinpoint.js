// Note: This example requires that you consent to location sharing when
// prompted by your browser. If you see the error "The Geolocation service
// failed.", it means you probably did not give permission for the browser to
// locate you.
let map, infoWindow;

// retrieved stored locations from cache
const storedLocations = document.getElementById('stored_locations');
let locations = JSON.parse(storedLocations.value);

function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: { lat: 1.286268, lng: 103.7929168 },
    zoom: 6,
  });

  if (locations.length > 0) {
    // Add some markers to the map.
    // Note: The code uses the JavaScript Array.prototype.map() method to
    // create an array of markers based on a given "locations" array.
    // The map() method here has nothing to do with the Google Maps API.
    var markers = locations.map(function (location, i) {
      return new google.maps.Marker({
        position: location,
        label: location.label,
      });
    });

    // Add a marker Cluster to manage the markers.
    var markerCluster = new MarkerClusterer(
      map,
      markers,
      { imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m' },
    );
  }

  infoWindow = new google.maps.InfoWindow;

  // Try HTML5 geolocation.
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (position) {
      let pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude,
      };

      // save to hidden input current coordinates of request
      const currentLocation = document.getElementById('current_location');
      currentLocation.value = JSON.stringify(pos);

      infoWindow.setPosition(pos);
      infoWindow.setContent('Location found.');
      infoWindow.open(map);
      map.setCenter(pos);
    }, function () {
      handleLocationError(true, infoWindow, map.getCenter());
    });
  }
  else {
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
  }

  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
      'Error: The Geolocation service failed.' :
      'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
  }
}
