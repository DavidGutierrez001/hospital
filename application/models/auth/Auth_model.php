<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public function get_user_email($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('usuarios');

        if ($query->num_rows() > 0) {
            return $query->row();
        }

        return null;
    }
}
