<div class="box box-info padding-1">
    <div class="box-body">
        
    <div class="form-group">
    {{ Form::label('Código') }}
    {{ Form::text('cod_sis', $sistema->cod_sis, ['class' => 'form-control' . ($errors->has('cod_sis') ? ' is-invalid' : ''), 'pattern' => '[0-9]{2}', 'maxlength' => '2', 'placeholder' => '11']) }}
    {!! $errors->first('cod_sis', '<div class="invalid-feedback">:message</div>') !!}
    </div>
        <div class="form-group">
            {{ Form::label('Nombre') }}
            {{ Form::text('nom_sis', $sistema->nom_sis, ['class' => 'form-control' . ($errors->has('nom_sis') ? ' is-invalid' : '')]) }}
            {!! $errors->first('nom_sis', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20 text-center">
        <button type="submit" class="btn btn-outline-success btn-sm custom-btn">{{ __('Guardar') }}</button>
        <a href="  {{ route('sistemas.index') }}" class="btn  btn-outline-danger btn-sm custom-btn">Cancelar</a>
    </div>
</div>