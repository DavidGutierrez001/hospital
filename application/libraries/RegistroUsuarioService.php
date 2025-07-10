<?php

class RegistroUsuarioService
{
    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();

        $this->ci->load->model('Usuarios_model');
        $this->ci->load->model('Pacientes_model');
        $this->ci->load->model('Medicos_model');
    }

    public function registrar($datos)
    {
        $usuario = [
            'email'            => trim($datos['email']),
            'password'         => password_hash($datos['password'], PASSWORD_BCRYPT),
            'primer_nombre'    => trim($datos['primer_nombre']),
            'segundo_nombre'   => trim($datos['segundo_nombre']) === '' ? NULL : trim($datos['segundo_nombre']),
            'primer_apellido'  => trim($datos['primer_apellido']),
            'segundo_apellido' => trim($datos['segundo_apellido']) === '' ? NULL : trim($datos['segundo_apellido']),
            'id_rol'           => is_numeric($datos['id_rol']) ? (int)$datos['id_rol'] : NULL,
            'fecha_registro'   => date('Y-m-d h:i:s'),
            'activo'           => true
        ];

        $this->ci->db->trans_start();

        $id_usuario = $this->ci->Usuarios_model->create_user($usuario);

        if (!$id_usuario) {
            $this->ci->db->trans_rollback();
            return ['success' => false, 'message' => 'Error al registrar el usuario.'];
        }

        switch ($usuario['id_rol']) {

            case 2: // Médico
                $medicoData = [
                    'id_usuario'      => $id_usuario,
                    'activo'          => true
                ];
                $this->ci->Medicos_model->create($medicoData);
                break;
        }

        $this->ci->db->trans_complete();

        if ($this->ci->db->trans_status() === FALSE) {
            return ['success' => false, 'message' => 'Error en la transacción.'];
        }

        $this->ci->session->set_flashdata('success', 'Usuario registrado exitosamente.');
        redirect('login');
        return ['success' => true, 'message' => 'Usuario registrado exitosamente.'];
    }
}
