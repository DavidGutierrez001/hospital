<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Farmacia_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getProductos()
    {
        $this->db->select('*');
        $this->db->from('productos');
        $this->db->where('eliminado', 0);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    public function getProductoById($id_producto)
    {
        return $this->db
            ->where('id_producto', $id_producto)
            ->get('productos')
            ->row();
    }

    public function getProductosStock()
    {
        $this->db->select('productos.id_producto, productos.nombre_comercial, productos.descripcion, productos.precio');
        $this->db->from('productos');
        $this->db->where('productos.existencias >= 1');
        $this->db->where('productos.activo', 1);
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_product($data)
    {

        $data = [
            'nombre_comercial' => $data['nombre_comercial'] ?? '',
            'descripcion' => $data['descripcion'] ?? '',
            'receta_especial' => $data['receta_especial'],
            'activo' => 1,
            'fecha_registro' => $data['fecha_registro'] ?? date('Y-m-d H:i:s'),
            'existencias' => $data['existencias'] ?? 0,
            'precio' => $data['precio'] ?? 0.00
        ];

        return $this->db->insert('productos', $data);
    }

    public function searchPacientByDocument($document)
    {
        $this->db->from('pacientes');
        $this->db->where('documento', $document);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function registerSale($data)
    {
        $this->load->model('Pacientes_model');

        $this->db->trans_start();

        $id_paciente = $this->Pacientes_model->get_paciente_by_documento($data['documento']);

        $dataSale = [
            'id_producto' => $data['id_producto'],
            'id_paciente' => $id_paciente,
            'fecha_venta' => date('Y-m-d H:i:s'),
            'total_venta' => $data['precio_total'],
            'estado_venta' => 'Comprado',
        ];

        $dataExit = [
            'id_producto' => $data['id_producto'],
            'cantidad' => $data['cantidad'],
            'fecha_salida' => date('Y-m-d H:i:s'),
        ];

        // Insert sale
        $this->db->insert('ventas', $dataSale);

        // Insert exit
        $this->db->insert('salidas', $dataExit);

        // Update product stock
        $this->db->set('existencias', 'existencias - ' . (int)$data['cantidad'], false);
        $this->db->where('id_producto', $data['id_producto']);
        $this->db->update('productos');

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function getVentas()
    {
        $this->db->select('ventas.*, productos.nombre_comercial, usuarios.primer_nombre, usuarios.primer_apellido, pacientes.documento');
        $this->db->from('ventas');
        $this->db->join('productos', 'ventas.id_producto = productos.id_producto');
        $this->db->join('pacientes', 'ventas.id_paciente = pacientes.id_paciente');
        $this->db->join('usuarios', 'pacientes.id_usuario = usuarios.id_usuario');
        $query = $this->db->get();
        return $query->result();
    }

    public function update_product($id_producto, $data)
    {
        return $this->db
            ->where('id_producto', $id_producto)
            ->update('productos', $data);
    }

    public function delete_product($producto)
    {
        $data = ['eliminado' => 1];
        $id = is_object($producto) ? $producto->id_producto : $producto;

        $this->db->where('id_producto', $id)->update('productos', $data);
    }

    public function agregarEntrada($id_producto, $cantidad)
    {
        $producto = $this->getProductoById($id_producto);
        if (!$producto) {
            return false;
        }

        $data = [
            'id_producto' => $id_producto,
            'cantidad' => $cantidad,
            'fecha_entrada' => date('Y-m-d H:i:s'),
        ];

        // Insertar entrada en la tabla de entradas
        $this->db->insert('entradas', $data);
    }

    public function getEntradas()
    {
        $this->db->select('entradas.*, productos.nombre_comercial');
        $this->db->from('entradas');
        $this->db->join('productos', 'entradas.id_producto = productos.id_producto');
        $query = $this->db->get();
        return $query->result();
    }

    public function getSalidas()
    {
        $this->db->select('salidas.*, productos.nombre_comercial');
        $this->db->from('salidas');
        $this->db->join('productos', 'salidas.id_producto = productos.id_producto');
        $query = $this->db->get();
        return $query->result();
    }
}
