$(document).ready(function () {
    $('#categoriasTable').DataTable({
        "language": {
            "processing": "Procesando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "infoPostFix": "",
            "search": "Búsqueda:",
            "url": "",
            "infoThousands": ",",
            "loadingRecords": "Cargando...",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        // "order": [[ 6, "desc" ]]
    });
    $('#proyectosTable').DataTable({
        "language": {
            "processing": "Procesando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "infoPostFix": "",
            "search": "Búsqueda:",
            "url": "",
            "infoThousands": ",",
            "loadingRecords": "Cargando...",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
        // "order": [[ 6, "desc" ]]
    });
    $('#busquedaAvanTable').DataTable({
        "language": {
            "processing": "Procesando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "infoPostFix": "",
            "search": "Búsqueda:",
            "url": "",
            "infoThousands": ",",
            "loadingRecords": "Cargando...",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        // "order": [[ 6, "desc" ]]
    });

});

var remove = function (id) {
    $('#tr' + id).remove();
    $('#categoriasTable').DataTable().ajax.reload();
};

var guardarCategoria = function () {
    var nombre = $('#nombrecat'),
        carrera = $('#carrera'),
        alert = $('#success-alert');

    console.log(carrera.val());

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: $('#urlGuardarCategoria').val(),
        data: {
            nombre: nombre.val(),
            carrera: carrera.val()
        },
        error: function () {
            $('#info').html('<p>An error has occurred</p>');
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);

            if (data.success === true) {
                nombre.val('');
                nombre.trigger('change');
                $('#addCategoryModal').modal('hide');
                alert.html('');
                alert.removeClass('alert-danger');
                alert.addClass('alert-success');
                alert.append('<strong>Registro guardado exitosamente.</strong>');
                alert.fadeTo(2000, 500).slideUp(500, function () {
                    alert.slideUp(500);
                });

                consultarCategorias();
            } else {
                $('#addCategoryModal').modal('hide');
                alert.html('');
                alert.removeClass('alert-success');
                alert.addClass('alert-danger');
                var msj = data.response;
                console.log(msj);
                alert.append('<strong>Ha ocurrido un error al momento de guardar del registro. Los siguientes campos son requeridos:<ul><li>Nombre de la Categoria.</li></ul></strong>');

                alert.fadeTo(3000, 800).slideUp(800, function () {
                    alert.slideUp(800);
                });
            }

        },
        type: 'POST'
    });
};

var consultarCategorias = function () {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: $('#urlConsultarCategoria').val(),

        error: function () {
            $('#info').html('<p>An error has occurred</p>');
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            var table = $('#categoriasTable').DataTable();

            table.rows().remove().draw();
            $.each(data, function (index, value) {
                table.rows.add($(
                    '<tr id="tr' + value.id + '"><td>' + value.nombre + '</td><td><button type="button" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs" onclick="showMsjModal(' + value.id + ', ' + 2 + ')"><i class="fa fa-times"></i></button></td></tr>'
                )).draw();
            });
            $('[rel="tooltip"]').tooltip();
        },
        type: 'POST'
    });
};

var showMsjModal = function (id, funcion) {
    $('#msjLabel').html('Eliminar Registro');
    var modal = $('#msjModal'),
        button = $('#masterButton');
    modal.find('.modal-body').html('¿Está seguro que desea eliminar el registro seleccionado?');
    button.html('Eliminar');
    if (funcion === 1) {
        button.unbind('click').bind('click', function (e) {
            deleteProject(id);
        });
    } else if (funcion === 2) {

        button.unbind('click').bind('click', function (e) {
            deleteCategory(id);
        });
    }
    modal.modal('show');
};

var showMsjModalEmail = function (id) {
    var modal = $('#sendFileModal'),
        idProyecto = $('#idProyecto');

    idProyecto.val(id);
    modal.modal('show');
};

