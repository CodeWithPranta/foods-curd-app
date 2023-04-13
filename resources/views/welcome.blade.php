@extends('layouts.app')

@section('content')
<div id="search-box">
    <input id="location-input" type="text" placeholder="Enter location">
    <button id="search-btn" type="button" class="disabled" disabled>Search</button>
</div>
<form action="/foods" method="GET" id="location-form">
    <input type="hidden" name="latitude" id="location-lat">
    <input type="hidden" name="longitude" id="location-lng">
</form>



<script>
function initAutocomplete() {
    const input = document.getElementById("location-input");
    const autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();
        const latitude = place.geometry.location.lat();
        const longitude = place.geometry.location.lng();

        document.getElementById("location-input").value = place.formatted_address;
        document.getElementById("search-btn").disabled = false;
        document.getElementById("search-btn").classList.remove("disabled");

        document.getElementById("location-lat").value = latitude;
        document.getElementById("location-lng").value = longitude;
    });

    const searchBtn = document.getElementById("search-btn");

    searchBtn.addEventListener("click", () => {
        document.getElementById("location-form").submit();
    });
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&libraries=places&callback=initAutocomplete"></script>

@endsection
