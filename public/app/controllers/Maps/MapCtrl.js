(function(){
  'use strict';

  angular.module('adimovelApp').controller('mapaCtrl', mapaCtrl);

  mapaCtrl.inject = ['$interval'];

  function mapaCtrl($interval){

    var vm = this;
    var intervalo;

    intervalo = $interval(function(){
        try {
            if(vm.verificador === true){
                $interval.cancel(intervalo);
                return false;
            }
            mapaMetaBox();
        } catch(e) {
            $("#pac-input").css("display","none");
            console.log(e);
        }
    
    },500);

    $("footer .map").html('<script async type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>');
    function mapaMetaBox() {
        var latitude   = Number($("#map").data('lat'))
        ,    longitude = Number($("#map").data('long'));

        var mapOptions = {
            center: {lat: latitude, lng: longitude},
            zoom: 13,
            scrollwheel: false
        };

        var map   = new google.maps.Map(document.getElementById('map'),mapOptions);

        var input = (document.getElementById('pac-input'));

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        var marker = new google.maps.Marker({
            position : {lat: latitude, lng: longitude},
            map: map,
            icon: '../image/pin.png'
        });

        var infowindow = new google.maps.InfoWindow();

        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker);
        });
        
        $("#pac-input").css("display","block");
        vm.verificador = true;

        function finishAutoComplete(){
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

            if(place.address_components){
                $.each(place.address_components, function(index, val) {
                    if(val.types[0] == "administrative_area_level_2" ||
                        val.types[0] == "locality"){
                        $(".cidade").val(val.long_name)
                            .siblings('label').addClass('label-active')
                            .siblings('span').addClass('input-focus');
                    }else if(val.types[0] == "sublocality_level_1"){
                        $(".bairro").val(val.long_name)
                            .siblings('label').addClass('label-active')
                            .siblings('span').addClass('input-focus');
                    }else if(val.types[0] == "route"){
                        $(".endereco").val(val.long_name)
                            .siblings('label').addClass('label-active')
                            .siblings('span').addClass('input-focus');
                    }
                });
            }

            $(".lat").val(place.geometry.location.lat)
            $(".lng").val(place.geometry.location.lng)

            infowindow.setContent('\
                <div><strong>' + place.name + '</strong><br>'
                + place.formatted_address + 
            '</div>');
            infowindow.open(map, marker);

        }

        google.maps.event.addListener(autocomplete, 'place_changed', finishAutoComplete);      
    } 

}     


})();