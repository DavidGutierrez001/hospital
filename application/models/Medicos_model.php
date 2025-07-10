<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Medicos_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $this->db->select('medicos.id_medico, medicos.id_especialidad, medicos.contacto, medicos.activo, 
                            especialidades.nombre_especialidad, 
                            usuarios.primer_nombre, usuarios.segundo_nombre, usuarios.primer_apellido, usuarios.segundo_apellido, usuarios.email');
        $this->db->from('medicos');
        $this->db->join('especialidades', 'medicos.id_especialidad = especialidades.id_especialidad');
        $this->db->join('usuarios', 'medicos.id_usuario = usuarios.id_usuario');
        return $this->db->get()->result();
    }

    public function get_especialidades()
    {
        $this->db->select('id_especialidad, nombre_especialidad');
        $this->db->from('especialidades');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('medicos.*, 
                            usuarios.primer_nombre, usuarios.segundo_nombre, usuarios.primer_apellido, usuarios.segundo_apellido, usuarios.email');
        $this->db->from('medicos');
        $this->db->join('usuarios', 'medicos.id_usuario = usuarios.id_usuario');
        $this->db->where('medicos.id_medico', $id);
        return $this->db->get()->row();
    }

    public function create($medicoData)
    {
        return $this->db->insert('medicos', $medicoData);
    }

    public function update($id, $medicoData)
    {
        $this->db->where('id_medico', $id);
        return $this->db->update('medicos', $medicoData);
    }

    public function delete($id)
    {
        $this->db->where('id_medico', $id);
        return $this->db->delete('medicos');
    }

    public function count_users()
    {
        return $this->db->count_all('medicos');
    }

    public function get_medico_by_document($documento)
    {
        $this->db->where('documento', $documento);
        $query = $this->db->get('medicos');
        return $query->row('id_medico');
    }

    public function get_medicos_by_especialidad($id_especialidad)
    {
        $this->db->select('medicos.id_medico, usuarios.primer_nombre, usuarios.segundo_nombre, usuarios.primer_apellido, especialidades.nombre_especialidad');
        $this->db->from('medicos');
        $this->db->join('usuarios', 'medicos.id_usuario = usuarios.id_usuario');
        $this->db->join('especialidades', 'medicos.id_especialidad = especialidades.id_especialidad');
        $this->db->where('medicos.id_especialidad', $id_especialidad);
        $this->db->where('medicos.activo', 1);
        return $this->db->get()->result();
    }

    public function get_available_medico($id_especialidad, $fecha_cita, $hora_inicio, $hora_fin)
    {
        $this->db->select('disponibilidad_medicos.id_disponibilidad, disponibilidad_medicos.id_medico, disponibilidad_medicos.dia_semana, disponibilidad_medicos.hora_inicio, disponibilidad_medicos.hora_fin, 
                        usuarios.primer_nombre, usuarios.primer_apellido, 
                        especialidades.nombre_especialidad');
        $this->db->from('disponibilidad_medicos');
        $this->db->join('medicos', 'disponibilidad_medicos.id_medico = medicos.id_medico');
        $this->db->join('usuarios', 'medicos.id_usuario = usuarios.id_usuario');
        $this->db->join('especialidades', 'medicos.id_especialidad = especialidades.id_especialidad');
        $this->db->where('medicos.id_especialidad', $id_especialidad);
        $this->db->where('disponibilidad_medicos.dia_semana', date('l', strtotime($fecha_cita)));
        $this->db->where('disponibilidad_medicos.hora_inicio <=', $hora_inicio);
        $this->db->where('disponibilidad_medicos.hora_fin >=', $hora_fin);

        // Subconsulta para excluir médicos
        $subconsulta = "
        SELECT id_medico FROM citas_medicas
        WHERE fecha_cita = " . $this->db->escape($fecha_cita) . "
            AND (
                hora_inicio < " . $this->db->escape($hora_fin) . "
                AND hora_fin > " . $this->db->escape($hora_inicio) . "
            )
        ";

        $this->db->where("disponibilidad_medicos.id_medico NOT IN ($subconsulta)", null, false);

        return $this->db->get()->result();
    }
}
