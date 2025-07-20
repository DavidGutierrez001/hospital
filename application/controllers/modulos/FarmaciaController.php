<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FarmaciaController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Farmacia_model');
    }

    public function index()
    {
        $data = [
            'title' => 'Farmacia - Royal Care',
            'vista' => 'modulos/farmacia/farmacia',
            'css' => [
                'assets/css/modulos/farmacia.css',
            ],
            'js' => [
                'assets/js/farmacia.js',
            ],
            'medicamentos' => $this->Farmacia_model->getMedicamentos(),
        ];

        $this->load->view('layout/dashboard_layout', $data);
    }
}
