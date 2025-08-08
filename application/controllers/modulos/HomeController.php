<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HomeController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pacientes_model');
        $this->load->model('Medicos_model');
    }

    public function index()
    {
        $data = [
            'vista' => 'modulos/home/home',
            'title' => 'Home - Royal Care',
            'css' => [
                'assets/css/modulos/home.css',
            ],
            'js' => [
                'assets/js/home.js',
            ],
        ];

        $this->load->view('layout/dashboard_layout', $data);
    }
}
