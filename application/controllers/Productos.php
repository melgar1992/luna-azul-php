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
        $file = $_FILES;
        $config['upload_path']          = './imgs/productos';
        $config['allowed_types']        = 'jpg|png|jpeg';
        $config['max_size']             = 100000;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());
            $respuesta = array(
                'respuesta' => 'Error',
                'mensaje' => 'Ocurrio un problema',
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
