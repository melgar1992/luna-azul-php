$(document).ready(function () {
    opcion = '';
    document.title = 'Luna Azul| Productos';
    Dropzone.autoDiscover = false;
    var imagenes = new Array;
    var tabla = $('#tablaProductos').DataTable({
        responsive: true,
        pageLength: 25,
        ajax: { url: base_url + "Productos/obtenerProductosAjax", dataSrc: "" },
        columns: [
            { data: 'nombre' },
            {data: 'categoria'},
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
            this.on("success", function (file, response) {
                // var imgName = response;
                imagenes.push(response);
                file.previewElement.classList.add("dz-success");
                // console.log("Successfully uploaded :" + imgName);
                // console.log(imagenes);
                // guardarProducto(imgName);
            });
            this.on('errormultiple', function (file, response) {
                var error = response;
                file.previewElement.classList.add("dz-error");
                console.log('entro al error' + error);
            });
            this.on("queuecomplete", function (file, response) {
                // this.removeAllFiles(true);
                console.log('entro! succes multiple');
                console.log(imagenes);
                guardarProducto(imagenes);
                imagenes = [];
            });
        },
    });
    $('#btn-guardar').submit(function (e) {
        e.preventDefault();
        console.log('Entro!!');
    });

    function guardarProducto(files) {
        console.log('Entro a guardar producto');
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
                    if (respuesta['respuesta'] === 'Exitoso') {
                        console.log(respuesta);

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
                        nombre_completo = respuesta['datos']['nombre_completo'];
                        ci = respuesta['datos']['ci'];
                        nombre = respuesta['datos']['nombre'];
                        username = respuesta['datos']['username'];
                        telefono = respuesta['datos']['telefono'];
                        tabla.row(fila).data({
                            "id_usuarios": id_usuario,
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
});

function guardarImagenes(files) {

}

function LimpiarFormulario() {
    $('#modal-form').modal('hide');
    $('.modal-title').text('Formulario Producto');
    $("#id_categorias option:selected").removeAttr("selected");
    $('#formulario').trigger('reset');
    opcion = '';
};
