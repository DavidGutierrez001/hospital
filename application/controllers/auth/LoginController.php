<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('loginusuarioservice');
    }

    public function login_view()
    {
        if ($this->session->userdata('id_usuario')) {
            redirect($this->loginusuarioservice->redirect_rol($this->session->userdata('id_rol')));
        }

        $data = [
            'title' => 'Login',
            'content' => $this->load->view('auth/login', [], true),
            'css' => ['assets/css/login.css'],
            'js' => ['assets/js/login.js'],
        ];

        $this->load->view('/layout/layout', $data);
    }

    public function login()
    {
        $datos = $this->input->post();
        $respuesta = $this->loginusuarioservice->login($datos);

        if ($respuesta['status']) {
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', $respuesta['message']);
            redirect('login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
