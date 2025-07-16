<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CitasController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Citas_model', 'Medicos_model', 'Pacientes_model']);
    }

    public function index()
    {
        $data = [
            'vista' => 'modulos/citas/citas',
            'citas' => $this->Citas_model->get_all_citas(),
            'especialidades' => $this->Medicos_model->get_especialidades(),
            'title' => 'Citas Médicas - Royal Care',
            'library' => [
                'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js',
                'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/locales-all.global.min.js',
            ],
            'js' => [
                'assets/js/citas.js',
            ],
            'css' => [
                'assets/css/modulos/citas.css',
            ],
        ];

        $this->load->view('layout/dashboard_layout', $data);

        $fecha_cita = '2025-07-14';
        $hora_inicio = '09:00:00';
        $duracion = 30;
        $hora_fin = date('H:i:s', strtotime("+{$duracion} minutes", strtotime($hora_inicio)));
        $id_especialidad = 6;

        $this->Medicos_model->get_available_medico($id_especialidad, $fecha_cita, $hora_inicio, $hora_fin);
    }

    public function verify_available_citas()
    {
        $fecha_cita = $this->input->post('fecha_cita', true);
        $hora_inicio = $this->input->post('hora_inicio', true);
        $duracion = $this->input->post('duracion', true) ?: 30;
        $id_especialidad = $this->input->post('especialidad', true);

        header('Content-Type: application/json');

        if (!$fecha_cita || !$hora_inicio || !$id_especialidad) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Primero debes llenar todos los campos.',
            ]);
            return;
        }

        try {
            $hora_fin = date('H:i:s', strtotime("+{$duracion} minutes", strtotime($hora_inicio)));

            $medicos = $this->Medicos_model->get_available_medico(
                $id_especialidad,
                $fecha_cita,
                $hora_inicio,
                $hora_fin
            );

            if (!empty($medicos)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Médicos disponibles.',
                    'medicos' => $medicos,
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No hay médicos disponibles en este horario.',
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Ocurrió un error al procesar la solicitud: ' . $e->getMessage(),
            ]);
        }
    }

    public function create_cita()
    {
        if ($this->Citas_model->not_pending_citas($this->input->post('doc_paciente', true))) {
            return $this->json_response('error', 'El paciente ya tiene una cita pendiente.');
        }

        $this->set_form_validation_rules();

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => 'error',
                'message' => strip_tags(validation_errors()),
            ]);
            return;
        };

        $data = $this->sanitize();

        $insert = $this->Citas_model->insert_cita($data);

        if (!$insert['success']) {
            return $this->json_response('error', $insert['error']);
        }

        return $this->json_response('success', 'Cita médica agendada correctamente.');
    }

    private function sanitize()
    {
        return [
            'doc_paciente'    => $this->input->post('doc_paciente', true),
            'id_medico'       => $this->input->post('medico', true),
            'fecha_cita'      => $this->input->post('fecha_cita', true),
            'hora_inicio'     => $this->input->post('hora_inicio', true),
            'duracion'        => $this->input->post('duracion', true),
            'hora_fin'        => date('H:i:s', strtotime($this->input->post('hora_inicio', true) . ' +30 minutes')),
            'id_especialidad' => $this->input->post('especialidad', true),
            'estado_cita'     => 'Programada',
        ];
    }

    private function set_form_validation_rules()
    {
        $this->form_validation->set_rules('fecha_cita', 'Fecha de la cita', 'required');
        $this->form_validation->set_rules('hora_inicio', 'Hora de inicio', 'required');
        $this->form_validation->set_rules('duracion', 'Duración de la cita', 'required|integer');
        $this->form_validation->set_rules('especialidad', 'Especialidad del médico', 'required');
        $this->form_validation->set_rules('doc_paciente', 'Documento del paciente', 'required');
        $this->form_validation->set_rules('medico', 'Médico seleccionado', 'required');
    }

    private function json_response($status, $message)
    {
        echo json_encode(['status' => $status, 'message' => $message]);
    }

    public function cancel_cita($id_cita)
    {
        $cita = $this->Citas_model->get_cita_by_id($id_cita);

        if (!$cita) {
            return $this->json_response('error', 'Cita no encontrada.');
        }

        $is_cancel = $this->Citas_model->cancel_cita($id_cita);

        if (!$is_cancel) {
            return $this->json_response('error', 'No se pudo cancelar la cita médica.');
        }

        return $this->json_response('success', 'Cita médica cancelada correctamente.');
    }

    public function get_next_citas_json()
    {
        header('Content-Type: application/json');

        $citas = $this->Citas_model->get_next_citas();

        $eventos = [];


        if (is_array($citas) && !empty($citas)) {
            foreach ($citas as $cita) {
                $eventos[] = [
                    'title' => $cita->paciente_nombre . ' ' . $cita->paciente_apellido,
                    'start' => $cita->fecha_cita . 'T' . $cita->hora_inicio,
                ];
            }
        }

        echo json_encode($eventos);
    }


    public function reagendar_cita()
    {
        $data = $this->sanitize_reagendar_cita();
        $id_cita = $data['id_cita'];

        $cita_actual = $this->Citas_model->get_cita_by_id($id_cita);
        if (!in_array($cita_actual->estado_cita, ['Programada', 'Confirmada'])) {
            return $this->json_response('error', 'No puedes reagendar una cita que ha sido cancelada o ya asistida.');
        }

        $medico_actual = $this->Citas_model->get_medico_by_cita($id_cita);

        $disponible = $this->Citas_model->validar_disponibilidad_reagendar(
            $medico_actual,
            $data['fecha_cita'],
            $data['hora_inicio'],
            $data['hora_fin'],
            $id_cita
        );

        if (!$disponible) {
            return $this->json_response('error', 'El médico ya tiene una cita en ese horario.');
        }

        $result = $this->Citas_model->reagendar_cita($data);

        if (!$result['success']) {
            return $this->json_response('error', $result['error']);
        }

        return $this->json_response('success', 'Cita médica reagendada correctamente.');
    }



    private function sanitize_reagendar_cita()
    {
        return [
            'id_cita'       => $this->input->post('id_cita', true),
            'fecha_cita'    => $this->input->post('fecha_cita', true),
            'hora_inicio'   => $this->input->post('hora_inicio', true),
            'hora_fin'      => date('H:i:s', strtotime($this->input->post('hora_inicio', true) . ' +30 minutes')),
        ];
    }
}
