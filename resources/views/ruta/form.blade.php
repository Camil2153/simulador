<div class="box box-info padding-1">
    <div class="box-body">
        <div class="form-group">
            {{ Form::label('Código') }}
            {{ Form::text('cod_rut', $ruta->cod_rut, ['class' => 'form-control' . ($errors->has('cod_rut') ? ' is-invalid' : ''), 'maxlength' => '4', 'pattern' => '[0-9]{4}', 'placeholder' => '1111']) }}
            {!! $errors->first('cod_rut', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Nombre') }}
            {{ Form::text('nom_rut', $ruta->nom_rut, ['class' => 'form-control' . ($errors->has('nom_rut') ? ' is-invalid' : '')]) }}
            {!! $errors->first('nom_rut', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Origen') }}
            {{ Form::select('ori_rut', $ciudades, $ruta->ori_rut, ['id' => 'ori_rut', 'class' => 'form-control' . ($errors->has('ori_rut') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione una ciudad', 'onchange' => 'updateMap()']) }}
            {!! $errors->first('ori_rut', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Destino') }}
            {{ Form::select('des_rut', $ciudades, $ruta->des_rut, ['id' => 'des_rut', 'class' => 'form-control' . ($errors->has('des_rut') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione una ciudad', 'onchange' => 'updateMap()']) }}
            {!! $errors->first('des_rut', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div id="map" style="height: 400px; width: 100%;"></div>
        <div class="form-group">
            {{ Form::label('Distancia (km)') }}
            <?php
                $dis_rut_formatted = number_format($ruta->dis_rut, 0, ',', '.');
            ?>
            {{ Form::text('dis_rut', $dis_rut_formatted, ['id' => 'dis_rut', 'class' => 'form-control', 'readonly' => 'readonly']) }}
            {!! $errors->first('dis_rut', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Duración') }}
            {{ Form::text('dur_rut', $ruta->dur_rut, ['id' => 'dur_rut', 'class' => 'form-control', 'readonly' => 'readonly']) }}
            {!! $errors->first('dur_rut', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Restricciones') }}
            {{ Form::text('res_rut', $ruta->res_rut, ['class' => 'form-control' . ($errors->has('res_rut') ? ' is-invalid' : '')]) }}
            {!! $errors->first('res_rut', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Complejidad') }}
            {{ Form::select('com_rut', ['Fácil' => 'Fácil', 'Moderado' => 'Moderado', 'Difícil' => 'Difícil'], $ruta->com_rut, ['class' => 'form-control' . ($errors->has('com_rut') ? ' is-invalid' : ''), 'placeholder' => 'Seleccionar nivel']) }}
            {!! $errors->first('com_rut', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Estado') }}
            {{ Form::select('est_rut', ['Bueno estado' => 'Buen estado', 'Regular estado' => 'Regular estado', 'Mal estado' => 'Mal estado', 'Cerrada' => 'Cerrada', 'En construcción' => 'En construcción'], $ruta->est_rut, ['class' => 'form-control' . ($errors->has('est_rut') ? ' is-invalid' : ''), 'placeholder' => 'Seleccionar estado']) }}
            {!! $errors->first('est_rut', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Empresa') }}
            {{ Form::select('emp_rut', $empresas, $ruta->emp_rut, ['class' => 'form-control' . ($errors->has('emp_rut') ? ' is-invalid' : ''), 'placeholder' => 'Seleccionar empresa']) }}
            {!! $errors->first('emp_rut', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-secundary border border-secondary btn-sm ">{{ __('Guardar') }}</button>
        <a href="{{ route('rutas.index') }}" class="btn btn-secundary border border-secondary btn-sm ">Cancelar</a>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhGHEvQIsLhByKH2e_H2ZEtVrbYnLGcIU&callback=initMap" async defer></script>
<script>
    var map;
    var geocoder;
    var debounceTimer;
    var directionsService;
    var directionsRenderer;

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 4.5709, lng: -74.2973 },
            zoom: 6
        });
        geocoder = new google.maps.Geocoder();
        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer({ map: map });
    }

    function updateMap() {
        var origin = document.getElementById('ori_rut');
        var destination = document.getElementById('des_rut');

        if (origin.selectedIndex === 0 || destination.selectedIndex === 0) {
            map.setCenter({ lat: 4.5709, lng: -74.2973 });
            map.setZoom(6);
            directionsRenderer.setDirections({ routes: [] });
            document.getElementById('dis_rut').value = '';
            document.getElementById('dur_rut').value = '';
            return;
        }

        var originValue = origin.options[origin.selectedIndex].text;
        var destinationValue = destination.options[destination.selectedIndex].text;

        geocoder.geocode({ address: originValue }, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                var originLocation = results[0].geometry.location;
                geocoder.geocode({ address: destinationValue }, function (results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        var destinationLocation = results[0].geometry.location;

                        var request = {
                            origin: originLocation,
                            destination: destinationLocation,
                            travelMode: google.maps.TravelMode.DRIVING
                        };

                        directionsService.route(request, function (response, status) {
                            if (status === google.maps.DirectionsStatus.OK) {
                                directionsRenderer.setDirections(response);
                                var bounds = new google.maps.LatLngBounds();
                                bounds.extend(originLocation);
                                bounds.extend(destinationLocation);
                                map.fitBounds(bounds);

                                var route = response.routes[0];
                                var distance = 0;
                                var duration = 0;

                                for (var i = 0; i < route.legs.length; i++) {
                                    distance += route.legs[i].distance.value;
                                    duration += route.legs[i].duration.value;
                                }

                                distance = distance / 1000; // Convertir de metros a kilómetros

                                var days = Math.floor(duration / (60 * 60 * 24));
                                var hours = Math.floor((duration % (60 * 60 * 24)) / (60 * 60));
                                var minutes = Math.floor((duration % (60 * 60)) / 60);

                                var durationText = "";
                                if (days > 0) {
                                    durationText += days + " día(s) ";
                                }
                                if (hours > 0) {
                                    durationText += hours + " hora(s) ";
                                }
                                if (minutes > 0) {
                                    durationText += minutes + " minuto(s)";
                                }

                                document.getElementById('dis_rut').value = distance.toFixed(2);
                                document.getElementById('dur_rut').value = durationText;
                            } else {
                                window.alert('No se pudo calcular la ruta: ' + status);
                                directionsRenderer.setDirections({ routes: [] });
                                document.getElementById('dis_rut').value = '';
                                document.getElementById('dur_rut').value = '';
                            }
                        });
                    } else {
                        window.alert('No se pudo encontrar el destino');
                        directionsRenderer.setDirections({ routes: [] });
                        document.getElementById('dis_rut').value = '';
                        document.getElementById('dur_rut').value = '';
                    }
                });
            } else {
                window.alert('No se pudo encontrar el origen');
                directionsRenderer.setDirections({ routes: [] });
                document.getElementById('dis_rut').value = '';
                document.getElementById('dur_rut').value = '';
            }
        });
    }
</script>