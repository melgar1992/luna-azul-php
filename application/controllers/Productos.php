<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Productos extends BaseController
{
    function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $data = array(
            'categorias' => $this->Categoria_model->obtener_categorias(),
        );
        $this->loadView('Producto', 'formularios/producto/producto_form', $data);
    }
    public function obtenerProductosAjax()
    {

        $productos = $this->Producto_model->obtener_productos();
        echo json_encode($productos);
    }
    public function obtenerProductoAjax()
    {
        $id_producto = $this->input->post('id_producto');
        $producto = $this->Producto_model->obtener_producto($id_producto);
        echo json_encode($producto);
    }
    public function ingresarProducto()
    {
        $nombre = $this->input->post('nombre');
        $descripcion = $this->input->post('descripcion');
        $id_categorias = $this->input->post('id_categorias');
        $files = $this->input->post('files');
        $this->form_validation->set_rules("nombre", "nombre", "required|is_unique[productos.nombre]");
        $this->form_validation->set_rules("id_categorias", "id_categorias", "required");

        // $files2 = json_decode($files[0], true);
        try {
            if ($this->form_validation->run() === false) {
                $respuesta = array(
                    'respuesta' => 'Error',
                    'mensaje' => $this->form_validation->error_array(),
                );
            } else {
                $datosProducto = array(
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'id_categorias' => $id_categorias,
                    'estado' => '1',
                );
                $id_producto = $this->Producto_model->ingresar_producto($datosProducto);
                if ($id_producto) {
                    //se guardan las urls de las imagenes subidas
                    for ($i = 0; $i < count($files); $i++) {
                        $datos = json_decode($files[$i], true);
                        $datos_imagen = array(
                            'id_producto' => $id_producto,
                            'url' => $datos['data']['upload_data']['file_name'],
                        );
                        $this->Imagen_model->ingresar_imagen($datos_imagen);
                    }
                    $primera_imagen = json_decode($files[0], true);
                    // se procede a guardar los datos del producto
                    $categoria = $this->Categoria_model->obtener_categoria($id_categorias);
                    $datosProducto += ['imagen' => $primera_imagen['data']['upload_data']['file_name']];
                    $datosProducto += ['id_producto' => $id_producto];
                    $datosProducto += ['categoria' => $categoria['nombre']];
                    $respuesta = array(
                        'respuesta' => 'Exitoso',
                        'datos' => $datosProducto,
                        'mensaje' => 'Se guardo correctamente',
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'Error',
                        'mensaje' => 'Ocurrio un problema al ingresar los datos base de datos',
                    );
                }
            }
        } catch (Exception  $th) {
            $respuesta = array(
                'respuesta' => 'Error',
                'mensaje' => 'Ocurrio un problema' + $th->getMessage(),
            );
        }
        echo json_encode($respuesta);
    }
    public function subirImagenes()
    {
        $config['upload_path']          = './application/imgs/productos/';
        $config['allowed_types']        = 'jpg|png|jpeg';
        $config['file_name']            = '';
        $config['max_size']             = 1000;
        $config['max_width']            = 2000;
        $config['max_height']           = 2000;

        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());
            $respuesta = array(
                'respuesta' => 'Error',
                'mensaje' => $error,
            );
        } else {
            $data = array('upload_data' => $this->upload->data());
            $respuesta = array(
                'respuesta' => 'Succes',
                'mensaje' => 'Se subio la imagen',
                'data' => $data
            );
        }
        echo json_encode($respuesta);
    }
    public function borrar($id_producto)
    {
        if ($this->Producto_model->eliminar_producto($id_producto)) {
            $respuesta = array(
                'respuesta' => 'Exitoso',
                'message' => 'Se elimino la categoria'
            );
        } else {
            $respuesta = array(
                'respuesta' => 'Error',
                'message' => 'Ups ocurrio un error'
            );
        }

        echo json_encode($respuesta);
    }
    public function obtenerImagenesProducto()
    {

        $lista_imagenes = array();

        $id_producto = $this->input->post('id_producto');

        $imagenespath = $this->Imagen_model->obtener_imagenes_producto($id_producto);

        //Carpeta destino

        $dir = base_url() . "application/imgs/productos/";

        //Leer Archivos

        foreach ($imagenespath as $imagen) {

            $path = $dir . $imagen['url'];

            // $size = filesize($path);
            // $size = get_file_info($path);

            $lista_imagenes[] = array('name' => $imagen['url'], 'size' => 0, 'path' => $path);
        }



        echo json_encode($lista_imagenes);
    }
}
