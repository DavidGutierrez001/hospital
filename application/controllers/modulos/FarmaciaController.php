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
            'productos' => $this->Farmacia_model->getProductos(),
            'productos_stock' => $this->Farmacia_model->getProductosStock(),
            'ventas' => $this->Farmacia_model->getVentas(),
            'entradas' => $this->Farmacia_model->getEntradas(),
            'salidas' => $this->Farmacia_model->getSalidas(),
        ];

        $this->load->view('layout/dashboard_layout', $data);
    }

    public function register_product()
    {
        if (!$this->validateInput()) {
            return;
        }

        $input = $this->sanitizeInput($this->input->post(), true);

        $insert = $this->Farmacia_model->insert_product($input);

        if ($insert) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => true,
                'message' => 'Producto registrado exitosamente.'
            ]));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => false,
                'message' => 'Error al registrar el producto.'
            ]));
        }
    }

    private function validateInput()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('nombre_comercial', 'Nombre Comercial', 'required|trim');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'required|trim');
        $this->form_validation->set_rules('precio', 'Precio', 'required|numeric|trim');
        $this->form_validation->set_rules('existencias', 'Existencias', 'required|integer|trim');
        $this->form_validation->set_rules('fecha_registro', 'Fecha de Registro', 'required|trim');
        $this->form_validation->set_rules('receta_especial', 'Receta Especial', 'required|in_list[0,1]');

        if ($this->form_validation->run() === FALSE) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => false,
                'message' => strip_tags(validation_errors())
            ]));
            return false;
        }
        return true;
    }

    private function sanitizeInput($input)
    {
        $sanitized = [];
        foreach ($input as $key => $value) {
            $sanitized[$key] = htmlspecialchars(strip_tags(trim($value)));
        }
        return $sanitized;
    }

    public function getProductosStock()
    {
        $productos = $this->Farmacia_model->getProductosStock();

        $this->output->set_content_type('application/json')->set_output(json_encode([
            'success' => true,
            'productos' => $productos
        ]));
    }

    public function searchPacientByDocument()
    {
        $documento = $this->input->post('documento', TRUE);
        if (empty($documento)) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => false,
                'message' => 'El documento del paciente es requerido.'
            ]));
            return;
        }

        if (!$this->Farmacia_model->searchPacientByDocument($documento)) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => false,
                'message' => 'Paciente no encontrado.'
            ]));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => true,
                'message' => 'Paciente encontrado.'
            ]));
        }
    }

    public function register_sale()
    {
        $productos = $this->input->post('productos');
        $documento = $this->input->post('documento');

        foreach ($productos as $id_producto => $cantidad) {
            if ((int)$cantidad > 0 && $documento) {
                $venta = [
                    'id_producto' => $id_producto,
                    'documento' => $documento,
                    'cantidad' => $cantidad,
                    'precio_total' => $this->calcularPrecio($id_producto, $cantidad)
                ];
                $this->Farmacia_model->registerSale($venta);
            }
        }

        redirect('dashboard/farmacia');
    }


    public function calcularPrecio($id_producto, $cantidad)
    {
        $producto = $this->Farmacia_model->getProductoById($id_producto);
        if ($producto) {
            return $producto->precio * $cantidad;
        }
        return 0;
    }

    public function view_editar($id_producto)
    {
        $data['producto'] = $this->Farmacia_model->getProductoById($id_producto);

        if (empty($data['producto'])) {
            show_404();
        }

        $this->load->view('modulos/farmacia/updateProductos', $data);
    }

    public function delete_product($id_producto)
    {
        $producto = $this->Farmacia_model->getProductoById($id_producto);
        if (empty($producto)) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => false,
                'message' => 'Producto no encontrado.'
            ]));
            return;
        }

        $this->Farmacia_model->delete_product($producto);
        $this->output->set_content_type('application/json')->set_output(json_encode([
            'success' => true,
            'message' => 'Producto eliminado correctamente.'
        ]));
    }

    public function update_product($id_producto)
    {
        $data = $this->input->post();

        $update = $this->Farmacia_model->update_product($id_producto, $data);

        if ($update) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'message' => 'Producto actualizado correctamente.'
                ]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'No se pudo actualizar el producto.'
                ]));
        }
    }

    public function agregarExistencias($id_producto)
    {
        $existencias = $this->input->post('cantidad', TRUE);

        if (empty($existencias) || !is_numeric($existencias) || $existencias < 0) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => false,
                'message' => 'Cantidad de existencias inválida.'
            ]));
            return;
        }

        $producto = $this->Farmacia_model->getProductoById($id_producto);
        if (!$producto) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => false,
                'message' => 'Producto no encontrado.'
            ]));
            return;
        }

        $producto->existencias += (int)$existencias;
        $this->Farmacia_model->update_product($id_producto, (array)$producto);

        $this->Farmacia_model->agregarEntrada($id_producto, $existencias);

        $this->output->set_content_type('application/json')->set_output(json_encode([
            'success' => true,
            'message' => 'Existencias actualizadas correctamente.'
        ]));
    }
}
