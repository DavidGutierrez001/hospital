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
        $data = $this->getHomePageData();
        $this->load->view('layout/dashboard_layout', $data);
    }

    private function getHomePageData()
    {
        $pacientes = $this->Pacientes_model->count_users();
        $medicos = $this->Medicos_model->count_users();

        return [
            'title' => 'Home - Royal Care',
            'css' => [
                'assets/css/modulos/home.css',
            ],
            'vista' => 'modulos/home/home',
            'labels' => ['Médicos', 'Pacientes', 'Recepcionistas', 'Farmaceuticos'],
            'valores' => [$medicos, $pacientes],
        ];
    }
}
