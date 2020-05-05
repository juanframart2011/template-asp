<?php

require_once ("secure_area.php");

defined('BASEPATH') OR exit('No direct script access allowed');

 class Abonos extends Secure_area
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('abonos_m');

	}

	public function crear_abono()
	{
		
		$sale_id=$this->input->post("sale_id");
		$sale_id=str_replace("Sy ", "", $sale_id);
		$tipo_pago=$this->input->post("tipo_pago");
		$total_final=$this->input->post("total_final");
		$resto=$this->input->post("resto");
		$abono=$this->input->post("abono");
		$cliente=$this->input->post("cliente");

		if($abono<=0){
			$abono=0;
		}
		
		$result=$this->abonos_m->crear_abono($sale_id,$tipo_pago,$total_final,$resto,$abono,$cliente);

		echo json_encode($result);

	}

	public function imprimir_abono($sale_id=false)
	{
		
		$this->load->model('abonos_m');
		//$razon=$this->abonos_m->obtener_razon();
		$data['sale_id']=array("sale_id"=>$sale_id);
		$empresa=$this->abonos_m->nombre_empresa();
		$data['empresa']=$empresa;
		$telefono=$this->abonos_m->telefono_empresa();
		$data['telefono']=$telefono;
		$web=$this->abonos_m->web_empresa();
		$data['web_empresa']=$web;
		$cliente=$this->abonos_m->cliente($sale_id);
		$data['cliente']=$cliente;/*
		$politica=$this->abonos_m->politica_empresa();
		$data['politica']=$politica;*/
		$telefono=$this->abonos_m->telefono_empresa();
		$data["productos"]=$this->abonos_m->productos_abono($sale_id);
		$data["total_abono"]=$this->abonos_m->total_abono($sale_id);
		$data["abonos"]=$this->abonos_m->lista_abonos($sale_id);
		$data["total_venta"]=$this->abonos_m->total_venta($sale_id);
		//var_dump($data);
		//echo var_dump($razon);
		//$datos=array("data"=>"sss");
		//var_dump($datos);
		
		$this->load->view('partial/header');
		$this->load->view('abonos/v_imprimir_abono',$data);
		$this->load->view('partial/footer');
	}

	public function abonar()
	{
		$this->load->view('partial/header');
		$this->load->view('abonos/v_abonar');
		$this->load->view('partial/footer');
		/*
		$this->load->view('partial/header');
		$this->load->view('abonos/lista_abonos_v');
		$this->load->view('partial/footer');*/
	}

	public function eliminar_venta()
	{
		$this->load->view('partial/header');
		$this->load->view('abonos/eliminar_venta_v');
		$this->load->view('partial/footer');
		/*
		$this->load->view('partial/header');
		$this->load->view('abonos/lista_abonos_v');
		$this->load->view('partial/footer');*/
	}
