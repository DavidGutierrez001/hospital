<?php
Defined('BASEPATH') or exit('No direct script access allowed');

class Permisos_model extends CI_Model
{
    public function tiene_acceso($id_rol, $controlador)
    {
        $this->db->select('modulos.id_modulo');
        $this->db->from('permisos');
        $this->db->join('modulos', 'permisos.id_modulo = modulos.id_modulo');
        $this->db->where('permisos.id_rol', $id_rol);
        $this->db->where('modulos.controlador', $controlador);

        $query = $this->db->get();
        return $query->num_rows() > 0;
    }
}
