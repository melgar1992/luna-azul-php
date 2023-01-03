<?php
class Producto_model extends CI_Model
{

    public function obtener_productos()
    {
        $this->db->select("*,ca.nombre as categoria");
        $this->db->join('categorias ca', 'ca.id_categorias = productos.id_categorias');
        $this->db->where('productos.estado', '1');
        $this->db->order_by('id_producto', 'desc');
        $this->db->limit(100);
        return $this->db->get('productos')->result_array();
    }

    public function obtener_producto($id_produto)
    {
        $this->db->select('*');
        $this->db->where('id_produto', $id_produto);
        return $this->db->get('productos')->row_array();
    }
    public function ingresar_producto($datos_producto)
    {
        $this->db->insert('productos', $datos_producto);
        return $this->db->insert_id();
    }
    public function editar_producto($id_producto, $datos_producto)
    {
        $this->db->where('id_producto', $id_producto);
        return $this->db->update('productos', $datos_producto);
    }
    public function eliminar_producto($id_producto)
    {
        $datos = array(
            'nombre' => '',
            'estado' => 0
        );
        return $this->editar_producto($id_producto, $datos);
    }
}