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
//var addressDetails = [];
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 11.3392101, lng: 77.41640630000006},
        zoom: 7
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
    google.maps.event.trigger(map, 'resize');
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

//        addressDetails = [];
        var addressObj = {};
        var sublocality_level_1 = '';
        var locality = '';
        var district = '';
        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
//                console.log(componentForm[addressType])
//                console.log(place.address_components[i].types[0])
                if ("postal_code" === place.address_components[i].types[0]) {
//                    $('#pincode').val(val);
//                    addressDetails.push({'pincode': val});
                    addressObj['pincode'] = val;
                } else if ("administrative_area_level_2" === place.address_components[i].types[0]) {
//                    $('#district').val(val);
//                    addressDetails.push({'district': val});
                    addressObj['district'] = val;
                    district = val;
                } else if ("sublocality_level_1" === place.address_components[i].types[0]) {
                    sublocality_level_1 = val;
                } else if ("locality" === place.address_components[i].types[0]) {
                    locality = val;
                }
//            console.log(val);
//                var obj = {};
//                obj[place.address_components[i].types[0]] = val;
//                addressDetails.push(obj);
            }
        }
//        $('#pageUrl').val(pageUrl);
//        $('#college_name').val(place.name);
//        $('#full_address').val(place.formatted_address);
//        $('#lat').val(place.geometry.location.lat());
//        $('#lng').val(place.geometry.location.lng());
        var pageUrl = place.name + ' ' + sublocality_level_1 + ' ' + locality;
        if (district !== sublocality_level_1 && district !== locality) {
            pageUrl = pageUrl + ' ' + district;
        }
        addressObj['pageUrl'] = pageUrl;
        addressObj['collegeName'] = place.name;
        addressObj['fullAddress'] = place.formatted_address;
        addressObj['lat'] = place.geometry.location.lat();
        addressObj['lng'] = place.geometry.location.lng();

//        addressDetails.push({'pageUrl': pageUrl});
//        addressDetails.push({'college_name': place.name});
//        addressDetails.push({'full_address': place.formatted_address});
//        addressDetails.push({'lat': place.geometry.location.lat()});
//        addressDetails.push({'lng': place.geometry.location.lng()});

//        console.log(addressDetails);
        angular.element(document.getElementById('mainSection')).scope().mapCalling(addressObj);

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