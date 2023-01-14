<?php
class Imagen_model extends CI_Model
{
    public function obtener_imagenes()
    {
        $this->db->select("*");
        $this->db->order_by('id_imagen', 'desc');
        $this->db->limit(100);
        return $this->db->get('imagenes')->result_array();
    }
    public function obtener_categoria($id_imagen)
    {
        $this->db->select('*');
        $this->db->where('id_imagen', $id_imagen);
        return $this->db->get('imagenes')->row_array();
    }
    public function obtener_imagenes_producto($id_producto)
    {
        $this->db->select("*");
        $this->db->where('id_producto', $id_producto);
        $this->db->order_by('id_imagen', 'desc');
        $this->db->limit(5);
        return $this->db->get('imagenes')->result_array();
    }
    public function ingresar_imagen($datos_imagen)
    {
        $this->db->insert('imagenes', $datos_imagen);
        return $this->db->insert_id();
    }

    public function editar_imagen($id_imagen, $datos_imagen)
    {
        $this->db->where('id_imagen', $id_imagen);
        return $this->db->update('imagenes', $datos_imagen);
    }

    public function eliminar_imagen_producto($id_producto)
    {
        $this->db->select('*');
        $this->db->where('id_producto', $id_producto);
        $imagenes_path = $this->db->get('imagenes')->result_array();
        foreach ($imagenes_path as $imagen) {
            unlink($imagen['url']);
        }
        $this->db->where('id_producto', $id_producto);
        return $this->db->delete('imagenes');
    }
}
