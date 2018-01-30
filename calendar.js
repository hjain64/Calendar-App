//Javascript file for Calendar
var map;
var infowindow;
var infowindow2;
var geocoder;
var service;
var curr_pos;
var directionsDisplay;
var directionsService;
var mod;
var map_centre = {lat: 44.974, lng: -93.234};
var img_loc = ['"Rapson.jpg"','"Fraser.jpg"','"kellerhall.jpg"','"Bruininks.jpg"','"Amundson.jpg"'];

function put_Img(id,loc)
{
  document.getElementById(id).src=loc;
}

function out_Img(id)
{
  document.getElementById(id).src="#";
}

function change_scroll()
{
  var d = new Date();
  var n = d.getDay();
  if (n < 6) {
  change_text(n);
  }
  else {
    document.getElementById("content-events").innerHTML = "No Events Scheduled Today!!!!";
  }
}

function change_text(n)
{
var index = n-1;
var x = "Event for today --";
var rd = document.getElementById("table-div").rows[index].getElementsByTagName('p');
for(var i = 0; i < rd.length ; i++){
   if (i!=0 && i%2 == 0)
   {
     x += ","
   }
   x += rd[i].innerHTML;
}
 document.getElementById("content-events").innerHTML = x;
}

function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: map_centre,
          zoom: 14
        });

        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
             curr_pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
          });
        }
        directionsDisplay = new google.maps.DirectionsRenderer;
        directionsService = new google.maps.DirectionsService;
        geocoder = new google.maps.Geocoder();
        infowindow = new google.maps.InfoWindow();
        infowindow2 = new google.maps.InfoWindow();
        service = new google.maps.places.PlacesService(map);
        if (document.getElementById('table-div')) {
        var data = document.getElementById("table-div").getElementsByClassName('location-markers');
        var data2 = document.getElementById("table-div").getElementsByClassName('data-value');
        for (var i = 0; i < data.length; i++) {
        var pos = data[i].innerHTML;
        var info = data2[i].innerHTML;
        var img_no = img_loc[i];
        place_Marker(pos, info,img_no);
      }
    }
}

function place_Marker (pos, info, img_no) {
   geocoder.geocode({
   address: pos,
   componentRestrictions: {
   country: 'US',
   postalCode: '55455'
 }
 }, function(results, status) {
 if (status == 'OK') {
  var res=results[0].geometry.location;
  var full = '<div style="text-align:center"><strong>'+ info +'</strong></div>';
 infowindow2 = new google.maps.InfoWindow({
            maxWidth: 220
          });
  var marker = new google.maps.Marker({
    map: map,
    position: res,
    animation:google.maps.Animation.BOUNCE,
}) ;
google.maps.event.addListener(marker, 'mouseover', function() {
  infowindow2.setContent(full);
  infowindow2.open(map, this);
});
  }
}) ;
}

function findPlaces() {
  var rad = document.forms["search"]["radius"].value;
        service.nearbySearch({
          location: map_centre,
          radius: rad,
          type: ['restaurant']
        }, callback);
      }

      function callback(results, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
          for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
          }
        }
      }

      function createMarker(place) {
        var placeLoc = place.geometry.location;
        var marker = new google.maps.Marker({
          map: map,
          position: place.geometry.location
        });
        google.maps.event.addListener(marker, 'click', function() {
        service.getDetails(place, function(result, status) {
       if (status !== google.maps.places.PlacesServiceStatus.OK) {
         console.error(status);
         return;
       }
       infowindow.setContent('<div><strong>' + result.name + '</strong><br>' +
                                 result.formatted_address + '</div>');
       infowindow.open(map, marker);
     });
   });
}
function locate_Direction() {
  directionsDisplay.setMap(map);
  directionsDisplay.setPanel(document.getElementById('right-panel'));
  calculateAndDisplayRoute(directionsService, directionsDisplay);
  document.directions.addEventListener('click', function() {
         calculateAndDisplayRoute(directionsService, directionsDisplay)
       });
}

function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        document.getElementById('right-panel').style.backgroundColor="lightgray";
        var dir = document.forms["directions"]["destination"].value;
        mod = document.forms["directions"]["mode"].value;
        directionsService.route({
          origin: curr_pos ,
          destination: dir,
          travelMode: mod
        }, function(response, status) {
          if (status == 'OK') {
            directionsDisplay.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      }
