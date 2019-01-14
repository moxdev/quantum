// VARIABLES
// IDs of HTML elements to hold the map
var myMap = 'map-canvas';

// Google Maps API Key
var apiKey = 'AIzaSyB1scc5719lwFXoe3BHtLes5Cftz3VSF5w';

// Path to JSON Data (PostID is output in the PHP)
var apiPath = '/wp-json/wp/v2/properties/' + postID;

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
function initMap( myMap, lat, lng, commName, add, city, state, zip, phone, landmarks ) {
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
    }
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

  openInfoWindow( commMarker );

  // Make sure there are landmarks to add, build their info and push them to the locations array
  // Push their category to the categories array
  if ( landmarks ) {
    for ( var i = 0; i < landmarks.length; i++ ) {
      var lmTitle = landmarks[i].landmark_name;
      var lmAdd = landmarks[i].landmark_address_1;
      var lmAdd2 = landmarks[i].landmark_address_2;
      var lmPhone = landmarks[i].landmark_phone;
      var lmWebsite = landmarks[i].landmark_website_url;
      var lmLatitude = landmarks[i].landmark_latitude;
      var lmLongitude = landmarks[i].landmark_longitude;
      var lmCategory = landmarks[i].landmark_category;

      if ( '' !== lmTitle ) {
        lmTitle = '<strong class="map-comm-name">' + lmTitle + '</strong>';
      } else {
        lmTitle = '';
      }

      if ( '' !== lmAdd ) {
        lmAdd = '<br>' + lmAdd;
      } else {
        lmAdd = '';
      }

      if ( '' !== lmAdd2 ) {
        lmAdd2 = '<br>' + lmAdd2;
      } else {
        lmAdd2 = '';
      }

      if ( '' !== lmPhone ) {
        lmPhone = '<br>' + lmPhone;
      } else {
        lmPhone = '';
      }

      if ( '' !== lmWebsite ) {
        lmWebsite = '<br><a target="_blank" href="' + lmWebsite + '">Website &raquo;</a>';
      } else {
        lmWebsite = '';
      }

      locations.push([ i, lmTitle, lmLatitude, lmLongitude, lmAdd, lmAdd2, lmPhone, lmWebsite, lmCategory ]);
      categories.push( lmCategory );
    }
  }

  // Loop over the locations array and add markers to the map
  // Filter out duplicates from the categories array and build the category navigation
  if ( landmarks ) {
    for ( var j = 0; j < locations.length; j++ ) {
      var image = markerPath + 'landmark-marker.png';
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng( locations[j][2], locations[j][3]),
        map: map,
        icon: image,
        html: locations[j][1] + locations[j][4] + locations[j][5] + locations[j][6] + locations[j][7]
      });
      markers.push( marker );
      bounds.extend( marker.getPosition() );

      openInfoWindow( marker );
    }

    uniqueCats = categories.filter( function( elem, index, self ) {
      return index === self.indexOf( elem );
    });
    buildCats( uniqueCats, myMap );

  } else {
    bounds.extend( commMarker.getPosition() );
  }

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

// Build the category navigation
var catNav = document.createElement( 'nav' );
catNav.id = 'map-nav';

function buildCats( data, map ) {
  var mapWrapper = document.getElementById( map ).parentNode;
  mapWrapper.appendChild( catNav, document.getElementById( map ) );
  var catNavUl = document.createElement( 'ul' );
  catNav.appendChild( catNavUl );

  // View/hide markers on the map and swap active class on category nav
  function catClick( href, ul ) {
    href.addEventListener( 'click', function( event ) {
      event.preventDefault();
      if ( infowindow ) {
        infowindow.close();
      }
      var cat = ( this.parentElement.getAttribute( 'id' ) );

      for ( var i = 0; i < locations.length; i++ ) {
        if ( locations[i][8] === cat ) {
          markers[i].setVisible( true );
          markers[i].setOptions({ zIndex: 1100 });
        } else if ( locations[i][8] !== cat ) {
          markers[i].setVisible( false );
        }
      }

      var children = [];
      children = ul.children;
      for ( var j = 0; j < children.length; j++ ) {
        children[j].classList.remove( 'active' );
      }

      this.parentNode.classList.add( 'active' );
      resetBtn.classList.add( 'active' );

    });
  }

  for ( var i = 0; i < data.length; i++ ) {
    var listItem = document.createElement( 'li' );
    listItem.id = data[i];
    listItem.classList.add( data[i]);
    var listItemHref = document.createElement( 'a' );
    listItemHref.href = '#';
    listItemHref.innerHTML = data[i].charAt( 0 ).toUpperCase() + data[i].slice( 1 ).replace( /-/g, ' ' );
    listItem.appendChild( listItemHref );
    catNavUl.appendChild( listItem );

    catClick( listItemHref, catNavUl );
  }
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
      if ( 'yes' === addLandmarks ) {
        var markerData = obj.acf.landmark_information;
      } else {
        '' === markerData;
      }
      initMap( myMap, lat, lng, commName, add, city, state, zip, phone, markerData );
    } else {
      document.getElementById( 'map-canvas' ).innerHTML = 'Error Loading Data';
    }
  };

  xhr.open( 'GET', apiPath, true );
  xhr.send();
  document.getElementById( 'map-canvas' ).innerHTML = 'Loading map...';
}