var deleteCategory = function (id) {
    var alert = $('#success-alert');
    // $('#msjModal').modal('hide');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: $('#urlEliminarCategoria').val(),
        data: {
            id: id
        },
        error: function () {
            alert.html('<p>An error has occurred</p>');
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $('#msjModal').modal('hide');
            alert.html('');
            if (data.eliminado === 0) {
                alert.removeClass('alert-success');
                alert.addClass('alert-danger');
            }
            alert.append('<strong>' + data.msj + '</strong>');


            alert.fadeTo(2000, 500).slideUp(500, function () {
                alert.slideUp(500);
            });
            // $('#tr' + id).remove();
            consultarCategorias();
        },
        type: 'POST'
    });
};

var guardarProyecto = function () {

    var nombre = $('#nombreProyecto'),
        categoria = $('#categoriaProyecto'),
        autores = $('#autoresProyecto'),
        alert = $('#success-alert'),
        nombreArchivo = $('#nombreArchivo');

    var datos = new FormData();
    jQuery.each(jQuery('#archivo')[0].files, function (i, file) {
        datos.append('archivo', file);
        datos.append('nombre', nombre.val());
        datos.append('categoria', categoria.val());
        datos.append('autores', autores.val());
    });

    if ($("#archivo")[0].files.length > 0) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#urlGuardarProyecto').val(),
            data: datos,
            processData: false,
            contentType: false,
            type: 'POST',
            error: function () {
                $('#info').html('<p>An error has occurred</p>');
            },
            success: function (response) {
                console.log(response);

                if (response.success === true) {
                    nombre.val('');
                    nombre.trigger('change');
                    categoria.val('');
                    categoria.trigger('change');
                    autores.val('');
                    autores.trigger('change');
                    nombreArchivo.val('');
                    nombreArchivo.trigger('change');
                    $('#addProjectModal').modal('hide');
                    alert.html('');
                    alert.append('<strong>Registro guardado exitosamente.</strong>');
                    alert.fadeTo(2000, 500).slideUp(500, function () {
                        alert.slideUp(500);
                    });

                    consultaProyectos();

                } else {
                    $('#addProjectModal').modal('hide');
                    alert.html('');
                    alert.removeClass('alert-success');
                    alert.addClass('alert-danger');
                    var msj = response.response;
                    console.log(msj);
                    alert.append('<strong>Ha ocurrido un error al momento de guardar del registro. Los siguientes campos son requeridos:<ul><li>Nombre del Proyecto.</li><li>Categoría del Proyecto</li><li>Autores del Proyecto</li><li>Archivo digital en formato PDF, DOC o DOCX del Proyecto.</li></ul></strong>');

                    alert.fadeTo(3000, 800).slideUp(800, function () {
                        alert.slideUp(800);
                    });
                }
            }
        });
    } else {
        $('#addProjectModal').modal('hide');
        alert.html('');
        alert.removeClass('alert-success');
        alert.addClass('alert-danger');
        alert.append('<strong>Debe llenar el formulario con los datos correspondientes.</strong>');
        alert.fadeTo(2000, 500).slideUp(500, function () {
            alert.slideUp(500);
        });
    }
};

var proyectoPorID = function (id) {
    var nombre = $('#editnombreProyecto'),
        categoria = $('#editcategoriaProyecto'),
        autores = $('#editautoresProyecto'),
        modal = $('#editProjectModal'),
        idProyecto = $('#idProyecto'),
        alert = $('#success-alert');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: $('#urlConsultarProyectoPorID').val(),
        data: {
            id: id
        },
        error: function () {
            alert.html('<p>An error has occurred</p>');
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);

            $.each(data, function (index, value) {
                idProyecto.val(value.id);
                nombre.val(value.nombre);
                nombre.trigger('change');
                autores.val(value.autores);
                console.log(value.categoria_id);
                /*categoria.find('option:selected').removeAttr('selected');
                categoria.find("option[value='" + value.categoria_id + "']").attr("selected","selected");*/
                categoria.val(value.categoria_id);
            });

            modal.modal('show');

        },
        type: 'POST'
    });
};