/*
	public function abonar_cuenta()
	{
		$this->load->view('partial/header');
		$this->load->view('abonos/v_abonar');
		$this->load->view('partial/footer');
	}
*/
	public function cuenta_term_pagada()
	{
		$this->load->view('partial/header');
		$this->load->view('abonos/v_cuentas_pagadas_termi');
		$this->load->view('partial/footer');
	}

	public function cuenta_pagada_no_term()
	{
		$this->load->view('partial/header');
		$this->load->view('abonos/v_cuentas_pagada_no_termi');
		$this->load->view('partial/footer');
	}

	public function entregados()
	{
		$this->load->view('partial/header');
		$this->load->view('abonos/v_entregados');
		$this->load->view('partial/footer');
	}

	public function lista_cuentas()
	{
		$tabla=$this->input->get("tabla");
		$sale_id=$this->input->get("sale_id");
		$result=$this->abonos_m->lista_cuentas($sale_id,$tabla);
		if($tabla)
		{
			$data=array("data"=>$result);
			echo json_encode($data);
		}else{
			echo json_encode($result);
		}
		
	}

	public function cuentas_elim_get()
	{
		$tabla=$this->input->get("tabla");
		$sale_id=$this->input->get("sale_id");
		$result=$this->abonos_m->cuentas_eliminadas($sale_id,$tabla);
		if($tabla)
		{
			$data=array("data"=>$result);
			echo json_encode($data);
		}else{
			echo json_encode($result);
		}
		
	}

	public function lista_cuentas_elim()
	{
		
		$sale_id=$this->input->get("sale_id");
		$result=$this->abonos_m->lista_cuentas_elim($sale_id);
		echo json_encode($result);
		
	}

	public function lista_abonos()
	{
		$sale_id=$this->input->get("sale_id");
		$result=$this->abonos_m->lista_abonos($sale_id);
		echo json_encode($result);
	}

	public function add_abono()
	{
		$sale_id=$this->input->post("sale_id");
		$abono=$this->input->post("abono");
		$tipo_pago=$this->input->post("tipo_pago");
		$result=$this->abonos_m->add_abono($sale_id,$abono,$tipo_pago);
		echo json_encode($result);
	}

	public function saldo()
	{
		$sale_id=$this->input->get("sale_id");		
		$result=$this->abonos_m->saldo($sale_id);
		echo json_encode($result);
	}

	public function cuentas_terminadas()
	{
		$tabla=$this->input->get("tabla");
		$result=$this->abonos_m->cuentas_terminadas();
		
		if($tabla)
		{
			$data=array("data"=>$result);
			echo json_encode($data);
		}else{
			echo json_encode($result);
		}
		
	}

	public function productos()
	{
		$sale_id=$this->input->get("sale_id");
		$result=$this->abonos_m->productos($sale_id);
		echo json_encode($result);
	}

	public function productos_eliminados()
	{
		$sale_id=$this->input->get("sale_id");
		$result=$this->abonos_m->productos_eliminados($sale_id);
		echo json_encode($result);
	}

	public function productos_elim()
	{
		$sale_id=$this->input->get("sale_id");
		$result=$this->abonos_m->productos_elim($sale_id);
		echo json_encode($result);
	}

	public function total()
	{
		$this->load->view('partial/header');
		$this->load->view('abonos/reporte_abonos_v');
		$this->load->view('partial/footer');
	}

	public function buscar_venta()
	{
		$this->load->view('partial/header');
		$this->load->view('abonos/buscar_venta_v');
		$this->load->view('partial/footer');
	}

	public function ventas_eliminadas()
	{
		$this->load->view('partial/header');
		$this->load->view('abonos/ventas_eliminadas_v');
		$this->load->view('partial/footer');
	}

	public function entregar()
	{
		$sale_id=$this->input->get("sale_id");
		$result=$this->abonos_m->entregar($sale_id);
		echo json_encode($result);
	}


	public function total_diario()
	{
		$fecha=$this->input->get("fecha");
		$result=$this->abonos_m->total_diario($fecha);
		echo json_encode($result);
	}

	public function ultimos_dias()
	{
		$data=array();
		$result=$this->abonos_m->ultimos_dias();
		echo json_encode($result);
	}

	public function periodo()
	{
		$fecha1=$this->input->get("fecha1");
		$fecha2=$this->input->get("fecha2");
		$data=array();
		$result=$this->abonos_m->periodo($fecha1,$fecha2);
		echo json_encode($result);
	}

	public function ganancia()
	{
		$fecha1=$this->input->get("fecha1");
		$fecha2=$this->input->get("fecha2");
		$data=array();
		$result=$this->abonos_m->ganancia($fecha1,$fecha2);
		echo json_encode($result);
	}

	public function entregadas()
	{
		$data=array();
		$result=$this->abonos_m->entregadas();
		$data=array("data"=>$result);
		echo json_encode($data);
	}

	public function cta_pagada_no_ter()
	{
		$result=$this->abonos_m->cta_pagada_no_ter();
		$tabla=$this->input->get("tabla");

		if($tabla)
		{
			$data=array("data"=>$result);
			echo json_encode($data);
		}else{
			echo json_encode($result);
		}
	}

	public function total_diario_venta()
	{
		$result=$this->abonos_m->total_diario_venta();
		echo json_encode($result);
	}

	public function total_diario_abonos()
	{
		$result=$this->abonos_m->total_diario_abonos();
		echo json_encode($result);
	}

	public function trabajos_pendientes()
	{
		$result=$this->abonos_m->trabajos_pendientes();
		echo json_encode($result);
	}

	public function deudas_clientes()
	{
		$result=$this->abonos_m->deudas_clientes();
		echo json_encode($result);
	}

	public function empleados()
	{
		$result=$this->abonos_m->empleados();
		echo json_encode($result);
	}

	public function por_empleado_caja()
	{
		$id_empleado=$this->input->get("id_empleado");
		$fecha=$this->input->get("fecha");
		$tipo_pago=$this->input->get("tipo_pago");

		$result=$this->abonos_m->por_empleado_caja($id_empleado,$fecha,$tipo_pago);
		echo json_encode($result);
	}

	public function por_dia_caja()
	{
		//$id_empleado=$this->input->get("id_empleado");
		$fecha=$this->input->get("fecha");
		$tipo_pago=$this->input->get("tipo_pago");

		$result=$this->abonos_m->por_dia_caja($fecha,$tipo_pago);
		echo json_encode($result);
	}

	public function por_dia()
	{
		//$id_empleado=$this->input->get("id_empleado");
		$fecha=$this->input->get("fecha");
		$tipo_pago=$this->input->get("tipo_pago");

		$result=$this->abonos_m->por_dia($fecha,$tipo_pago);
		echo json_encode($result);
	}

	public function eliminar()
	{
		$sale_id=$this->input->post("sale_id");
		
		$result=$this->abonos_m->eliminar_venta($sale_id);
		echo json_encode($result);
	}


}
