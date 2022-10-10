$(document).ready(function () {
    opcion = '';
    document.title = 'Luna azul |Categorias de productos';
    var tabla = $('#tablaCategorias').DataTable({
        responsive: true,
        pageLength: 25,
        ajax: { url: base_url + "Categoria/obtenerCategoriasAjax", dataSrc: "" },
        columns: [
            { data: 'nombre' },
            { data: 'descripcion' },
            {
                data: 'id_categorias',
                render: function (data) {
                    return "<div class='text-right'> <div class='btn-group'><button class='btn btn-warning btn-sm' value='" + data + "' id='btn-editar'><i class='fas fa-pencil-alt'></i> Editar</button><button class='btn btn-danger btn-sm' value='" + data + "' id='btn-borrar'><i class='fas fa-trash-alt'></i> Borrar</button></div></div>";
                }
            }
        ],
        "order": [
            [0, "desc"]
        ],
        "language": {
            'lengthMenu': "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registro",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Ultimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior",

            },
            "sProcesing": "Procesando...",
        }
    });
    // limpiar al cerrar
    $('#modal-form').on('hidden.bs.modal', function () {
        LimpiarFormulario();
    });
    //Botton editar cargo
    $(document).on("click", '#btn-editar', function () {
        fila = $(this).closest('tr');
        id_categorias = this.value;
        $('.modal-title').text('Editar Categoria');
        $('#password').removeAttr('required');
        $('#modal-form').modal('show');
        $.ajax({
            type: "POST",
            url: base_url + "Categoria/obtenerCategoriaAjax",
            data: {
                id_categoria: id_categorias
            },
            dataType: "json",
            success: function (respuesta) {
                $('#nombre').val(respuesta['nombre']);
                $('#descripcion').text(respuesta['descripcion']);

            }
        });
        opcion = 'editar';
    });
    //ingresar o editar Usuario
    $('#formulario').submit(function (e) {
        e.preventDefault();
        nombre = $.trim($('#nombre').val());
        descripcion = $.trim($('#descripcion').val());
        $('#modal-form').modal('hide');
        if (opcion != 'editar') {
            $.ajax({
                type: "POST",
                url: base_url + "Categoria/ingresarCategoria",
                data: {
                    nombre: nombre,
                    descripcion: descripcion,
                },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta['respuesta'] === 'Exitoso') {
                        id_categorias = respuesta['datos']['id_categorias'];
                        nombre = respuesta['datos']['nombre'];
                        descripcion = respuesta['datos']['descripcion'];
                        tabla.row.add({
                            "nombre": nombre,
                            "descripcion": descripcion,
                            "id_categorias": id_categorias,
                        }).draw();
                        swal({
                            title: 'Guardar',
                            text: respuesta['mensaje'],
                            type: 'success'
                        });
                        LimpiarFormulario();
                    } else {
                        swal({
                            title: 'Error',
                            text: respuesta['mensaje'],
                            type: 'error'
                        });
                    }
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: base_url + "Categoria/actualizarCateogira",
                data: {
                    id_categorias: id_categorias,
                    nombre: nombre,
                    descripcion: descripcion,
                },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta['respuesta'] === 'Exitoso') {
                        id_categorias = respuesta['datos']['id_categorias'];
                        nombre = respuesta['datos']['nombre'];
                        descripcion = respuesta['datos']['descripcion'];
                        tabla.row(fila).data({
                            "nombre": nombre,
                            "descripcion": descripcion,
                            "id_categorias": id_categorias,
                        }).draw();
                        swal({
                            title: 'Editado',
                            text: respuesta['mensaje'],
                            type: 'success'
                        });
                        LimpiarFormulario();
                    } else {
                        swal({
                            title: 'Error',
                            text: respuesta['mensaje'],
                            type: 'error'
                        });
                    }
                }
            });
        }
    });
    //Eliminar Categoria
    $(document).on('click', '#btn-borrar', function () {
        Swal.fire({
            title: 'Esta seguro de elimar?',
            text: "La categoria se eliminara, una vez eliminado no se recuperara!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, deseo elimniar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {

                fila = $(this).closest('tr');
                id = this.value;
                $.ajax({
                    url: base_url + "Categoria/borrar/" + id,
                    type: 'POST',
                    dataType: "json",
                    success: function (respuesta) {
                        if (respuesta['respuesta'] === 'Exitoso') {
                            tabla.row(fila).remove().draw();
                            swal({
                                title: 'Eliminado',
                                text: 'Se borro correctamente',
                                type: 'success'
                            });
                        } else {
                            swal({
                                title: 'Error',
                                text: 'Ocurrio un error al eliminar',
                                type: 'error'
                            });
                        }

                    }
                })


            }
        })

    })

});

function LimpiarFormulario() {
    $('#modal-form').modal('hide');
    $('.modal-title').text('Formulario Categoria');
    $('#descripcion').text('');
    $('#formulario').trigger('reset');
    opcion = '';
};