var editarProyecto = function (id) {
    console.log(id);
    var nombre = $('#editnombreProyecto'),
        categoria = $('#editcategoriaProyecto'),
        autores = $('#editautoresProyecto'),
        alert = $('#success-alert'),
        nombreArchivo = $('#editnombreArchivo');

    var datos = new FormData();
    jQuery.each(jQuery('#editarchivo')[0].files, function (i, file) {
        datos.append('archivo', file);
        datos.append('nombre', nombre.val());
        datos.append('categoria', categoria.val());
        datos.append('autores', autores.val());
        datos.append('id', id);
    });

    if ($("#editarchivo")[0].files.length > 0) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#urlEditarProyecto').val(),
            data: datos,
            processData: false,
            contentType: false,
            type: 'POST',
            error: function () {
                $('#info').html('<p>An error has occurred</p>');
            },
            success: function (response) {
                console.log(response);

                if (response.success === true) {
                    nombre.val('');
                    nombre.trigger('change');
                    categoria.val('');
                    categoria.trigger('change');
                    autores.val('');
                    autores.trigger('change');
                    nombreArchivo.val('');
                    nombreArchivo.trigger('change');
                    $('#editProjectModal').modal('hide');
                    alert.html('');
                    alert.append('<strong>Registro guardado exitosamente.</strong>');
                    alert.fadeTo(2000, 500).slideUp(500, function () {
                        alert.slideUp(500);
                    });

                    consultaProyectos();

                } else {
                    $('#editProjectModal').modal('hide');
                    alert.html('');
                    alert.removeClass('alert-success');
                    alert.addClass('alert-danger');
                    var msj = response.response;
                    console.log(msj);
                    alert.append('<strong>Ha ocurrido un error al momento de guardar del registro. Los siguientes campos son requeridos:<ul><li>Nombre del Proyecto.</li><li>Categoría del Proyecto</li><li>Autores del Proyecto</li><li>Archivo digital en formato PDF, DOC o DOCX del Proyecto.</li></ul></strong>');

                    alert.fadeTo(3000, 800).slideUp(800, function () {
                        alert.slideUp(800);
                    });
                }
            }
        });
    } else {
        $('#editProjectModal').modal('hide');
        alert.html('');
        alert.removeClass('alert-success');
        alert.addClass('alert-danger');
        alert.append('<strong>Debe llenar el formulario con los datos correspondientes.</strong>');
        alert.fadeTo(2000, 500).slideUp(500, function () {
            alert.slideUp(500);
        });
    }
};

var deleteProject = function (id) {
    var alert = $('#success-alert');
    // $('#msjModal').modal('hide');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: $('#urlEliminarProyecto').val(),
        data: {
            id: id
        },
        error: function () {
            alert.html('<p>An error has occurred</p>');
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $('#msjModal').modal('hide');
            alert.html('');
            if (data.eliminado === 0) {
                alert.removeClass('alert-success');
                alert.addClass('alert-danger');
            }
            alert.append('<strong>' + data.msj + '</strong>');


            alert.fadeTo(2000, 500).slideUp(500, function () {
                alert.slideUp(500);
            });
            // $('#tr' + id).remove();
            consultaProyectos();
        },
        type: 'POST'
    });
};

var enviarArchivo = function (id) {
    var alert = $('#success-alert'),
        email = $('#enviarArchivo');

    console.log(id);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: $('#urlEnviarProyectoEmail').val(),
        data: {
            id: id,
            email: email.val()
        },
        error: function () {
            alert.html('<p>An error has occurred</p>');
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $('#sendFileModal').modal('hide');
            alert.html('');
            if (data.success === false) {
                alert.removeClass('alert-success');
                alert.addClass('alert-danger');
                alert.append('<strong>Ocurrió un error al momento de enviar el correo. Por favor intente de nuevo.</strong>');
            } else {
                email.val('');
                email.trigger('change');
                alert.removeClass('alert-danger');
                alert.addClass('alert-success');
                alert.append('<strong>Correo enviado con éxito.</strong>');
            }


            alert.fadeTo(2000, 500).slideUp(500, function () {
                alert.slideUp(500);
            });
        },
        type: 'POST'
    });
};

