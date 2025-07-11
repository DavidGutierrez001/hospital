<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Citas_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_citas()
    {
        $this->db->select('citas_medicas.id_cita, citas_medicas.fecha_cita, citas_medicas.hora_inicio, citas_medicas.estado_cita, 
                    pacientes.id_paciente, 
                    usuario_paciente.primer_nombre, usuario_paciente.primer_apellido,
                    medicos.id_medico,
                    usuario_medico.primer_nombre AS medico_nombre, usuario_medico.primer_apellido AS medico_apellido');

        $this->db->from('citas_medicas');

        $this->db->join('pacientes', 'citas_medicas.id_paciente = pacientes.id_paciente');
        $this->db->join('medicos', 'citas_medicas.id_medico = medicos.id_medico');

        $this->db->join('usuarios AS usuario_paciente', 'usuario_paciente.id_usuario = pacientes.id_usuario');
        $this->db->join('usuarios AS usuario_medico', 'usuario_medico.id_usuario = medicos.id_usuario');
        $query = $this->db->get();
        return $query->result();
    }

    public function is_available($fecha_cita, $hora_inicio, $hora_fin)
    {
        $this->db->where('fecha_cita', $fecha_cita);
        $this->db->where('estado_cita', 'Programada');
        $this->db->where("hora_inicio <= '$hora_fin' AND hora_fin >= '$hora_inicio'", null, false);
        $query = $this->db->get('citas_medicas');
        return $query->num_rows() === 0;
    }

    public function not_pending_citas($doc_paciente)
    {
        $this->db->select('id_paciente');
        $this->db->from('pacientes');
        $this->db->where('documento', $doc_paciente);
        $paciente = $this->db->get()->row();

        if (!$paciente) {
            return false;
        }

        $this->db->select('id_cita');
        $this->db->from('citas_medicas');
        $this->db->where('id_paciente', $paciente->id_paciente);
        $this->db->where('estado_cita !=', 'Cancelada');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function insert_cita($data)
    {
        $this->db->trans_start();

        $paciente = $this->db->select('id_paciente')
            ->from('pacientes')
            ->where('documento', $data['doc_paciente'])
            ->get()
            ->row();

        if (!$paciente) {
            $this->db->trans_complete();
            return [
                'success' => false,
                'error' => 'Paciente no encontrado.'
            ];
        }

        $cita = [
            'id_paciente'     => $paciente->id_paciente,
            'id_medico'       => $data['id_medico'],
            'fecha_cita'      => $data['fecha_cita'],
            'hora_inicio'     => $data['hora_inicio'],
            'hora_fin'        => date('H:i:s', strtotime($data['hora_inicio'] . ' +30 minutes')),
            'estado_cita'     => 'Programada',
        ];

        $this->db->insert('citas_medicas', $cita);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return [
                'success' => false,
                'error' => 'No se pudo agender la cita médica.',
            ];
        }

        return [
            'success' => true,
        ];
    }

    public function get_cita_by_id($id_cita)
    {
        $this->db->select('*')
            ->from('citas_medicas')
            ->where('id_cita', $id_cita);
        $query = $this->db->get();

        if ($query->num_rows() === 0) {
            return false;
        }

        return $query->row();
    }


    public function cancel_cita($id_cita)
    {
        $this->db->where('id_cita', $id_cita);
        $this->db->update('citas_medicas', ['estado_cita' => 'Cancelada']);

        if ($this->db->affected_rows() === 0) {
            return false;
        }

        return true;
    }

    public function get_next_citas($limit = 10)
    {
        $this->db->select('
        citas_medicas.fecha_cita,
        citas_medicas.hora_inicio,
        usuario_paciente.primer_nombre AS paciente_nombre,
        usuario_paciente.primer_apellido AS paciente_apellido,
        usuario_medico.primer_nombre AS medico_nombre,
        usuario_medico.primer_apellido AS medico_apellido
    ');
        $this->db->from('citas_medicas');
        $this->db->join('pacientes', 'citas_medicas.id_paciente = pacientes.id_paciente');
        $this->db->join('medicos', 'citas_medicas.id_medico = medicos.id_medico');
        $this->db->join('usuarios AS usuario_paciente', 'usuario_paciente.id_usuario = pacientes.id_usuario');
        $this->db->join('usuarios AS usuario_medico', 'usuario_medico.id_usuario = medicos.id_usuario');
        $this->db->where('citas_medicas.fecha_cita >=', date('Y-m-d'));
        $this->db->where('citas_medicas.estado_cita', 'Programada');
        $this->db->order_by('citas_medicas.fecha_cita', 'ASC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    public function reagendar_cita($data)
    {
        if (!isset($data['id_cita'])) {
            return ['success' => false, 'error' => 'Falta el ID de la cita.'];
        }

        $id_cita = $data['id_cita'];
        unset($data['id_cita']);

        $this->db->where('id_cita', $id_cita);
        $updated = $this->db->update('citas_medicas', $data);

        if ($updated) {
            return ['success' => true];
        } else {
            return ['success' => false, 'error' => 'No se pudo actualizar la cita.'];
        }
    }

    public function validar_disponibilidad_reagendar($id_medico, $fecha, $hora_inicio, $hora_fin, $id_cita)
    {
        $this->db->from('citas_medicas');
        $this->db->where('id_medico', $id_medico);
        $this->db->where('fecha_cita', $fecha);
        $this->db->where('hora_inicio <', $hora_fin);
        $this->db->where('hora_fin >', $hora_inicio);
        $this->db->where('id_cita !=', $id_cita);
        $this->db->where_in('estado_cita', ['Programada', 'Confirmada']);
        $this->db->where('fecha_cita >=', date('Y-m-d'));


        $query = $this->db->get();
        $conflictos = $query->num_rows();

        if ($conflictos > 0) {
            return false;
        }

        return true;
    }

    public function get_medico_by_cita($id_cita)
    {
        $this->db->select('id_medico,');
        $this->db->from('citas_medicas');
        $this->db->where('id_cita', $id_cita);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->id_medico;
        }
    }
}
