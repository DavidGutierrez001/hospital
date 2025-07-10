<?php
defined('BASEPATH') or exit('No direct script access allowed');

class IndexController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Inicio - Royal Care';

		$this->load->view('layout/layout', $data);

		$this->load->view('layout/header');

		$this->load->view('home');

		$this->load->view('layout/footer');
	}
}
