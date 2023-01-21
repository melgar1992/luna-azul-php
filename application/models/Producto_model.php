<?php
class Producto_model extends CI_Model
{

    public function obtener_productos()
    {
        $this->db->select("p.*,ca.nombre as categoria, 
        (select img.url  from imagenes img where img.id_producto = p.id_producto limit 1 ) as imagen");
        $this->db->join('categorias ca', 'ca.id_categorias = p.id_categorias');
        $this->db->where('p.estado', '1');
        $this->db->order_by('id_producto', 'desc');
        $this->db->limit(100);
        return $this->db->get('productos p')->result_array();
    }

    public function obtener_producto($id_producto)
    {
        $this->db->select('*');
        $this->db->where('id_producto', $id_producto);
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
        $this->imagen_model->eliminar_imagen_producto($id_producto);
    }
    public function eliminar_producto($id_producto)
    {
        $datos = array(
            'nombre' => '',
            'estado' => 0
        );
        $this->Imagen_model->eliminar_imagen_producto($id_producto);
        return $this->editar_producto($id_producto, $datos);
    }
}