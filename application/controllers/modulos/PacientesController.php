<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PacientesController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pacientes_model');
    }

    public function index()
    {
        $data = [
            'css' => [
                'assets/css/modulos/pacientes.css',
            ],
            'js' => [
                'assets/js/pacientes.js',
            ],
            'pacientes' => $this->Pacientes_model->get_all(),
            'vista' => 'modulos/pacientes/pacientes',
            'title' => 'Pacientes - Royal Care',
        ];

        $this->load->view('layout/dashboard_layout', $data);
    }

    public function view_editar($id)
    {
        $data['paciente'] = $this->Pacientes_model->get_by_id($id);
        $this->load->view('modulos/pacientes/update', $data);
    }

    public function update($id)
    {
        $paciente = $this->Pacientes_model->get_by_id($id);

        if (empty($paciente)) {
            echo json_encode(['success' => false, 'message' => 'Paciente no encontrado']);
            return;
        }

        $this->form_validation->set_rules('primer_nombre', 'Primer Nombre', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('segundo_nombre', 'Segundo Nombre', 'trim|htmlspecialchars');
        $this->form_validation->set_rules('primer_apellido', 'Primer Apellido', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('segundo_apellido', 'Segundo Apellido', 'trim|htmlspecialchars');
        $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de Nacimiento', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('genero', 'Género', 'required|trim|in_list[masculino,femenino,otro]');
        $this->form_validation->set_rules('documento', 'Documento', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('tipo_documento', 'Tipo de Documento', 'required|trim|in_list[Cedula de ciudadania,Cedula de extranjeria]');
        $this->form_validation->set_rules('telefono', 'Telefono', 'trim|htmlspecialchars');
        $this->form_validation->set_rules('direccion', 'Dirección', 'trim|htmlspecialchars');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => false, 'message' => validation_errors()]);
            return;
        }

        if ($this->Pacientes_model->document_exist($this->input->post('documento', TRUE), $id)) {
            echo json_encode(['success' => false, 'message' => 'El documento ya existe']);
            return;
        }

        $dataPaciente = [
            'fecha_nacimiento' => htmlspecialchars(trim($this->input->post('fecha_nacimiento', TRUE))),
            'genero'           => htmlspecialchars(trim($this->input->post('genero', TRUE))),
            'documento'        => htmlspecialchars(trim($this->input->post('documento', TRUE))),
            'tipo_documento'   => htmlspecialchars(trim($this->input->post('tipo_documento', TRUE))),
            'estado_civil'     => htmlspecialchars(trim($this->input->post('estado_civil', TRUE))),
            'telefono'         => htmlspecialchars(trim($this->input->post('telefono', TRUE))),
            'direccion'        => htmlspecialchars(trim($this->input->post('direccion', TRUE))),
        ];

        $dataUsuario = [
            'primer_nombre'    => htmlspecialchars(trim($this->input->post('primer_nombre', TRUE))),
            'primer_apellido'  => htmlspecialchars(trim($this->input->post('primer_apellido', TRUE))),
            'segundo_apellido' => htmlspecialchars(trim($this->input->post('segundo_apellido', TRUE))),
            'segundo_nombre'   => htmlspecialchars(trim($this->input->post('segundo_nombre', TRUE))),
        ];

        $actualizado = $this->Pacientes_model->update($id, $dataPaciente, $dataUsuario);

        echo json_encode([
            'success' => $actualizado,
            'message' => $actualizado ? 'Paciente actualizado correctamente' : 'Error al actualizar'
        ]);
    }

    public function create()
    {
        $this->form_validation->set_rules('primer_nombre', 'Primer Nombre', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('segundo_nombre', 'Segundo Nombre', 'trim|htmlspecialchars');
        $this->form_validation->set_rules('primer_apellido', 'Primer Apellido', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('segundo_apellido', 'Segundo Apellido', 'trim|htmlspecialchars');
        $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de Nacimiento', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('genero', 'Género', 'required|trim|in_list[masculino,femenino,otro]');
        $this->form_validation->set_rules('documento', 'Documento', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('tipo_documento', 'Tipo de Documento', 'required|trim|in_list[Cedula de ciudadania,Cedula de extranjeria]');
        $this->form_validation->set_rules('telefono', 'Telefono', 'trim|htmlspecialchars');
        $this->form_validation->set_rules('direccion', 'Dirección', 'trim|htmlspecialchars');
        $this->form_validation->set_rules('estado_civil', 'Estado Civil', 'trim|htmlspecialchars|in_list[soltero,casado,divorciado,viudo]');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|htmlspecialchars');
        $this->form_validation->set_rules('password', 'Contraseña', 'required|min_length[3]|max_length[20]|trim|htmlspecialchars');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => false, 'message' => validation_errors()]);
            return;
        }

        if ($this->Pacientes_model->document_exist($this->input->post('documento', TRUE))) {
            echo json_encode(['success' => false, 'message' => 'El documento ya existe']);
            return;
        }

        $dataPaciente = [
            'fecha_nacimiento' => htmlspecialchars(trim($this->input->post('fecha_nacimiento', TRUE))),
            'genero'           => htmlspecialchars(trim($this->input->post('genero', TRUE))),
            'documento'        => htmlspecialchars(trim($this->input->post('documento', TRUE))),
            'tipo_documento'   => htmlspecialchars(trim($this->input->post('tipo_documento', TRUE))),
            'estado_civil'     => htmlspecialchars(trim($this->input->post('estado_civil', TRUE))),
            'telefono'         => htmlspecialchars(trim($this->input->post('telefono', TRUE))),
            'direccion'        => htmlspecialchars(trim($this->input->post('direccion', TRUE))),
        ];

        $dataUsuario = [
            'id_rol'             => '1',
            'primer_nombre'   => htmlspecialchars(trim($this->input->post('primer_nombre', TRUE))),
            'primer_apellido' => htmlspecialchars(trim($this->input->post('primer_apellido', TRUE))),
            'segundo_apellido' => htmlspecialchars(trim($this->input->post('segundo_apellido', TRUE))),
            'segundo_nombre'  => htmlspecialchars(trim($this->input->post('segundo_nombre', TRUE))),
            'email'           => htmlspecialchars(trim($this->input->post('email', TRUE))),
            'password'        => password_hash($this->input->post('password', TRUE), PASSWORD_BCRYPT),
            'fecha_registro' => date('Y-m-d h:i:s'),
            'activo'         => true,
        ];

        $creado = $this->Pacientes_model->create($dataPaciente, $dataUsuario);

        echo json_encode([
            'success' => $creado,
            'message' => $creado ? 'Paciente creado correctamente' : 'Error al crear el paciente'
        ]);
    }

    public function delete($id)
    {
        header('Content-Type: application/json');

        if (!$id || !is_numeric($id)) {
            echo json_encode(['success' => false, 'message' => 'ID inválido']);
            return;
        }

        $eliminado = $this->Pacientes_model->delete($id);

        echo json_encode([
            'success' => $eliminado,
            'message' => $eliminado ? 'Paciente eliminado correctamente' : 'No se pudo eliminar el paciente'
        ]);
    }
}
