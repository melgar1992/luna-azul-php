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
    public function subirImagenes()
    {
        $config['upload_path']          = './application/imgs/productos/';
        $config['allowed_types']        = 'jpg|png|jpeg';
        $config['file_name']            =  rand(1,50000000);
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
}
