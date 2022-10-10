<?php
class Categoria_model extends CI_Model
{

    public function obtener_categorias()
    {
        $this->db->select("*");
        $this->db->where('estado', '1');
        return $this->db->get('categorias')->result_array();
    }
    public function obtener_categoria($id_categoria)
    {
        $this->db->select('*');
        $this->db->where('id_categorias', $id_categoria);
        return $this->db->get('categorias')->row_array();
    }

    public function ingresar_categoria($datos_categoria)
    {
        $this->db->insert('categorias', $datos_categoria);
        return $this->db->insert_id();
    }

    public function editar_categoria($id_categoria, $datos_categoria)
    {
        $this->db->where('id_categorias', $id_categoria);
        return $this->db->update('categorias', $datos_categoria);
    }

    public function eliminar_categoria($id_categoria)
    {
        $datos = array(
            'nombre' => '',
            'estado' => 0
        );
        return $this->editar_categoria($id_categoria, $datos);
    }
}
