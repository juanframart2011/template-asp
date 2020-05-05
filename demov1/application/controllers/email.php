<?php

require_once ("secure_area.php");

defined('BASEPATH') OR exit('No direct script access allowed');

 class Email extends Secure_area
{

	public function __construct()
	{
		parent::__construct();
		//$this->load->model('abonos_m');

	}

	public function enviar_requerimiento()
	{
		
		$nombre=$this->input->post("nombre");
		
		$apellidos=$this->input->post("apellidos");
		$pais=$this->input->post("pais");
		$estado=$this->input->post("estado");
		$municipio=$this->input->post("municipio");
		$titulo=$this->input->post("titulo");
		$requerimiento=$this->input->post("requerimiento");
		$descripcion=$this->input->post("descripcion");
		
		$to = "daniel@syfors.com";
		$subject = "Requerimiento para Syprint";
		$body = "Hola,\n\n Soy ".$nombre."  ".$apellidos."\n\n Mis requerimientos son:\n\n Titulo:".$titulo."\n\n Requerimiento:".$requerimiento."\n\n Descripcion: ".$descripcion;
		$body=$body."\n\n Mi ubicación:\n\n Pais: ".$pais."\n\n Estado: ".$estado."\n\n Municipio: ".$municipio;
		 if (mail($to, $subject, $body)) {
		   echo json_encode(true);
		  } else {
		   echo json_encode(false);
		  }


		
	}

	public function otro_sistema()
	{
		
		$imprenta=$this->input->post("imprenta");		
		$correo=$this->input->post("correo");
		$whatsapp=$this->input->post("whatsapp");
		
		
		$to = "franciscoramirezvalerio@gmail.com";
		$subject = "Requiero otro sistema Syprint";
		$body = "Hola,\n\n Soy la imprenta".$imprenta."\n\n Mi correo electrónico: ".$correo."\n\n Requerimiento: Necesito otro sistema para imprenta.";
		$body=$body."\n\n Whatsapp: ".$whatsapp;
		 if (mail($to, $subject, $body)) {
		   echo json_encode(true);
		  } else {
		   echo json_encode(false);
		  }


		
	}

	
}
