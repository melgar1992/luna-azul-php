$(document).ready(function () {
    opcion = '';
    document.title = 'Luna Azul| Productos';
    Dropzone.autoDiscover = false;
    $("#imagenes_productos").dropzone({
        url: base_url + "Productos/subirImagenes",
        addRemoveLinks: true,
        autoProcessQueue: true,
        paramName: 'userfile',
        init: function () {

        },
        success: function (file, response) {
            var imgName = response;
            file.previewElement.classList.add("dz-success");
            console.log("Successfully uploaded :" + imgName);
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