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
        medicos.documento AS medico_documento,
        u_paciente.primer_nombre AS paciente_primer_nombre,
        u_paciente.segundo_nombre AS paciente_segundo_nombre,
        u_paciente.primer_apellido AS paciente_primer_apellido,
        u_paciente.segundo_apellido AS paciente_segundo_apellido,
        pacientes.documento AS paciente_documento,
        historial_medico.fecha_creacion,
        historial_medico.motivo_consulta
    ');
        $this->db->from('historial_medico');
        $this->db->join('pacientes', 'historial_medico.id_paciente = pacientes.id_paciente');
        $this->db->join('medicos', 'historial_medico.id_medico = medicos.id_medico');
        $this->db->join('usuarios u_medico', 'medicos.id_usuario = u_medico.id_usuario');
        $this->db->join('usuarios u_paciente', 'pacientes.id_usuario = u_paciente.id_usuario');
        $this->db->where('historial_medico.eliminado', 0);

        $query = $this->db->get();
        return $query->result();
    }


    public function get_historial_by_id($id_historial)
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

        $this->db->from('historial_medico');
        $this->db->where('historial_medico.id_historial', $id_historial);

        $this->db->join('pacientes', 'historial_medico.id_paciente = pacientes.id_paciente', 'left');
        $this->db->join('usuarios u_paciente', 'pacientes.id_usuario = u_paciente.id_usuario', 'left');
        $this->db->join('medicos', 'historial_medico.id_medico = medicos.id_medico', 'left');
        $this->db->join('usuarios u_medico', 'medicos.id_usuario = u_medico.id_usuario', 'left');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return false;
    }


    public function create_historial($data)
    {
        $id_paciente = $this->db->select('id_paciente')
            ->from('pacientes')
            ->where('documento', $data['documento_paciente'])
            ->get()
            ->row()
            ->id_paciente;

        $id_medico = $this->db->select('id_medico')
            ->from('medicos')
            ->where('documento', $data['documento_medico'])
            ->get()
            ->row()
            ->id_medico;

        if (!$id_paciente || !$id_medico) {
            return false;
        }

        $data['id_paciente'] = $id_paciente;
        $data['id_medico'] = $id_medico;
        $data['fecha_creacion'] = date('Y-m-d H:i:s');

        unset($data['documento_paciente'], $data['documento_medico']);

        $this->db->insert('historial_medico', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_historial($id_historial)
    {
        $this->db->from('historial_medico');
        $this->db->where('id_historial', $id_historial);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $this->db->set('eliminado', 1);
            $this->db->where('id_historial', $id_historial);
            $this->db->update('historial_medico');
            return $this->db->affected_rows() > 0;
        }
    }
}
