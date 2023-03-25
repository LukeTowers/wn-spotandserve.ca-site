function initMap(locations) {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: {
            lat: 50.4577652,
            lng: -104.620093
        },
        streetViewControl: false,
        mapTypeId: 'roadmap'
    });

    // Add some markers to the map.
    const markers = locations.map((item, i) => {
        const marker = new google.maps.Marker({
            position: {
                lat: parseFloat(item.latitude),
                lng: parseFloat(item.longitude)
            },
            map: map,
            label: item.type_name,
            weight: 1
        });

        marker.addListener('click', function() {
            window.open(item.directions_url, '_blank').focus();
        });

        return marker;
    });

    // // Add a marker clusterer to manage the markers.
    // var markerClusterer = new MarkerClusterer(map, [], {imagePath: '/plugins/sas/requests/assets/images/m'});

    // var calc = function(markers, numStyles) {
    //     var weight = 0;

    //     for (var i = 0; i < markers.length; ++i) {
    //         weight += markers[i].weight;
    //     }
    //     return {
    //         text: weight,
    //         index: Math.min(String(weight).length, numStyles)
    //     };
    // };

    // markerClusterer.setCalculator(calc);

    // markerClusterer.addMarkers(markers);
}

$(document).on('render', function () {
    $.request('onGetLocations', {
        success: function (data) {
            initMap(data.locations);
        }
    });
});
