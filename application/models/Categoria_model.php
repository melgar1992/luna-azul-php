<?php
class Categoria_model extends CI_Model
{

    public function obtener_categorias()
    {
        $this->db->select("*");
        $this->db->where('estado', '1');
        return $this->db->get('categoria')->result_array();
    }

    public function ingresar_categoria($datos_categoria)
    {
        $this->db->insert('categoria', $datos_categoria);
        return $this->db->insert_id();
    }

    public function editar_categoria($id_categoria, $datos_categoria)
    {
        $this->db->where('id_categorias', $id_categoria);
        $this->db->update('categoria', $datos_categoria);
    }

    public function eliminar_categoria($id_categoria)
    {
        $datos = array (
            'nombre'=> '',
            'estado'=> 0
        );
        $this->editar_categoria($id_categoria, $datos);
    }

}