var consultaProyectos = function () {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: $('#urlConsultarProyecto').val(),

        error: function () {
            $('#info').html('<p>An error has occurred</p>');
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            var table = $('#proyectosTable').DataTable();
            var urlArchivo = $('#urlArchivos').val();
            // table.rows().remove().draw();
            table.clear().draw();

            $.each(data, function (index, value) {
                console.log(value.nombre);
                table.rows.add($(
                    '<tr id="tr' + value.id + '"><td>' + value.nombre + '</td><td>' + value.categoria.nombre + '</td><td>' + value.autores + '</td><td class="td-actions text-right"><button type="button" rel="tooltip" title="Editar" class="btn btn-info btn-simple btn-xs" onclick="proyectoPorID(' + value.id + ')"><i class="fa fa-edit"></i></button><a href="' + value.archivo + '" type="button" rel="tooltip" title="Ver Archivo" class="btn btn-success btn-simple btn-xs" target="_blank"><i class="fa fa-eye"></i></a><button type="button" rel="tooltip" title="Enviar por Correo" class="btn btn-primary btn-simple btn-xs" onclick="showMsjModalEmail(' + value.id + ')"><i class="fa fa-envelope"></i></button><button type="button" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs" onclick="showMsjModal(' + value.id + ', ' + 1 + ')"><i class="fa fa-times"></i></button></td></tr>'
                )).draw();
            });
            table.columns.adjust().draw();
            $('[rel="tooltip"]').tooltip();
        },
        type: 'POST'
    });
};

var inputFile = function () {
    var archivo = $('#archivo'),
        nombreArchivo = $('#nombreArchivo');
    archivo.click();
    archivo.change(function () {
        if (archivo.val() === '') {
            nombreArchivo.val('')
        } else {
            nombreArchivo.val(archivo[0].files[0].name)
        }
    });
};

var inputFileEdit = function () {
    var archivo = $('#editarchivo'),
        nombreArchivo = $('#editnombreArchivo');
    archivo.click();
    archivo.change(function () {
        if (archivo.val() === '') {
            nombreArchivo.val('')
        } else {
            nombreArchivo.val(archivo[0].files[0].name)
        }
    });
};

var busquedaAvanzada = function () {
    var tableDiv = $('#resultBusqueda'),
        nombre = $('#searchProyecto'),
        categoria = $('#searchCategoria'),
        autores = $('#searchAutores'),
        carrera = $('#carrera');
    var noResults = $('#noResults');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: $('#urlBusquedaAvanzada').val(),
        data: {
            nombre: nombre.val(),
            categoria: categoria.val(),
            autores: autores.val(),
            carrera: carrera.val()
        },
        error: function () {
            $('#info').html('<p>An error has occurred</p>');
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            var table = $('#busquedaAvanTable').DataTable();
            var urlArchivo = $('#urlArchivos').val();

            if (data.success === true) {
                table.clear().draw();

                $.each(data.result, function (index, value) {
                    console.log(value.nombre);
                    table.rows.add($(
                        '<tr><td>' + value.nombre + '</td><td>' + value.categoria.nombre + '</td><td>' + value.autores + '</td><td class="td-actions text-right"><button type="button" rel="tooltip" title="Editar" class="btn btn-info btn-simple btn-xs" onclick="proyectoPorID(' + value.id + ')"><i class="fa fa-edit"></i></button><a href="' + urlArchivo + '/' + value.nombre_archivo + '" type="button" rel="tooltip" title="Ver Archivo" class="btn btn-success btn-simple btn-xs" target="_blank"><i class="fa fa-eye"></i></a><button type="button" rel="tooltip" title="Enviar por Correo" class="btn btn-primary btn-simple btn-xs" onclick="showMsjModalEmail(' + value.id + ')"><i class="fa fa-envelope"></i></button></td></tr>'
                    )).draw();
                });
                table.columns.adjust().draw();
                $('[rel="tooltip"]').tooltip();
                noResults.hide();
                tableDiv.show();
            } else {
                tableDiv.hide();
                noResults.html('');
                noResults.append('<strong>' + data.msg + '</strong>');
                noResults.show();
            }

        },
        type: 'POST'
    });
};