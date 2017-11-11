@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Registro de paciente</div>

                <div class="panel-body">
                   
                    <form class="form-horizontal" method="POST" action="{{ url('habitaciones/crear') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('Habitacion_Numero') ? ' has-error' : '' }}">
                            <label for="Habiracion_Area" class="col-md-4 control-label">Numero de habitacion</label>

                            <div class="col-md-6">
                                <input id="Habitacion_numero" type="text" pattern="[0-9]+" class="form-control" name="Habitacion_Numero" value="{{ old('Habitacion_Numero') }}" required autofocus>

                                @if ($errors->has('Habitacion_Numero'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('habitacion_Numero') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('Habitacion_Area') ? ' has-error' : '' }}">
                            <label for="Habiracion_Area" class="col-md-4 control-label">Area de habitacion</label>

                            <div class="col-md-6">
                                <input id="Habitacion_Area" type="textarea" class="form-control" name="Habitacion_Area" value="{{ old('Habitacion_Area') }}" required autofocus>

                                @if ($errors->has('Habitacion_Area'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Habitacion_Area') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('Disponible') ? ' has-error' : '' }}">
                            <label for="dom" class="col-md-4 control-label">Domicilio</label>

                            <div class="col-md-6">
                                <input id="Disponible" type="checkbox" class="form-control" name="Disponible" value="{{ old('Disponible') }}">

                                @if ($errors->has('Disponible'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Disponible') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Registrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection