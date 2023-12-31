@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Ver Camion</h1>
@stop

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-right">
                            <a class="btn btn-secundary border border-secondary btn-sm" href="{{ route('camiones.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Placa:</strong>
                            {{ $camione->pla_cam }}
                        </div>
                        <div class="form-group">
                            <strong>Marca:</strong>
                            {{ $camione->mar_cam }}
                        </div>
                        <div class="form-group">
                            <strong>Modelo:</strong>
                            {{ $camione->mod_cam }}
                        </div>
                        <div class="form-group">
                            <strong>Tipo:</strong>
                            {{ $camione->tip_cam }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            <span class="estado-camion {{ str_replace(' ', '-', $camione->est_cam) }}">
                                <div class="estado-camion-box">
                                    {{ $camione->est_cam }}
                                </div>
                            </span>
                        </div>
                        <div class="form-group">
                            <strong>Número de ejes:</strong>
                            {{ $camione->num_eje_cam }}
                        </div>
                        <div class="form-group">
                            <strong>Kilometraje:</strong>
                            {{ $camione->kil_cam }}
                        </div>
                        <div class="form-group">
                            <strong>Capacidad</strong>
                            {{ $camione->cap_cam }}
                        </div>
                        <div class="form-group">
                            <strong>Conductor:</strong>
                            {{ $camione->conductore->nom_con }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .estado-camion.disponible {
            background-color: green;
            color: white;
        }
        .estado-camion.en-mantenimiento {
            background-color: yellow;
            color: black;
        }
        .estado-camion.fuera-de-servicio {
            background-color: red;
            color: white;
        }
        .estado-camion-box {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
        }
    </style>
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
