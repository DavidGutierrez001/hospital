<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HistorialController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Historial_model');
        $this->load->library('form_validation');
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

    public function get_historial_by_id($id_historial)
    {
        header('Content-Type: application/json');

        if (!is_numeric($id_historial)) {
            echo json_encode([
                'success' => false,
                'message' => 'ID inválido'
            ]);
            return;
        }

        $historial = $this->Historial_model->get_historial_by_id($id_historial);

        if ($historial) {
            echo json_encode([
                'success' => true,
                'historial' => $this->load->view('modulos/historial/detail_historial', ['historial' => $historial], true)
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Historial no encontrado'
            ]);
        }
    }

    public function create_historial()
    {
        $data = $this->get_form_create();

        if (!$this->valid_form_create()) {
            echo json_encode([
                'success' => false,
                'message' => strip_tags(validation_errors())
            ]);
            return;
        }

        if ($this->Historial_model->create_historial($data)) {
            echo json_encode([
                'success' => true,
                'message' => 'Historia médica creada exitosamente'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al crear la historia médica'
            ]);
        }
    }

    private function get_form_create()
    {
        return [
            'documento_paciente' => $this->input->post('documento_paciente', true),
            'documento_medico' => $this->input->post('documento_medico', true),
            'motivo_consulta' => $this->input->post('motivo_consulta', true),
            'diagnostico' => $this->input->post('diagnostico', true),
            'tratamiento' => $this->input->post('tratamiento', true),
            'examen_fisico' => $this->input->post('examen_fisico', true),
            'resultados_pruebas' => $this->input->post('resultados_pruebas', true),
            'antecedentes_personales' => $this->input->post('antecedentes_personales', true),
            'antecedentes_familiares' => $this->input->post('antecedentes_familiares', true),
            'estilo_vida' => $this->input->post('estilo_vida', true),
            'notas_generales' => $this->input->post('notas_generales', true),
            'proxima_cita' => $this->input->post('proxima_cita', true),
        ];
    }

    private function valid_form_create()
    {
        $this->form_validation->set_rules('documento_paciente', 'Documento del paciente', 'required|trim');
        $this->form_validation->set_rules('documento_medico', 'Documento del médico', 'required|trim');
        $this->form_validation->set_rules('motivo_consulta', 'Motivo de Consulta', 'required|trim');
        $this->form_validation->set_rules('diagnostico', 'Diagnóstico', 'required|trim');
        $this->form_validation->set_rules('tratamiento', 'Tratamiento', 'required|trim');
        $this->form_validation->set_rules('examen_fisico', 'Examen Físico', 'required|trim');
        $this->form_validation->set_rules('resultados_pruebas', 'Resultado de Pruebas', 'trim');
        $this->form_validation->set_rules('antecedentes_personales', 'Antecedentes Personales', 'trim');
        $this->form_validation->set_rules('antecedentes_familiares', 'Antecedentes Familiares', 'trim');
        $this->form_validation->set_rules('estilo_vida', 'Estilo de Vida', 'trim');
        $this->form_validation->set_rules('notas_generales', 'Notas Generales', 'trim');
        $this->form_validation->set_rules('proxima_cita', 'Próxima Cita', 'trim');

        return $this->form_validation->run();
    }

    public function delete_historial($id_historial)
    {
        header('Content-Type: application/json');

        if (!is_numeric($id_historial)) {
            echo json_encode([
                'success' => false,
                'message' => 'ID inválido'
            ]);
            return;
        }

        $historial = $this->Historial_model->delete_historial($id_historial);

        if ($historial) {
            echo json_encode([
                'success' => true,
                'message' => 'Historial eliminado exitosamente'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No se pudo eliminar el historial'
            ]);
        }
    }
}
