<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReportesController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Reportes_model');
    }

    public function index()
    {
        $data = [
            'title' => 'Reportes - Royal Care',
            'primer_nombre' => $this->session->userdata('primer_nombre'),
            'vista' => 'modulos/reportes/reportes_view',
            'reportes_citas' => $this->Reportes_model->getCitasByDay(),
            'reportes_pacientes' => $this->Reportes_model->getPacientesByMonth(),
            'reportes_ventas' => $this->Reportes_model->getVentas(),
            'productos' => $this->Reportes_model->getProductos(),
            'css' => [
                'assets/css/modulos/reportes.css',
            ],
            'js' => [
                'assets/js/reportes.js',
            ],
        ];

        $this->load->view('layout/dashboard_layout', $data);
    }

    public function export_citas()
    {
        $fecha_cita = $this->input->get('fecha_exportar', true);
        $doc_medico = $this->input->get('medico_exportar', true);

        $data = $this->Reportes_model->getCitasByDay($fecha_cita, $doc_medico);

        if (empty($data)) {
            http_response_code(404);
            echo "No se encontraron citas para la fecha seleccionada.";
            return;
        }

        $html = $this->load->view('dompdf/generatecitaspdf', ['reportes_citas' => $data], true);

        $this->load->library('pdf');

        $this->pdf->loadHtml($html);

        $this->pdf->set_option('isRemoteEnabled', true);

        $this->pdf->setPaper('letter', 'portrait');

        $this->pdf->render();

        $this->pdf->stream("reporte_citas.pdf", ['Attachment' => true]);

        $this->pdf->output();
    }

    public function export_pacientes()
    {
        $fecha_cita = $this->input->get('fecha_exportar', true);
        $doc_medico = $this->input->get('medico_exportar', true);

        $data = $this->Reportes_model->getPacientesByMonth($fecha_cita, $doc_medico);

        if (empty($data)) {
            http_response_code(404);
            echo "No se encontraron pacientes para el mes seleccionado.";
            return;
        }

        $html = $this->load->view('dompdf/generatepacientespdf', ['reportes_pacientes' => $data], true);

        $this->load->library('pdf');

        $this->pdf->loadHtml($html);

        $this->pdf->set_option('isRemoteEnabled', true);

        $this->pdf->setPaper('letter', 'portrait');

        $this->pdf->render();

        $this->pdf->stream("reporte_pacientes.pdf", ['Attachment' => true]);

        $this->pdf->output();
    }

    public function export_ventas()
    {
        $producto_exportar = $this->input->get('producto_exportar', true);
        $fecha_producto = $this->input->get('fecha_producto', true);

        $data = $this->Reportes_model->getVentasByMonth($producto_exportar, $fecha_producto);

        if (empty($data)) {
            http_response_code(404);
            echo "No se encontraron ventas para el producto o mes seleccionado.";
            return;
        }

        $html = $this->load->view('dompdf/generateventaspdf', ['reportes_ventas' => $data], true);

        $this->load->library('pdf');

        $this->pdf->loadHtml($html);

        $this->pdf->set_option('isRemoteEnabled', true);

        $this->pdf->setPaper('letter', 'portrait');

        $this->pdf->render();

        $this->pdf->stream("reporte_ventas.pdf", ['Attachment' => true]);

        $this->pdf->output();
    }
}
