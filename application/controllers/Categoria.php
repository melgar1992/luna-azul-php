<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categoria extends BaseController
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
        $this->loadView('Categoria', 'formularios/categoria/categoria_form', $data);
    }

    public function obtenerCategoriasAjax()
    {
        $categorias = $this->Categoria_model->obtener_categorias();
        echo json_encode($categorias);
    }

}
