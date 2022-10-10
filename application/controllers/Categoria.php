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
    public function obtenerCategoriaAjax()
    {
        $id_categoria = $this->input->post('id_categoria');
        $categoria = $this->Categoria_model->obtener_categoria($id_categoria);
        echo json_encode($categoria);
    }
    public function ingresarCategoria()
    {
        $nombre = $this->input->post('nombre');
        $descripcion = $this->input->post('descripcion');

        $this->form_validation->set_rules("nombre", "nombre", "required|is_unique[categorias.nombre]");
        try {
            if ($this->form_validation->run() === false) {
                $respuesta = array(
                    'respuesta' => 'Error',
                    'mensaje' => 'Ocurrio un problema al validar los datos, o el nombre categoria ya existe!',
                );
            } else {
                $datosCategoria = array(
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'estado' => '1',
                );
                $id_categorias = $this->Categoria_model->ingresar_categoria($datosCategoria);
                if ($id_categorias) {
                    $datosCategoria += ['id_categorias' => $id_categorias];
                    $respuesta = array(
                        'respuesta' => 'Exitoso',
                        'datos' => $datosCategoria,
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
    public function actualizarCateogira()
    {
        $nombre = $this->input->post('nombre');
        $descripcion = $this->input->post('descripcion');
        $id_categorias = $this->input->post('id_categorias');

        $categoria_actual = $this->Categoria_model->obtener_categoria($id_categorias);

        if ($nombre == $categoria_actual['nombre']) {
            $is_unqueNombre = '';
        } else {
            $is_unqueNombre = '|is_unique[categorias.nombre]';
        }
        $this->form_validation->set_rules("nombre", "nombre", "required" . $is_unqueNombre);
        try {
            if ($this->form_validation->run() === false) {
                $respuesta = array(
                    'respuesta' => 'Error',
                    'mensaje' => 'Ocurrio un problema al validar los datos, o el nombre categoria ya existe!',
                );
            } else {
                $datosCategoria = array(
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                );
                if ($this->Categoria_model->editar_categoria($id_categorias, $datosCategoria)) {
                    $datosCategoria += ['id_categorias' => $id_categorias];
                    $respuesta = array(
                        'respuesta' => 'Exitoso',
                        'datos' => $datosCategoria,
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

    public function borrar($id_categoria)
    {
        $datosCategoria = array(
            'nombre' => null,
            'estado' => '0',
        );
        if ($this->Categoria_model->eliminar_categoria($id_categoria, $datosCategoria)) {
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
}
