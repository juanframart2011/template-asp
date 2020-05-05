<?php

require_once ("secure_area.php");

defined('BASEPATH') OR exit('No direct script access allowed');

 class Licencia extends Secure_area
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('licencia_m');

	}

	public function obtener_licencia()
	{
		
		$result=$this->licencia_m->obtener_licencia();
		
		echo json_encode($result);

	}

	
}
