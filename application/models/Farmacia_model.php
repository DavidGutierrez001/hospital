<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Farmacia_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMedicamentos()
    {
        $this->db->select('*');
        $this->db->from('medicamentos');
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }
}
