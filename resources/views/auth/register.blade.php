@extends('layouts.app')
{{--@php dump($errors ? $errors : 'nada') @endphp--}}
{{--@php dump(old('carrera') ) @endphp--}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading"><i class="fa fa-user"></i> Registrar Usuario</div>

                    <div class="panel-body">
                        <form class="" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }} label-floating">
                                        <label for="nombre" class="col-md-4 control-label">Nombre</label>

                                        <input id="nombre" type="text" class="form-control" name="nombre"
                                               value="{{ old('nombre') }}" required autofocus>

                                        @if ($errors->has('nombre'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('apellido') ? ' has-error' : '' }} label-floating">
                                        <label for="apellido" class="col-md-4 control-label">Apellido</label>

                                        <input id="apellido" type="text" class="form-control" name="apellido"
                                               value="{{ old('apellido') }}" required>

                                        @if ($errors->has('apellido'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('apellido') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} label-floating">
                                        <label for="email" class="col-md-7 control-label">E-Mail</label>

                                        <input id="email" type="email" class="form-control" name="email"
                                               value="{{ old('email') }}" required>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-4">

                                    <div class="form-group{{ $errors->has('rol') ? ' has-error' : '' }} label-floating">
                                        <label for="rol" class="col-md-4 control-label">Rol</label>

                                        <select class="selectpicker show-tick" data-style="select-with-transition"
                                                title="Seleccione" data-size="5" style="    margin-top: 2px;" name="rol"
                                                id="rol">
                                            <option disabled="">Seleccione</option>
                                            <option value="2" {{ old('rol') == 2 ? 'selected' : ''  }}>Coordinador</option>
                                        </select>

                                        @if ($errors->has('rol'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('rol') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                {{--@php dump($data) @endphp--}}
                                <div class="col-sm-4">

                                    <div class="form-group{{ $errors->has('carrera') ? ' has-error' : '' }} label-floating">
                                        <label for="carrera" class="col-md-4 control-label">Carrera</label>

                                        <select class="selectpicker show-tick" name="carrera" id="carrera"
                                                data-style="select-with-transition" title="Seleccione" data-size="5"
                                                style="    margin-top: 2px;">
                                            <option disabled="">Seleccione</option>
                                            @foreach($data['carreras'] as $carrera)
                                                <option value="{{ $carrera['id'] }}" {{ old('carrera') == $carrera['id'] ? 'selected' : ''  }} >{{ $carrera['nombre'] }}</option>
                                            @endforeach

                                        </select>

                                        @if ($errors->has('carrera'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('carrera') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} label-floating">
                                        <label for="password" class="col-md-4 control-label">Password</label>

                                        <input id="password" type="password" class="form-control" name="password"
                                               required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group label-floating">
                                        <label for="password-confirm" class="col-md-7 control-label">Confirm
                                            Password</label>

                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-info">
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
