<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HistorialController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Historial_model');
    }

    public function index()
    {
        $data = [
            'historiales' => $this->Historial_model->get_all_historial(),
            'vista' => 'modulos/historial/historial',
            'title' => 'Historial Médico - Royal Care',
            'js' => ['assets/js/historial.js'],
            'css' => ['assets/css/modulos/historial.css'],
        ];

        $this->load->view('layout/dashboard_layout', $data);
    }

    public function get_historial_by_id($id_paciente)

    {
        $historial = $this->Historial_model->get_historial_by_id($id_paciente);

        if ($historial) {
            echo json_encode([
                'success' => true,
                'historial' => $historial,
                ]
            );
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Historial no encontrado'
            ]);
        }
    }
}
