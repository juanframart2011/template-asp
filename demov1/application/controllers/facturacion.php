<?php

require_once ("secure_area.php");

defined('BASEPATH') OR exit('No direct script access allowed');

 class Facturacion extends Secure_area
{

	public function __construct()
	{
		parent::__construct();
		//$this->load->model('abonos_m');

	}

	public function index()
	{
		$this->load->view('partial/header');
		$this->load->view('facturacion/facturacion_v');
		$this->load->view('partial/footer');
	}
}
