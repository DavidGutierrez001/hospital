<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reportes_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCitasByDay($fecha_exportar = null, $doc_medico = null)
    {
        $this->db->select('
        u_paciente.primer_nombre AS paciente_primer_nombre,
        u_paciente.primer_apellido AS paciente_primer_apellido,
        u_medico.primer_nombre AS medico_primer_nombre,
        u_medico.primer_apellido AS medico_primer_apellido,
        pacientes.documento AS paciente_documento,
        medicos.documento AS medico_documento,
        citas_medicas.fecha_cita,
        citas_medicas.hora_inicio,
        citas_medicas.hora_fin,
        citas_medicas.estado_cita,
    ');

        $this->db->from('citas_medicas');
        $this->db->join('pacientes', 'pacientes.id_paciente = citas_medicas.id_paciente', 'left');
        $this->db->join('usuarios AS u_paciente', 'u_paciente.id_usuario = pacientes.id_usuario', 'left');
        $this->db->join('medicos', 'medicos.id_medico = citas_medicas.id_medico', 'left');
        $this->db->join('usuarios AS u_medico', 'u_medico.id_usuario = medicos.id_usuario', 'left');

        if ($fecha_exportar !== null) {
            $this->db->where('citas_medicas.fecha_cita', $fecha_exportar);
        } else {
            $this->db->where('citas_medicas.fecha_cita', date('Y-m-d'));
        }

        if (!empty($doc_medico)) {
            $this->db->where('medicos.documento', $doc_medico);
        }

        return $this->db->get()->result();
    }

    public function getPacientesByMonth($fecha_exportar = null, $doc_medico = null)
    {
        $this->db->select('
            u_paciente.primer_nombre AS paciente_primer_nombre,
            u_paciente.primer_apellido AS paciente_primer_apellido,
            u_medico.primer_nombre AS medico_primer_nombre,
            u_medico.primer_apellido AS medico_primer_apellido,
            pacientes.documento AS paciente_documento,
            medicos.documento AS medico_documento,
            citas_medicas.fecha_cita,
            citas_medicas.hora_inicio,
            citas_medicas.hora_fin,
            citas_medicas.estado_cita
            ');
        $this->db->from('citas_medicas');
        $this->db->join('pacientes', 'pacientes.id_paciente = citas_medicas.id_paciente', 'left');
        $this->db->join('usuarios AS u_paciente', 'u_paciente.id_usuario = pacientes.id_usuario', 'left');
        $this->db->join('medicos', 'medicos.id_medico = citas_medicas.id_medico', 'left');
        $this->db->join('usuarios AS u_medico', 'u_medico.id_usuario = medicos.id_usuario', 'left');

        if (!empty($fecha_exportar)) {
            $month = date('m', strtotime($fecha_exportar));
            $year = date('Y', strtotime($fecha_exportar));
            $this->db->where('MONTH(citas_medicas.fecha_cita)', $month);
            $this->db->where('YEAR(citas_medicas.fecha_cita)', $year);
        } else {
            $this->db->where('MONTH(citas_medicas.fecha_cita)', date('m'));
            $this->db->where('YEAR(citas_medicas.fecha_cita)', date('Y'));
        }

        if (!empty($doc_medico)) {
            $this->db->where('medicos.documento', $doc_medico);
        }
        $this->db->where('citas_medicas.estado_cita', 'Asistida');

        return $this->db->get()->result();
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

    public function getVentasByMonth($producto_exportar = null, $fecha_producto = null)
    {
        $this->db->select('
            ventas.*, 
            productos.nombre_comercial, 
            usuarios.primer_nombre, usuarios.primer_apellido, 
            pacientes.documento,
        ');

        $this->db->from('ventas');
        $this->db->join('productos', 'ventas.id_producto = productos.id_producto');
        $this->db->join('pacientes', 'ventas.id_paciente = pacientes.id_paciente');
        $this->db->join('usuarios', 'pacientes.id_usuario = usuarios.id_usuario');

        if (!empty($fecha_producto)) {
            $this->db->where('MONTH(ventas.fecha_venta)', date('m', strtotime($fecha_producto)));
            $this->db->where('YEAR(ventas.fecha_venta)', date('Y', strtotime($fecha_producto)));
        } else {
            $this->db->where('MONTH(ventas.fecha_venta)', date('m'));
            $this->db->where('YEAR(ventas.fecha_venta)', date('Y'));
        }

        if (!empty($producto_exportar) && intval($producto_exportar) >= 1) {
            $this->db->where('ventas.id_producto', intval($producto_exportar));
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function getProductos()
    {
        $this->db->select('id_producto, nombre_comercial');
        $this->db->from('productos');
        $this->db->where('existencias >', 0);
        $this->db->where('eliminado', 0);

        $query = $this->db->get();
        return $query->result();
    }
}
