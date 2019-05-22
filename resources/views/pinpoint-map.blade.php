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

    function initMap() {
      if (locations.length > 0) {
        console.log(locations);
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
    }
  </script>
  <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
  </script>
  <script async defer
          src="https://maps.googleapis.com/maps/api/js?key={{config('marine.google_map_api_key')}}&callback=initMap">
  </script>
@endsection
