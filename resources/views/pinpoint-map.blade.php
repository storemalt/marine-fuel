@extends('layouts.app')

@section('css')
  <style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
      height: 100%;
    }
  </style>
@endsection

@section('content')
  <div class="container">
    <div class="row mb-4">
      <div class="col-12" style="height: 30rem;">
        <div id="map"></div>
      </div>
    </div>

    <form action="{{$action}}" method="post">
      @csrf

      <div class="form-group">
        <label for="duration">Name of Location</label>
        <input type="text"
               id="location_name"
               class="form-control"
               placeholder="Any short name"
               name="location_name"
               value="{{ old('location_name') }}"
               required>
        @error('location_name')
        <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="duration">Expires in how many hours?</label>
        <input type="text"
               id="duration"
               class="form-control"
               placeholder="(hours) eg: 1"
               name="duration"
               value="{{ old('duration') }}"
               required>
        @error('duration')
          <div class="text-danger">{{ $message }}</div>
        @enderror
        <small id="durationHelp" class="form-text text-muted">
          Determines how many hours we will save location information
          and show on map.
        </small>
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
      <input type="hidden" id="current_location" name="current_location">
    </form>
    <input type="hidden" id="stored_locations" name="stored_locations" value="{{$locations}}">
  </div>
@endsection

@section('scripts')
  <script>
    // Note: This example requires that you consent to location sharing when
    // prompted by your browser. If you see the error "The Geolocation service
    // failed.", it means you probably did not give permission for the browser to
    // locate you.
    let map, infoWindow;

    // retrieved stored locations from cache
    const storedLocations = document.getElementById('stored_locations');
    let locations = JSON.parse(storedLocations.value);
    console.log(locations);

//    var locations = [
//      {
//        label: 'test1',
//        lat: 1.2816108,
//        lng: 103.8818392,
//      },
//      { lat: 1.2827198, lng: 103.8823256, label: 'test2' },
//      { lat: 1.2837072, lng: 103.8824288, label: 'test3' },
//      { lat: 1.2682561, lng: 103.8625758, label: 'test4' },
//      { lat: 1.2682561, lng: 103.8625758 },
//      { lat: 1.2619037, lng: 103.8461269 },
//      { lat: 1.2619037, lng: 103.8461269 },
//      { lat: 1.2688303, lng: 103.7757082 },
//      { lat: 1.2688303, lng: 103.7757082 },
//      { lat: 1.2688303, lng: 103.7757082 },
//      { lat: 1.2688303, lng: 103.7757082 },
//      { lat: -37.765015, lng: 145.133858 },
//      { lat: -37.770104, lng: 145.143299 },
//      { lat: -37.773700, lng: 145.145187 },
//      { lat: -37.774785, lng: 145.137978 },
//      { lat: -37.819616, lng: 144.968119 },
//      { lat: -38.330766, lng: 144.695692 },
//      { lat: -39.927193, lng: 175.053218 },
//      { lat: -41.330162, lng: 174.865694 },
//      { lat: -42.734358, lng: 147.439506 },
//      { lat: -42.734358, lng: 147.501315 },
//      { lat: -42.735258, lng: 147.438000 },
//      { lat: -43.999792, lng: 170.463352 },
//    ];
    //    console.log(locations);
    //    debugger;

    function initMap() {
      map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 1.286268, lng: 103.7929168 },
        zoom: 6,
      });

      // Create an array of alphabetical characters used to label the markers.
      var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

      // Add some markers to the map.
      // Note: The code uses the JavaScript Array.prototype.map() method to
      // create an array of markers based on a given "locations" array.
      // The map() method here has nothing to do with the Google Maps API.
      var markers = locations.map(function (location, i) {
        return new google.maps.Marker({
          position: location,
//          label: labels[i % labels.length],
          label: location.label,
        });
      });

      // Add a marker clusterer to manage the markers.
      var markerCluster = new MarkerClusterer(
        map,
        markers,
        { imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m' },
      );

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
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
      infoWindow.setPosition(pos);
      infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
      infoWindow.open(map);
    }
  </script>
  <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
  </script>
  <script async defer
          src="https://maps.googleapis.com/maps/api/js?key={{config('marine.google_map_api_key')}}&callback=initMap">
  </script>
@endsection
