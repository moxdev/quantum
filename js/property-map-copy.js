// VARIABLES
// IDs of HTML elements to hold the map
var myMap = 'map-canvas';

// Google Maps API Key
var apiKey = 'AIzaSyB1scc5719lwFXoe3BHtLes5Cftz3VSF5w';

// Path to JSON Data (PostID is output in the PHP)
var apiPath = '/wp-json/wp/v2/properties/' + postID;
console.log( 'API Path: ' + apiPath );

// Path to icon marker
var markerPath = '/wp-content/themes/quantum/imgs/';

var markers = [];
var locations = [];
var categories = [];
var infowindow;
var currentInfoWindow = null;
var map;
var bounds;
var uniqueCats;
var resetBtn = document.getElementById( 'reset-map' );

// Check to see if there is an HTML element on our page to load the map into.
// If there is, call the Google Maps API with our API key and a callback function
document.addEventListener( 'DOMContentLoaded', function() {
  if ( document.getElementById( myMap ) ) {
    var lang;
    if ( document.querySelector( 'html' ).lang ) {
      lang = document.querySelector( 'html' ).lang;
    } else {
      lang = 'en';
    }

    var map_js_file = document.createElement( 'script' );
    map_js_file.type = 'text/javascript';
    map_js_file.src = 'https://maps.googleapis.com/maps/api/js?key=' + apiKey + '&callback=callback&language=' + lang;
    document.getElementsByTagName( 'body' )[0].appendChild( map_js_file );
  }
});

// Build the Map
function initMap( myMap, lat, lng, commName, add, city, state, zip, phone ) {
  bounds = new google.maps.LatLngBounds();
  map = new google.maps.Map( document.getElementById( myMap ), {
    maxZoom: 16,
    mapTypeControl: false,
    scrollwheel: false,
    panControl: false,
    rotateControl: false,
    streetViewControl: false,
    zoomControlOptions: {
      position: google.maps.ControlPosition.RIGHT_BOTTOM
    },
    styles: [
      {
        featureType: 'water',
        elementType: 'geometry',
        stylers: [
          { saturation: -75 },
          { color: '#aed4f3' },
          { lightness: 35 }
        ]
      },
      {
        featureType: 'road',
        elementType: 'geometry',
        stylers: [
          { color: '#c5c0c0' }
        ]
      },
      {
        featureType: 'landscape',
        elementType: 'geometry',
        stylers: [
          { color: '#f1f1f1' }
        ]
      },
      {
        featureType: 'poi',
        elementType: 'geometry',
        stylers: [
          { color: '#dcd9d4' }
        ]
      },
      {
        featureType: 'poi',
        elementType: 'labels',
        stylers: [
          { visibility: 'off' }
        ]
      }
    ]
  });

  // Information for community info window
  var contentString = '';
  if ( commName ) {
    contentString += '<strong class="map-comm-name">' + commName + '</strong>';
  }
  if ( add ) {
    contentString += '<br><span class="map-comm-add-1">' + add + '</span>';
  }
  if ( city || state || zip ) {
    contentString += '<br><span class="map-comm-add-2">';
    if ( city ) {
      contentString += city + ', ';
    }
    if ( state ) {
      contentString += state + ' ';
    }
    if ( zip ) {
      contentString += zip;
    }
    contentString += '</span>';
  }
  if ( phone ) {
    contentString += '<br><a class="tel" href="tel:' + phone + '">' + phone + '</a>';
  }

  var commMarker = new google.maps.Marker({
    position: { lat: lat, lng: lng },
    map: map,
    icon: markerPath + 'quote-marks.svg',
    html: contentString
  });

  console.log( commMarker.position.lat );
  console.log( commMarker.position.lng );

  openInfoWindow( commMarker );

  map.fitBounds( bounds );
}


function openInfoWindow( marker ) {
  marker.addListener( 'click', function() {
    infowindow = new google.maps.InfoWindow();
    if ( null !== currentInfoWindow ) {
      currentInfoWindow.close();
    }
    currentInfoWindow = infowindow;
    infowindow.setContent( marker.html );
    infowindow.open( map, marker );
  });
}

function callback() {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if ( 4 === xhr.readyState && 200 === xhr.status ) {
      var obj = JSON.parse( xhr.responseText );
      document.getElementById( 'map-canvas' ).innerHTML = '';
      var addLandmarks = obj.acf.add_landmarks;
      var lat = Number( obj.acf.map_section.prop_latitude );
      var lng = Number( obj.acf.map_section.prop_longitude );
      var commName = obj.title.rendered;
      var add = obj.acf.property_contact_information.prop_address_1;
      var add2 = obj.acf.property_contact_information.prop_address_2;
      var city = obj.acf.property_contact_information.prop_city;
      var state = obj.acf.property_contact_information.prop_state;
      var zip = obj.acf.property_contact_information.prop_zip;
      var phone = obj.acf.property_contact_information.prop_phone;
      var markerData = '';

      initMap( myMap, lat, lng, commName, add, city, state, zip, phone );
    } else {
      document.getElementById( 'map-canvas' ).innerHTML = 'Error Loading Data';
    }
    console.log( 'Lat: ' + lat );
    console.log( 'Long: ' + lng );
    console.log( 'Zip: ' + zip );
  };

  xhr.open( 'GET', apiPath, true );
  xhr.send();
  document.getElementById( 'map-canvas' ).innerHTML = 'Loading map...';
}
