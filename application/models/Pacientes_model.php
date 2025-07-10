<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pacientes_model extends CI_Model
{
    public function crear($id_usuario)
    {
        return $this->db->insert('pacientes', ['id_usuario' => $id_usuario]);
    }

    public function get_all()
    {
        $this->db->select('usuarios.primer_nombre, usuarios.segundo_nombre, usuarios.primer_apellido, usuarios.segundo_apellido, pacientes.documento, pacientes.id_paciente');
        $this->db->from('pacientes');
        $this->db->join('usuarios', 'pacientes.id_usuario = usuarios.id_usuario');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('pacientes.id_paciente, pacientes.fecha_nacimiento, pacientes.documento, pacientes.tipo_documento, pacientes.genero, 
                            pacientes.direccion, pacientes.estado_civil, pacientes.telefono,
                            usuarios.primer_nombre, usuarios.segundo_nombre, usuarios.primer_apellido, usuarios.segundo_apellido');
        $this->db->from('pacientes');
        $this->db->join('usuarios', 'pacientes.id_usuario = usuarios.id_usuario');
        $this->db->where('id_paciente', $id);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function update($id, $dataPaciente, $dataUsuario)
    {
        $this->db->trans_start();

        $this->db->where('id_paciente', $id);
        $this->db->update('pacientes', $dataPaciente);

        $this->db->select('id_usuario');
        $this->db->from('pacientes');
        $this->db->where('id_paciente', $id);

        $query = $this->db->get();
        $row = $query->row();

        if ($row) {
            $id_usuario = $row->id_usuario;

            $this->db->where('id_usuario', $id_usuario);
            $this->db->update('usuarios', $dataUsuario);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function document_exist($documento, $id = NULL)
    {
        $this->db->where('documento', $documento);
        if ($id !== NULL) {
            $this->db->where('id_paciente !=', $id);
        }
        return $this->db->get('pacientes')->num_rows() > 0;
    }

    public function create($dataPaciente, $dataUsuario)
    {
        $this->db->trans_start();

        $this->db->insert('usuarios', $dataUsuario);

        $id_usuario = $this->db->insert_id();

        $dataPaciente['id_usuario'] = $id_usuario;

        $this->db->insert('pacientes', $dataPaciente);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function delete($id)
    {
        $this->db->select('id_usuario');
        $this->db->from('pacientes');
        $this->db->where('id_paciente', $id);
        $query = $this->db->get();
        $row = $query->row();

        if (!$row) return false;

        $id_usuario = $row->id_usuario;

        $this->db->trans_start();

        $this->db->where('id_paciente', $id);
        $this->db->delete('pacientes');

        $this->db->where('id_usuario', $id_usuario);
        $this->db->delete('usuarios');

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function count_users()
    {
        return $this->db->count_all('pacientes');
    }

    public function get_paciente_by_documento($documento)
    {
        $this->db->where('documento', $documento);
        $query = $this->db->get('pacientes');
        return $query->row('id_paciente');
    }
}
