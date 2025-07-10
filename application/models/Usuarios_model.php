<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios_model extends CI_Model
{
    public function create_user($usuarioData)
    {
        $this->load->helper('security');
        $usuarioData = $this->security->xss_clean($usuarioData);

        $this->db->insert('usuarios', $usuarioData);
        return $this->db->insert_id();
    }

    public function update_user($id, $usuarioData)
    {
        $this->load->helper('security');
        $usuarioData = $this->security->xss_clean($usuarioData);

        $this->db->where('id_usuario', $id);
        return $this->db->update('usuarios', $usuarioData);
    }

    public function delete_user($id)
    {
        $this->db->where('id_usuario', $id);
        return $this->db->delete('usuarios');
    }

    public function obtener_por_email($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('usuarios');

        return ($query->num_rows() > 0) ? $query->row() : null;
    }

    public function count_users()
    {
        return $this->db->count_all('usuarios');
    }

    public function get_by_id($id)
    {
        $this->db->where('id_usuario', $id);
        $query = $this->db->get('usuarios');

        return ($query->num_rows() > 0) ? $query->row() : null;
    }
}
