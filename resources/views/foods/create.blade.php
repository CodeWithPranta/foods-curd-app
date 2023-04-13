@extends('layouts.app')

@section('content')
    <h1>Create Food Item</h1>

    <form action="{{ route('foods.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter description"></textarea>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" name="price" id="price" placeholder="Enter price">
        </div>

        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" class="form-control" name="location" id="location" placeholder="Enter location">
        </div>

        <div id="map" style="height: 400px;"></div>

        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

     {{-- <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initMap" async defer></script> --}}
     <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&callback=initMap&libraries=places" async defer></script>

     <script>
        function initMap() {
  const mapCenter = { lat: -34.397, lng: 150.644 };
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 8,
    center: mapCenter,
  });
  const marker = new google.maps.Marker({
    position: mapCenter,
    map,
    draggable: true,
  });
  google.maps.event.addListener(marker, "dragend", () => {
    const position = marker.getPosition();
    document.getElementById("latitude").value = position.lat();
    document.getElementById("longitude").value = position.lng();
  });

  const input = document.getElementById("location");
  const searchBox = new google.maps.places.SearchBox(input);

  map.addListener("bounds_changed", () => {
    searchBox.setBounds(map.getBounds());
  });

  let markers = [];
  searchBox.addListener("places_changed", () => {
    const places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    markers.forEach((marker) => {
      marker.setMap(null);
    });
    markers = [];

    const bounds = new google.maps.LatLngBounds();
    places.forEach((place) => {
      if (!place.geometry || !place.geometry.location) {
        console.log("Returned place contains no geometry");
        return;
      }

      const icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25),
      };

      markers.push(
        new google.maps.Marker({
          map,
          icon,
          title: place.name,
          position: place.geometry.location,
          draggable: true,
        })
      );

      if (place.geometry.viewport) {
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
    marker.setMap(null);
    document.getElementById("latitude").value = places[0].geometry.location.lat();
    document.getElementById("longitude").value = places[0].geometry.location.lng();
  });
}

     </script>


@endsection
