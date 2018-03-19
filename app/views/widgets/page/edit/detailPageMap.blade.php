<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 06.11.2015
 * Time: 09:33
 */
?>
<div class="row">
    <div class="col-md-12">
        <div id="map" style="min-height:400px;"></div>
    </div>
</div>
@section('scriptFile')
    {{HTML::script("http://maps.google.com/maps/api/js?sensor=false")}}
    {{HTML::script("assets/global/plugins/gmaps/gmaps.min.js")}}
@append

@section('scriptCodes')
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            @if(\Helper::metaValue('coordinates', $data->id))
            var latlng = new google.maps.LatLng({{\Helper::metaValue('coordinates', $data->id)}});
                    @else
                    var latlng = new google.maps.LatLng(38.685510, 34.101563);
                    @endif
                    var myOptions = {
                zoom: 5,
                center: latlng,
                panControl: true,
                scrollwheel: true,
                scaleControl: true,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("map"),myOptions);
            marker = new google.maps.Marker({
                position: latlng,
                map: map,
                animation: google.maps.Animation.DROP
            });
            map.streetViewControl = false;
            google.maps.event.addListener(map, 'click', function(event) {
                marker.setPosition(event.latLng);
                var yeri = event.latLng;
                $.ajax({
                    url: '{{action("Back\AjaxController@postChangeDetailPageMap")}}',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {page : "detail", id: '{{$data->id}}', gmapx: yeri.lat().toFixed(6), gmapy: yeri.lng().toFixed(6)},
                })
                        .done(function(response) {
                            toastr[response.status](response.text);
                        }).fail(function (argument) {
                            console.log(argument);
                        });
            });
        });
    </script>
@append