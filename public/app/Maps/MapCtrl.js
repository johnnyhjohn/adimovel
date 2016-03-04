(function(){
  'use strict';

  angular.module('adimovelApp').controller('mapaCtrl', mapaCtrl);

  function mapaCtrl(){

    try {
        mapaMetaBox();
    } catch(e) {
        $("#map").append('<p>Verifique sua conexão com a internet</p>');
        $("#pac-input").css("display","none");
        console.log(e);
    }
    

    function mapaMetaBox() {
        var lat  = Number($("#map").data('lat'))
        ,    lng = Number($("#map").data('long'));

        var mapOptions = {
            center: {lat: lat, lng: lng},
            zoom: 13,
            scrollwheel: false
        };

        var map = new google.maps.Map(document.getElementById('map'),mapOptions);

        var input = (document.getElementById('pac-input'));

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        var marker = new google.maps.Marker({
            position : {lat: lat, lng: lng},
            map: map,
            icon: '../image/pin.png'
        });

        var infowindow = new google.maps.InfoWindow();

        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker);
        });

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            infowindow.close();
            var place = autocomplete.getPlace();
            if (!place.geometry) {
              return;
            }

            if (place.geometry.viewport) {
              map.fitBounds(place.geometry.viewport);
            } else {
              map.setCenter(place.geometry.location);
              map.setZoom(17);
            }

            marker.setPlace(/** @type {!google.maps.Place} */ ({
              placeId: place.place_id,
              location: place.geometry.location
            }));
            marker.setVisible(true);

            $(".endereco").val(place.address_components[0].long_name)
                .siblings('label').addClass('label-active')
                .siblings('span').addClass('input-focus');

            $(".bairro").val(place.address_components[1].long_name)
                .siblings('label').addClass('label-active')
                .siblings('span').addClass('input-focus');

            $(".cidade").val(place.address_components[2].long_name)
                .siblings('label').addClass('label-active')
                .siblings('span').addClass('input-focus');

            $(".lat").val(place.geometry.location.lat)
            $(".lng").val(place.geometry.location.lng)

            infowindow.setContent('<div><strong>' + place.name + '</strong><br>' +
                place.formatted_address + '</div>');
            infowindow.open(map, marker);
          });
        
      }    
    }     
  

})();