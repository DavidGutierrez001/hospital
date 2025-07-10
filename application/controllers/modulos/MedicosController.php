<?php defined('BASEPATH') or exit('No direct script access allowed');

class MedicosController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Medicos_model');
    }

    public function index()
    {
        $data = [
            'medicos' => $this->Medicos_model->get_all(),
            'especialidades' => $this->Medicos_model->get_especialidades(),
            'vista' => 'modulos/medicos/medicos',
            'title' => 'Médicos - Royal Care',
            'css' => [
                'assets/css/modulos/medicos.css',
            ],
            'js' => [
                'assets/js/medicos.js',
            ],
        ];

        $this->load->view('layout/dashboard_layout', $data);
    }

    public function view_editar($id)
    {
        $data['medicos'] = $this->Medicos_model->get_by_id($id);
        if (empty($data['medicos'])) {
            show_404();
        }
        $data['especialidades'] = $this->Medicos_model->get_especialidades();
        $this->load->view('modulos/medicos/update', $data);
    }

    private function form_validation_medical()
    {
        $this->form_validation->set_rules('primer_nombre', 'Primer Nombre', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('segundo_nombre', 'Segundo Nombre', 'trim|htmlspecialchars');
        $this->form_validation->set_rules('primer_apellido', 'Primer Apellido', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('segundo_apellido', 'Segundo Apellido', 'trim|htmlspecialchars');
        $this->form_validation->set_rules('contacto', 'Contacto', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('especialidad', 'Especialidad', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('email', 'E-mail', 'required|trim|htmlspecialchars|valid_email');
        $this->form_validation->set_rules('password', 'Contraseña', 'required|trim|htmlspecialchars|min_length[3]|max_length[20]');

        return $this->form_validation->run();
    }

    private function get_form_medical()
    {
        return [
            'medical' => [
                'contacto'         => $this->input->post('contacto', TRUE),
                'id_especialidad'  => $this->input->post('especialidad', TRUE),
                'activo'           => TRUE
            ],
            'user' => [
                'id_rol'           => 2,
                'primer_nombre'    => $this->input->post('primer_nombre', TRUE),
                'segundo_nombre'   => $this->input->post('segundo_nombre', TRUE),
                'primer_apellido'  => $this->input->post('primer_apellido', TRUE),
                'segundo_apellido' => $this->input->post('segundo_apellido', TRUE),
                'email'            => $this->input->post('email', TRUE),
                'password'         => password_hash($this->input->post('password', TRUE), PASSWORD_BCRYPT),
                'fecha_registro'   => date('Y-m-d h:i:s'),
                'activo'           => TRUE
            ]
        ];
    }

    public function create()
    {
        if (!$this->form_validation_medical()) {
            $this->respond_json(false, validation_errors());
            return;
        }

        $form_data = $this->get_form_medical();

        $this->load->model('Usuarios_model');
        $id_usuario = $this->Usuarios_model->create_user($form_data['user']);

        if (!$id_usuario) {
            $this->respond_json(false, 'Error al crear el usuario.');
            return;
        }

        $form_data['medical']['id_usuario'] = $id_usuario;
        $create_medical = $this->Medicos_model->create($form_data['medical']);

        if (!$create_medical) {
            $this->respond_json(false, 'Error al crear el médico.');
            return;
        }

        $this->respond_json(true, 'Médico creado correctamente.');
    }

    public function update($id)
    {
        $medico = $this->Medicos_model->get_by_id($id);

        if (empty($medico)) {
            $this->respond_json(false, 'Médico no encontrado');
            return;
        }

        $this->form_validation->set_rules('primer_nombre', 'Primer Nombre', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('segundo_nombre', 'Segundo Nombre', 'trim|htmlspecialchars');
        $this->form_validation->set_rules('primer_apellido', 'Primer Apellido', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('segundo_apellido', 'Segundo Apellido', 'trim|htmlspecialchars');
        $this->form_validation->set_rules('contacto', 'Contacto', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('especialidad', 'Especialidad', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('email', 'E-mail', 'required|trim|htmlspecialchars|valid_email');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => false, 'message' => validation_errors()]);
            return;
        }

        $dataUser = [
            'primer_nombre'    => $this->input->post('primer_nombre', TRUE),
            'segundo_nombre'   => $this->input->post('segundo_nombre', TRUE),
            'primer_apellido'  => $this->input->post('primer_apellido', TRUE),
            'segundo_apellido' => $this->input->post('segundo_apellido', TRUE),
            'email'            => $this->input->post('email', TRUE),
            'activo'           => $this->input->post('estado', TRUE) == 1 ? TRUE : FALSE
        ];

        $dataMedical = [
            'contacto'         => $this->input->post('contacto', TRUE),
            'id_especialidad'  => $this->input->post('especialidad', TRUE),
            'activo'           => $this->input->post('estado', TRUE) == 1 ? TRUE : FALSE
        ];

        $this->load->model('Usuarios_model');

        $this->db->trans_start();

        $this->Usuarios_model->update_user($medico->id_usuario, $dataUser);

        $this->Medicos_model->update($id, $dataMedical);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos.']);
            return;
        }

        echo json_encode([
            'success' => true,
            'message' => 'Médico actualizado correctamenteee.'
        ]);
    }

    public function delete($id)
    {

        $medical = $this->Medicos_model->get_by_id($id);

        if (empty($medical)) {
            $this->respond_json(false, 'Médico no encontrado');
            return;
        }

        $delete_medical = $this->Medicos_model->delete($id);

        if (!$delete_medical) {
            $this->respond_json(false, 'Error al eliminar el médico.');
            return;
        } else {
            $this->load->model('Usuarios_model');
            $delete_user = $this->Usuarios_model->delete_user($medical->id_usuario);

            if (!$delete_user) {
                $this->respond_json(false, 'Error al eliminar el usuario asociado al médico.');
                return;
            }
        }

        echo json_encode([
            'success' => true,
            'message' => 'Médico eliminado correctamente.'
        ]);
    }

    private function respond_json($success, $message)
    {
        echo json_encode([
            'success' => $success,
            'message' => $message
        ]);
        exit;
    }
}
