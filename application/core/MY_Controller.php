<?php
class MY_Controller extends CI_Controller
{
    public $rol_id;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Permisos_model');

        $this->rol_id = $this->session->userdata('id_rol');

        if (!$this->rol_id) {
            redirect('login');
        }

        $modulo = $this->router->fetch_class();

        if (!$this->Permisos_model->tiene_acceso($this->rol_id, $modulo)) {
            $this->load->library('loginusuarioservice');
            $this->session->set_flashdata('error', 'No tienes permiso para acceder a este módulo.');
            redirect($this->loginusuarioservice->redirect_rol($this->rol_id));
        }
    }
}
