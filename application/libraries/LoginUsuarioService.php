<?php

class LoginUsuarioService
{
    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model('auth/Auth_model');
    }

    public function login($datos)
    {
        $this->ci->load->helper('security');
        $datos = $this->ci->security->xss_clean($datos);

        $usuario = $this->ci->Auth_model->get_user_email($datos['email']);

        if (!$usuario) {
            return ['success' => false, 'message' => 'Usuario no encontrado.'];
        }

        if ($usuario->id_rol == 1) {
            show_error('La interfaz de paciente no esta habilitada hasta el momento.', 403, 'En desarrollo!');
            return;
        }

        if ($usuario && password_verify($datos['password'], $usuario->password)) {

            $this->ci->load->library('session');

            $this->ci->session->set_userdata([
                'id_usuario' => $usuario->id_usuario,
                'email' => $usuario->email,
                'id_rol' => $usuario->id_rol,
                'primer_nombre' => $usuario->primer_nombre,
                'segundo_nombre' => $usuario->segundo_nombre,
                'primer_apellido' => $usuario->primer_apellido,
            ]);

            redirect($this->redirect_rol($usuario->id_rol));
            
        } else {
            return ['success' => false, 'message' => 'Contraseña incorrecta.'];
        }
    }

    public function redirect_rol($rol)
    {
        switch ($rol) {
            case '1':
            case '3':
                return 'dashboard/pacientes';

            case '2':
                return 'dashboard/medicos';

            case '5':
                return 'dashboard/home';
            default:
                return 'error';
        }
    }
}
