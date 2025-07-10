<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (!$this->session->userdata('id_usuario')) {
            redirect('login');
        }

        $data = [
            'title' => 'Panel de Control - Royal Care',
            'primer_nombre' => $this->session->userdata('primer_nombre'),
            'css' => [
                'assets/css/dashboard.css',
            ],
            'js' => [
                'assets/js/dashboard.js',
            ],
        ];

        $this->load->view('layout/dashboard_layout', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
    }
}
