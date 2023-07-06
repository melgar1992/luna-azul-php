$(document).ready(function () {
    opcion = '';
    document.title = 'Luna Azul | Productos';
    Dropzone.autoDiscover = false;
    var imagenes = new Array;
    //Tabla de los productos
    var tabla = $('#tablaProductos').DataTable({
        responsive: true,
        pageLength: 25,
        ajax: { url: base_url + "Productos/obtenerProductosAjax", dataSrc: "" },
        columns: [
            {
                data: 'imagen',
                render: function (data) {
                    return '<img src="' + base_url + './application/imgs/productos/' + data + '" width="60" height="60">';
                }
            },
            { data: 'nombre' },
            { data: 'categoria' },
            { data: 'descripcion' },
            {
                data: 'id_producto',
                render: function (data) {
                    return "<div class='text-right'> <div class='btn-group'><button class='btn btn-warning btn-sm' value='" + data + "' id='btn-editar'><i class='fas fa-pencil-alt'></i> Editar</button><button class='btn btn-danger btn-sm' value='" + data + "' id='btn-borrar'><i class='fas fa-trash-alt'></i> Borrar</button></div></div>";
                }
            }
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
    //Dropzone para el manejo de archivos
    $("#imagenes_productos").dropzone({
        url: base_url + "Productos/subirImagenes",
        addRemoveLinks: true,
        autoProcessQueue: false,
        parallelUploads: 5,
        paramName: 'userfile',
        maxFiles: 5,
        maxFilesize: 5,
        init: function () {
            var myDropzone = this;
            $('#formulario').submit(function (e) {
                e.preventDefault();
                e.stopPropagation();
                myDropzone.processQueue();
            });
            // limpiar al cerrar
            $(document).on('hidden.bs.modal', '#modal-form', function () {
                myDropzone.removeAllFiles(true);
                LimpiarFormulario();
            });
            myDropzone.on('addedfile', file => {
                console.log(file);
            });
            $(document).on("click", '#btn-editar', function () {
                console.log('Entro a editar desde dropzone');
                fila = $(this).closest('tr');
                id_producto = this.value;
                $.ajax({
                    type: "post",
                    url: "Productos/obtenerImagenesProducto",
                    data: { id_producto: id_producto },
                    dataType: "json",
                    success: function (imagenes) {
                        imagenes.forEach(imagen => {
                            var mockFile = { name: imagen.name, size: 2000 };
                            myDropzone.emit("addedfile", mockFile);
                            myDropzone.emit("thumbnail", mockFile, imagen.path);
                            // myDropzone.emit("complete", mockFile);
                        });
                    }
                });
                $.ajax({
                    type: "POST",
                    url: base_url + "Productos/obtenerProductoAjax",
                    data: {
                        id_producto: id_producto
                    },
                    dataType: "json",
                    success: function (respuesta) {
                        $("#id_categorias option[value=" + respuesta['id_categorias'] + "]").attr("selected", true);
                        $('#nombre').val(respuesta['nombre']);
                        $('#descripcion').text(respuesta['descripcion']);
                    }
                });
                $('.modal-title').text('Editar Producto');
                $('#password').removeAttr('required');
                $('#modal-form').modal('show');
                opcion = 'editar';
            });
            this.on("success", function (file, response) {
                // var imgName = response;
                imagenes.push(response);
                file.previewElement.classList.add("dz-success");
            });
            this.on('errormultiple', function (file, response) {
                var error = response;
                file.previewElement.classList.add("dz-error");
                console.log('entro al error' + error);
            });
            this.on("queuecomplete", function (file, response) {
                this.removeAllFiles(true);
                guardarProducto(imagenes);
                imagenes = [];
            });
        },
    });

    //Botton editar cargo
    // $(document).on("click", '#btn-editar', function () {
    //     fila = $(this).closest('tr');
    //     id_producto = this.value;
    //     $('.modal-title').text('Editar Producto');
    //     $('#password').removeAttr('required');
    //     $('#modal-form').modal('show');
    //     $.ajax({
    //         type: "POST",
    //         url: base_url + "Productos/obtenerProductoAjax",
    //         data: {
    //             id_producto: id_producto
    //         },
    //         dataType: "json",
    //         success: function (respuesta) {
    //             $("#id_categorias option[value=" + respuesta['id_categorias'] + "]").attr("selected", true);
    //             $('#nombre').val(respuesta['nombre']);
    //             $('#descripcion').text(respuesta['descripcion']);
    //         }
    //     });
    //     opcion = 'editar';
    // });
    function guardarProducto(files) {
        // console.log('Entro a guardar producto');
        id_categorias = $.trim($('#id_categorias').val());
        nombre = $.trim($('#nombre').val());
        descripcion = $.trim($('#descripcion').val());
        if (opcion != 'editar') {
            $.ajax({
                type: "POST",
                url: base_url + "Productos/ingresarProducto",
                data: {
                    id_categorias: id_categorias,
                    nombre: nombre,
                    descripcion: descripcion,
                    files: files,
                },
                dataType: "json",
                success: function (respuesta) {
                    // console.log(respuesta);
                    if (respuesta['respuesta'] === 'Exitoso') {
                        id_producto = respuesta['datos']['id_producto'];
                        categoria = respuesta['datos']['categoria'];
                        nombre = respuesta['datos']['nombre'];
                        descripcion = respuesta['datos']['descripcion'];
                        imagen = respuesta['datos']['imagen'];
                        tabla.row.add({
                            'imagen': imagen,
                            "nombre": nombre,
                            "descripcion": descripcion,
                            "categoria": categoria,
                            "id_producto": id_producto,
                        }).draw();
                        swal({
                            title: 'Guardar',
                            text: JSON.stringify(respuesta['mensaje']),
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
                url: base_url + "Usuarios/actualizarUsuario",
                data: {
                    id_usuario: id_usuario,
                    ci: ci,
                    nombres: nombres,
                    apellidos: apellidos,
                    username: username,
                    password: password,
                    id_roles: id_roles,
                    telefono: telefono,
                },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta['respuesta'] === 'Exitoso') {
                        id_usuario = respuesta['datos']['id_usuarios'];
                        id_producto = respuesta['datos']['id_producto'];
                        nombre_completo = respuesta['datos']['nombre_completo'];
                        ci = respuesta['datos']['ci'];
                        nombre = respuesta['datos']['nombre'];
                        username = respuesta['datos']['username'];
                        telefono = respuesta['datos']['telefono'];
                        tabla.row(fila).data({
                            "id_usuarios": id_usuario,
                            "id_producto": id_producto,
                            "nombre_completo": nombre_completo,
                            "ci": ci,
                            "nombre": nombre,
                            "username": username,
                            "telefono": telefono,
                        }).draw();
                        swal({
                            title: 'Editado',
                            text: respuesta['message'],
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

    }
    //Eliminar button
    $(document).on('click', '#btn-borrar', function () {
        Swal.fire({
            title: 'Esta seguro de elimar?',
            text: "el producto se eliminara, una vez eliminado no se recuperara!",
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
                    url: base_url + "Productos/borrar/" + id,
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
    $('.modal-title').text('Formulario Producto');
    $("#id_categorias option:selected").removeAttr("selected");
    $('#descripcion').text('');
    $('#formulario').trigger('reset');
    opcion = '';
};
function obtenerImagenes(id_producto) {
    $.ajax({
        type: "post",
        url: "Productos/obtenerImagenesProducto",
        data: { id_producto: id_producto },
        dataType: "json",
        success: function (response) {
            console.log(response);
            return response;
        }
    });
}