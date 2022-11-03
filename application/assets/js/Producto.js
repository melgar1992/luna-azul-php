$(document).ready(function () {
    opcion = '';
    document.title = 'Luna Azul| Productos';
    Dropzone.autoDiscover = false;
    $("#imagenes_productos").dropzone({
        url: base_url + "Productos/subirImagenes",
        addRemoveLinks: true,
        autoProcessQueue: false,
        paramName: 'userfile',
        maxFiles: 5,
        maxFilesize: 5,
        init: function () {
            var myDropzone = this;
            this.on("complete", function (file) {
                this.removeAllFiles(true);
            })
            $('#formulario').submit(function (e) {
                e.preventDefault();
                e.stopPropagation();
                myDropzone.processQueue();

            });
        },
        success: function (file, response) {
            var imgName = response;
            file.previewElement.classList.add("dz-success");
            console.log("Successfully uploaded :" + imgName);
            guardarProducto(imgName);
        },
        error: function (file, response) {
            var error = response;
            file.previewElement.classList.add("dz-error");
            console.log('entro al error' + error);
        },

    });
    $('#btn-guardar').submit(function (e) {
        e.preventDefault();
        console.log('Entro!!');
    });
});
function guardarProducto(files) {

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
                    id_productos = respuesta['datos']['id_productos'];
                    nombre_completo = respuesta['datos']['nombre_completo'];
                    ci = respuesta['datos']['ci'];
                    nombre = respuesta['datos']['nombre'];
                    username = respuesta['datos']['username'];
                    telefono = respuesta['datos']['telefono'];
                    tabla.row.add({
                        "id_usuarios": id_usuario,
                        "nombre_completo": nombre_completo,
                        "ci": ci,
                        "nombre": nombre,
                        "username": username,
                        "telefono": telefono,
                    }).draw();
                    swal({
                        title: 'Guardar',
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
    LimpiarFormulario();
}
function LimpiarFormulario() {
    $('#modal-form').modal('hide');
    $('.modal-title').text('Formulario Producto');
    $("#id_categorias option:selected").removeAttr("selected");
    $('#formulario').trigger('reset');
    opcion = '';
};
