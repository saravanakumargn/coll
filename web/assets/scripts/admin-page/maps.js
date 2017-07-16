// This sample uses the Place Autocomplete widget requesting only a place
// ID to allow the user to search for and locate a place. The sample
// then reverse geocodes the place ID and displays an info window
// containing the place ID and other information about the place that the
// user has selected.

// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var componentForm = {
    route: 'long_name',
    sublocality_level_1: 'long_name',
    locality: 'long_name',
    sublocality: 'long_name',
    administrative_area_level_2: 'long_name',
    postal_code: 'short_name'
};
var addressDetails = [];
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 10.7904833, lng: 78.70467250000002},
        zoom: 6
    });

    var input = document.getElementById('pac-input');

    var autocomplete = new google.maps.places.Autocomplete(
            input);
    // Set initial restrict to the greater list of countries.
    autocomplete.setComponentRestrictions(
            {'country': ['in']});
    autocomplete.bindTo('bounds', map);

    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    var infowindow = new google.maps.InfoWindow();
    var infowindowContent = document.getElementById('infowindow-content');
    infowindow.setContent(infowindowContent);
    var geocoder = new google.maps.Geocoder;
    var marker = new google.maps.Marker({
        map: map
    });
    marker.addListener('click', function () {
        infowindow.open(map, marker);
    });

    autocomplete.addListener('place_changed', function () {
        infowindow.close();
        var place = autocomplete.getPlace();
        if (!place.place_id) {
            return;
        }

//        for (var component in componentForm) {
//          document.getElementById(component).value = '';
//          document.getElementById(component).disabled = false;
//        }

        addressDetails = [];
        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                console.log(componentForm[addressType])
                console.log(place.address_components[i].types[0])
//            console.log(val);
                var obj = {};
                obj[place.address_components[i].types[0]] = val;
                addressDetails.push(obj);
            }
        }
        addressDetails.push({'formatted_address': place.formatted_address});
        addressDetails.push({'lat': place.geometry.location.lat()});
        addressDetails.push({'lng': place.geometry.location.lng()});
        console.log(addressDetails);

        geocoder.geocode({'placeId': place.place_id}, function (results, status) {

            if (status !== 'OK') {
                window.alert('Geocoder failed due to: ' + status);
                return;
            }
            map.setZoom(11);
            map.setCenter(results[0].geometry.location);
            // Set the position of the marker using the place ID and location.
            marker.setPlace({
                placeId: place.place_id,
                location: results[0].geometry.location
            });
            marker.setVisible(true);
            infowindowContent.children['place-name'].textContent = place.name;
            infowindowContent.children['place-id'].textContent = place.place_id;
            infowindowContent.children['place-address'].textContent =
                    results[0].formatted_address;
            infowindow.open(map, marker);
        });
    });
}