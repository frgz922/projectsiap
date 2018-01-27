@extends('layouts.app')

@section('content')
    <input type="hidden" id="urlGuardarCategoria" value="{{ route('crearCategoria') }}">
    <input type="hidden" id="urlConsultarCategoria" value="{{ route('consultarCategorias') }}">
    <input type="hidden" id="urlEliminarCategoria" value="{{ route('eliminarCategoria') }}">
    <input type="hidden" id="urlGuardarProyecto" value="{{ route('crearProyecto') }}">
    <input type="hidden" id="urlEditarProyecto" value="{{ route('editarProyecto') }}">
    <input type="hidden" id="urlConsultarProyecto" value="{{ route('consultarProyectos') }}">
    <input type="hidden" id="urlConsultarProyectoPorID" value="{{ route('consultarProyectoPorID') }}">
    <input type="hidden" id="urlEliminarProyecto" value="{{ route('eliminarProyecto') }}">
    <input type="hidden" id="urlEnviarProyectoEmail" value="{{ route('enviarProyectoEmail') }}">
    <input type="hidden" id="urlBusquedaAvanzada" value="{{ route('filterProyectos') }}">
    <input type="hidden" id="urlArchivos" value="{{ asset('storage/') }}">
    <input type="hidden" id="carrera" value="{{ Auth::user()->carrera_id }}">
    <input type="hidden" id="usuario" value="{{ Auth::user()->id }}">


    @if(Auth::user()->coordinador == 1)
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="alert alert-success" id="success-alert" style="display: none">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                    </div>
                    <div class="card card-nav-tabs">
                        <div class="header header-info">
                            <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                    <ul class="nav nav-tabs" data-tabs="tabs">
                                        <li class="active">
                                            <a href="#proyectos" data-toggle="tab" aria-expanded="false">
                                                <i class="material-icons">description</i>
                                                Proyectos
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="#categorias" data-toggle="tab" aria-expanded="true">
                                                <i class="material-icons">view_list</i>
                                                Categorías
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="#busqueAvan" data-toggle="tab" aria-expanded="false">
                                                <i class="material-icons">search</i>
                                                Búsqueda Avanzada
                                                <div class="ripple-container"></div>
                                            </a>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="content">
                            <div class="tab-content text-left">
                                <div class="tab-pane active" id="proyectos">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h4 class="text-primary"><b><i class="fa fa-list-ol"></i> Listado de
                                                    Proyectos</b></h4>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="text-right">
                                                <button type="button" rel="tooltip" title="Agregar Proyecto"
                                                        class="btn btn-success btn-just-icon btn-sm" data-toggle="modal"
                                                        data-target="#addProjectModal">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <table class="table table-condensed table-striped" id="proyectosTable"
                                           style="white-space: nowrap">
                                        <thead>
                                        <tr>
                                            <th>Nombre del Proyecto</th>
                                            <th>Categoría</th>
                                            <th class="text-center">Autores</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['proyectos'] as $proyecto)
{{--                                            @php dump(env('APP_URL').'/storage/'.$proyecto['nombre_archivo'] ) @endphp--}}
                                            <tr>
                                                <td>{{ $proyecto['nombre'] }}</td>
                                                <td>{{ $proyecto['categoria']['nombre'] }}</td>
                                                <td>{{ $proyecto['autores'] }}</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Editar"
                                                            class="btn btn-info btn-simple btn-xs"
                                                            onclick="proyectoPorID({{ $proyecto['id'] }})">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <a href="{{ env('APP_URL').'/storage/'.$proyecto['nombre_archivo'] }}"
                                                       type="button" rel="tooltip" title="Ver Archivo"
                                                       class="btn btn-success btn-simple btn-xs" target="_blank">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <button type="button" rel="tooltip" title="Enviar por Correo"
                                                            class="btn btn-primary btn-simple btn-xs"
                                                            onclick="showMsjModalEmail({{ $proyecto['id'] }})">
                                                        <i class="fa fa-envelope"></i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Eliminar"
                                                            class="btn btn-danger btn-simple btn-xs"
                                                            onclick="showMsjModal('{{ $proyecto["id"] }}', 1)">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="categorias">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h4 class="text-primary"><b><i class="fa fa-list-ol"></i> Listado de
                                                    Categorías</b></h4>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="text-right">
                                                <button type="button" rel="tooltip" title="Agregar Categoría"
                                                        class="btn btn-success btn-just-icon btn-sm" data-toggle="modal"
                                                        data-target="#addCategoryModal">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-condensed table-striped" id="categoriasTable">
                                            <thead>
                                            <tr>
                                                <th>Nombre Categoría</th>
                                                <th>Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data['categorias'] as $categoria)
                                                <tr id="tr{{ $categoria['id'] }}">
                                                    <td>
                                                        {{ $categoria['nombre'] }}
                                                    </td>
                                                    <td class="">
                                                        <button type="button" rel="tooltip" title="Eliminar"
                                                                class="btn btn-danger btn-simple btn-xs"
                                                                onclick="showMsjModal('{{ $categoria["id"] }}', 2)">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="busqueAvan">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating">
                                                <label for="searchProyecto" class="control-label">Nombre
                                                    Proyecto</label>
                                                <input type="text" id="searchProyecto" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating">
                                                <label for="searchAutores" class="control-label">Nombres Autores</label>
                                                <input type="text" id="searchAutores" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating">
                                                <select class="form-control " id="searchCategoria"
                                                        name="searchCategoria">
                                                    <option value="" class="disabled">Seleccione la Categoría</option>
                                                    @foreach($data['categorias'] as $categoria)
                                                        <option value="{{ $categoria['id'] }}">{{ $categoria['nombre'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" id="consultar"
                                                class="btn btn-success btn-sm btn-just-icon" rel="tooltip"
                                                title="Buscar" onclick="busquedaAvanzada()"><i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                    <br>
                                    <div class="text-danger text-center" id="noResults" style="display: none">
                                    </div>
                                    <div id="resultBusqueda" style="display: none">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h4 class="text-primary"><b><i class="fa fa-list-ol"></i> Resultados de
                                                        la
                                                        Búsqueda</b></h4>
                                            </div>
                                        </div>
                                        <br>
                                        <table class="table table-condensed table-striped" id="busquedaAvanTable"
                                               style="white-space: nowrap; width: 100%!important;">
                                            <thead>
                                            <tr>
                                                <th>Nombre del Proyecto</th>
                                                <th>Categoría</th>
                                                <th class="text-center">Autores</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {{--<tr>--}}
                                            {{--<td></td>--}}
                                            {{--<td></td>--}}
                                            {{--<td></td>--}}
                                            {{--<td class="td-actions text-right">--}}
                                            {{--<button type="button" rel="tooltip" title="Editar"--}}
                                            {{--class="btn btn-info btn-simple btn-xs"--}}
                                            {{--onclick="proyectoPorID({{ $proyecto['id'] }})">--}}
                                            {{--<i class="fa fa-edit"></i>--}}
                                            {{--</button>--}}
                                            {{--<a href="{{ asset('storage/'.$proyecto['nombre_archivo'])}}"--}}
                                            {{--type="button" rel="tooltip" title="Ver Archivo"--}}
                                            {{--class="btn btn-success btn-simple btn-xs" target="_blank">--}}
                                            {{--<i class="fa fa-eye"></i>--}}
                                            {{--</a>--}}
                                            {{--<button type="button" rel="tooltip" title="Enviar por Correo"--}}
                                            {{--class="btn btn-primary btn-simple btn-xs"--}}
                                            {{--onclick="showMsjModalEmail({{ $proyecto['id'] }})">--}}
                                            {{--<i class="fa fa-envelope"></i>--}}
                                            {{--</button>--}}
                                            {{--</td>--}}
                                            {{--</tr>--}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Proyectos -->
        <div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-info" id="myModalLabel">Nuevo Proyecto</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group label-floating">
                                    <label for="nombreProyecto" class="control-label">
                                        Nombre del Proyecto
                                    </label>
                                    <input type="text" class="form-control" id="nombreProyecto" name="nombreProyecto">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group label-floating">
                                    <select class="form-control " id="categoriaProyecto" name="categoriaProyecto">
                                        <option value="" class="disabled">Seleccione la Categoría</option>
                                        @foreach($data['categorias'] as $categoria)
                                            <option value="{{ $categoria['id'] }}">{{ $categoria['nombre'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-1">
                                <div class="form-group">
                                    <button class="btn btn-success btn-fab btn-fab-mini btn-round"
                                            onclick="inputFile()">
                                        <i class="material-icons">file_upload</i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm-11">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="nombreArchivo" readonly
                                           placeholder="Seleccionar archivo, formatos: PDF, DOC o DOCX">
                                </div>
                                <input type="file" id="archivo" name="archivo" class="hidden" accept=".pdf,.doc,.docx">
                                <div class="form-group label-floating">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea name="autoresProyecto" id="autoresProyecto" cols="30" rows="3"
                                          class="form-control"
                                          placeholder="Introduzca los estudiantes que participaron en el proyecto"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-info" onclick="guardarProyecto()">Guardar</button>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-info" id="myModalLabel">Editar Proyecto</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group label-floating">
                                    <label for="nombreProyecto" class="control-label">
                                        Nombre del Proyecto
                                    </label>
                                    <input type="text" class="form-control" id="editnombreProyecto"
                                           name="editnombreProyecto">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group label-floating">
                                    <select class="form-control " id="editcategoriaProyecto"
                                            name="editcategoriaProyecto">
                                        <option value="" class="disabled">Seleccione la Categoría</option>
                                        @foreach($data['categorias'] as $categoria)
                                            <option value="{{ $categoria['id'] }}">{{ $categoria['nombre'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-1">
                                <div class="form-group">
                                    <button class="btn btn-success btn-fab btn-fab-mini btn-round"
                                            onclick="inputFileEdit()">
                                        <i class="material-icons">file_upload</i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm-11">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="editnombreArchivo" readonly
                                           placeholder="Seleccionar archivo, formatos: PDF, DOC o DOCX">
                                </div>
                                <input type="file" id="editarchivo" name="editarchivo" class="hidden"
                                       accept=".pdf,.doc,.docx">
                                <div class="form-group label-floating">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea name="editautoresProyecto" id="editautoresProyecto" cols="30" rows="3"
                                          class="form-control"
                                          placeholder="Introduzca los estudiantes que participaron en el proyecto"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="idProyecto" value="">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-info" onclick="editarProyecto($('#idProyecto').val())">
                            Guardar
                        </button>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal fade" id="sendFileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-info" id="myModalLabel">Enviar Archivo</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group label-floating">
                                    <label for="enviarArchivo" class="control-label">Correo Electrónico
                                        Estudiante/Profesor</label>
                                    <input type="text" id="enviarArchivo" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-info" onclick="enviarArchivo($('#idProyecto').val())">
                            Enviar
                        </button>
                    </div>
                </div>
            </div>


        </div>
        {{-- Categorias --}}
        <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-info" id="myModalLabel">Nueva Categoría</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group label-floating">
                                    <label for="nombrecat" class="control-label">Nombre Categoría</label>
                                    <input type="text" id="nombrecat" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-info" onclick="guardarCategoria()">Guardar</button>
                    </div>
                </div>
            </div>


        </div>
    @elseif(Auth::user()->admin == 1)
        <div class="container"></div>
    @endif

@endsection
