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
            // 'categorias' => $this->Categoria_model->obtener_categorias(),
        );
        $this->loadView('Producto', 'formularios/producto/producto_form', $data);
    }
}
