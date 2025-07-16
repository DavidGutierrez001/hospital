<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Historial_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_historial()
    {
        $this->db->select('
        historial_medico.id_historial,
        historial_medico.id_paciente,
        u_medico.primer_nombre AS medico_primer_nombre,
        u_medico.segundo_nombre AS medico_segundo_nombre,
        u_medico.primer_apellido AS medico_primer_apellido,
        u_medico.segundo_apellido AS medico_segundo_apellido,
        u_paciente.primer_nombre AS paciente_primer_nombre,
        u_paciente.segundo_nombre AS paciente_segundo_nombre,
        u_paciente.primer_apellido AS paciente_primer_apellido,
        u_paciente.segundo_apellido AS paciente_segundo_apellido,
        pacientes.documento,
        historial_medico.fecha_creacion,
        historial_medico.motivo_consulta
    ');
        $this->db->from('historial_medico');
        $this->db->join('pacientes', 'historial_medico.id_paciente = pacientes.id_paciente');
        $this->db->join('medicos', 'historial_medico.id_medico = medicos.id_medico');
        $this->db->join('usuarios u_medico', 'medicos.id_usuario = u_medico.id_usuario');
        $this->db->join('usuarios u_paciente', 'pacientes.id_usuario = u_paciente.id_usuario');

        $query = $this->db->get();

        return $query->result();
    }

    public function get_historial_by_id($id_paciente)
    {
        $this->db->select('
        historial_medico.id_historial,
        historial_medico.id_paciente,
        historial_medico.motivo_consulta,
        historial_medico.diagnostico,
        historial_medico.tratamiento,
        historial_medico.antecedentes_familiares,
        historial_medico.estilo_vida,
        historial_medico.notas_generales,
        historial_medico.proxima_cita,
        u_medico.primer_nombre AS medico_primer_nombre,
        u_medico.segundo_nombre AS medico_segundo_nombre,
        u_medico.primer_apellido AS medico_primer_apellido,
        u_medico.segundo_apellido AS medico_segundo_apellido,
        u_paciente.primer_nombre AS paciente_primer_nombre,
        u_paciente.segundo_nombre AS paciente_segundo_nombre,
        u_paciente.primer_apellido AS paciente_primer_apellido,
        u_paciente.segundo_apellido AS paciente_segundo_apellido,
        u_paciente.email AS paciente_email,
        pacientes.genero,
        pacientes.direccion,
        pacientes.fecha_nacimiento
    ');
        $this->db->from('pacientes');
        $this->db->where('pacientes.id_paciente', $id_paciente);
        $this->db->join('usuarios u_paciente', 'pacientes.id_usuario = u_paciente.id_usuario');
        $this->db->join('historial_medico', 'pacientes.id_paciente = historial_medico.id_paciente', 'left');
        $this->db->join('medicos', 'historial_medico.id_medico = medicos.id_medico', 'left');
        $this->db->join('usuarios u_medico', 'medicos.id_usuario = u_medico.id_usuario', 'left');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return false;
    }
}
