<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('Placa') }}
                    {{ Form::text('pla_cam', $camione->pla_cam, ['class' => 'form-control uppercase' . ($errors->has('pla_cam') ? ' is-invalid' : ''), 'placeholder' => 'A11111']) }}
                    {!! $errors->first('pla_cam', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('Marca') }}
                    {{ Form::text('mar_cam', $camione->mar_cam, ['class' => 'form-control' . ($errors->has('mar_cam') ? ' is-invalid' : '')]) }}
                    {!! $errors->first('mar_cam', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('Modelo') }}
                    {{ Form::selectRange('mod_cam', date('Y') - 70, date('Y') + 1, $camione->mod_cam, ['class' => 'form-control' . ($errors->has('mod_cam') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione un año']) }}
                    {!! $errors->first('mod_cam', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('Tipo') }}
                    {{ Form::select('tip_cam', ['convencional' => 'Convencional', 'plataforma plana' => 'Plataforma Plana', 'cisterna' => 'Cisterna', 'volteo' => 'Volteo', 'refrigerado' => 'Refrigerado', 'portacontenedores' => 'Portacontenedores'], $camione->tip_cam, ['class' => 'form-control' . ($errors->has('tip_cam') ? ' is-invalid' : ''), 'placeholder' => 'Seleccionar tipo']) }}
                    {!! $errors->first('tip_cam', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('Número de ejes') }}
                    {{ Form::text('num_eje_cam', $camione->num_eje_cam, ['class' => 'form-control' . ($errors->has('num_eje_cam') ? ' is-invalid' : '')]) }}
                    {!! $errors->first('num_eje_cam', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('Estado') }}
                    @if (Route::currentRouteName() === 'camiones.edit')
                        {{ Form::select('est_cam', ['disponible' => 'Disponible', 'en mantenimiento' => 'En Mantenimiento', 'fuera de servicio' => 'Fuera de Servicio'], $camione->est_cam, ['class' => 'form-control' . ($errors->has('est_cam') ? ' is-invalid' : ''), 'placeholder' => 'Seleccionar estado', 'disabled' => 'disabled']) }}
                    @else
                        {{ Form::select('est_cam', ['disponible' => 'Disponible', 'en mantenimiento' => 'En Mantenimiento', 'fuera de servicio' => 'Fuera de Servicio'], 'disponible', ['class' => 'form-control' . ($errors->has('est_cam') ? ' is-invalid' : ''), 'placeholder' => 'Seleccionar estado', 'disabled' => 'disabled']) }}
                    @endif
                    {!! $errors->first('est_cam', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('Kilometraje') }}
                    <?php
                        $kil_cam_formatted = number_format($camione->kil_cam, 0, ',', '.');
                    ?>
                    {{ Form::text('kil_cam', $camione->kil_cam, ['id' => 'kil_cam', 'class' => 'form-control' . ($errors->has('kil_cam') ? ' is-invalid' : ''), 'pattern' => '[0-9]+(\.[0-9]+)?', 'placeholder' => 'Inserte datos sin puntos ni comas']) }}
                    {!! $errors->first('kil_cam', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('Capacidad (Toneladas)') }}
                    {{ Form::number('cap_cam', $camione->cap_cam, ['class' => 'form-control' . ($errors->has('cap_cam') ? ' is-invalid' : ''), 'placeholder' => 'Inserte datos sin puntos ni comas']) }}
                    {!! $errors->first('cap_cam', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('Conductor') }}
                    @if (Route::currentRouteName() === 'camiones.edit')
                         @if ($camione->est_cam === 'disponible')
                         {{ Form::select('con_cam', $conductores, $camione->con_cam, ['class' => 'form-control' . ($errors->has('con_cam') ? ' is-invalid' : ''), 'placeholder' => 'Seleccionar conductor']) }}
                         @else
                             {{ Form::select('con_cam', $conductores, $camione->con_cam, ['class' => 'form-control' . ($errors->has('con_cam') ? ' is-invalid' : ''), 'placeholder' => 'Seleccionar conductor', 'disabled' => 'disabled']) }}
                         @endif
                    @else
                        {{ Form::select('con_cam', $conductoresDisponibles, $camione->con_cam, ['class' => 'form-control' . ($errors->has('con_cam') ? ' is-invalid' : ''), 'placeholder' => 'Seleccionar conductor']) }}
                    @endif
                    {!! $errors->first('con_cam', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer mt20 text-center">
        <button type="submit" class="btn btn-outline-success btn-sm custom-btn">{{ __('Guardar') }}</button>
        <a href="{{ route('camiones.index') }}" class="btn btn-outline-danger btn-sm custom-btn">Cancelar</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Obtener el campo de input del kilometraje
    var kilCamInput = document.getElementById('kil_cam');

    // Escuchar el evento de entrada en el campo de input
    kilCamInput.addEventListener('input', function(event) {
        // Obtener el valor sin separadores de miles
        var rawValue = event.target.value.replace(/\./g, '');

        // Formatear el valor con separadores de miles
        var formattedValue = addThousandSeparators(rawValue);

        // Mostrar el valor formateado en el campo de input
        event.target.value = formattedValue;
    });

    // Función para agregar separadores de miles
    function addThousandSeparators(value) {
        var parts = value.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        return parts.join(".");
    }

    // Escuchar el evento de envío del formulario
    kilCamInput.closest('form').addEventListener('submit', function(event) {
        // Eliminar los separadores de miles antes de enviar el formulario
        var rawValue = kilCamInput.value.replace(/\./g, '');
        kilCamInput.value = rawValue;
    });

    $(document).ready(function() {
        $('.uppercase').on('input', function() {
            $(this).val(function(i, text) {
                return text.toUpperCase();
            });
        });
    });
</script>