<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RegisterController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('RegistroUsuarioService');
    }

    public function register_view()
    {
        if ($this->session->userdata('id_usuario')) {
            redirect('dashboard');
        }

        $data['css'] = ['assets/css/register.css'];
        $data['js'] = ['assets/js/register.js'];
        $data['title'] = 'Crea tu Cuenta - Royal Care';
        $data['content'] = $this->load->view('/auth/register', [], true);

        $this->load->view('/layout/layout', $data);
    }

    public function register()
    {
        $datos = $this->input->post();

        if (empty($datos['email']) || empty($datos['password'])) {
            echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios.']);
            return;
        }

        $respuesta = $this->registrousuarioservice->registrar($datos);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($respuesta));
    }

    public function verify_email()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $email = isset($input['email']) ? $input['email'] : '';

        $this->db->where('email', $email);
        $existe = $this->db->get('usuarios')->num_rows() > 0;

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['valido' => !$existe]));
    }
}
