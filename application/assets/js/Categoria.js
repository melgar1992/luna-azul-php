$(document).ready(function () {
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
                    return "<div class='text-right'> <div class='btn-group'><button class='btn btn-warning btn-sm' value='"+ data +"' id='btn-editar'><i class='fas fa-pencil-alt'></i> Editar</button><button class='btn btn-danger btn-sm' value='"+ data +"' id='btn-borrar'><i class='fas fa-trash-alt'></i> Borrar</button></div></div>";
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

    $(document).on("click", '#btn-editar', function () {
        alert(this.value);
    });
    $(document).on("click", '#btn-borrar', function () {
        alert(this.value);
    });
});