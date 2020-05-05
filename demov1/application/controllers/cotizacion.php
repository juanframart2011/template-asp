<?php

require_once ("secure_area.php");

defined('BASEPATH') OR exit('No direct script access allowed');

 class Cotizacion extends Secure_area
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('pdf');
		$this->load->model("cotizacion_m");
		//$this->load->model('abonos_m');

	}

	public function index()
	{
		$this->load->view('partial/header');
		$this->load->view('cotizacion/cotizacion_v');
		$this->load->view('partial/footer');
	}

	public function buscar()
	{
		$this->load->view('partial/header');
		$this->load->view('cotizacion/buscar_cotizacion_v');
		$this->load->view('partial/footer');
	}

	public function editar()
	{
		$this->load->view('partial/header');
		$this->load->view('cotizacion/editar_cotizacion_v');
		$this->load->view('partial/footer');
	}

	public function venta($id_cotizacion=false)
	{
		$data['data']=$this->cotizacion_m->get_cotizaciones($id_cotizacion);
		$data['productos']=$this->cotizacion_m->get_productos($id_cotizacion);
		$this->load->view('partial/header');
		$this->load->view('cotizacion/venta_v',$data);
		$this->load->view('partial/footer');
	}

	public function enviar($id_cotizacion=false)
	{
		$data['data']=$this->cotizacion_m->get_cotizaciones($id_cotizacion);
		$data['productos']=$this->cotizacion_m->get_productos($id_cotizacion);
		$this->load->view('partial/header');
		$this->load->view('cotizacion/enviar_cotizacion_v',$data);
		$this->load->view('partial/footer');
	}

	public function productos()
	{
		$this->load->model("cotizacion_m");

		$autocomplete=$this->input->get("autocomplete");
		$item_id=$this->input->get("item_id");
		$result=$this->cotizacion_m->productos($item_id,$autocomplete);

		echo json_encode($result);
	}

	public function get_productos()
	{
		$id_cotizacion=$this->input->get("id_cotizacion");
	
		$result=$this->cotizacion_m->get_productos($id_cotizacion,$customer_id);
		echo json_encode($result);
	}

	public function get_cotizaciones()
	{
		$this->load->model("cotizacion_m");
		$id_cotizacion=$this->input->get("id_cotizacion");
		$customer_id=$this->input->get("customer_id");
		$tabla=$this->input->get("tabla");
		$result=$this->cotizacion_m->get_cotizaciones($id_cotizacion,$customer_id);
		if($tabla){
			echo json_encode(array("data"=>$result));
		}else{
			echo json_encode($result);
		}
		

	}



	public function clientes()
	{
		$this->load->model("cotizacion_m");
		$result=$this->cotizacion_m->clientes();

		echo json_encode($result);
	}

	public function add_iva()
	{
		$id_cotizacion=$this->input->post("id_cotizacion");
		//$iva=$this->input->post("iva");
		$total=$this->input->post("total_final");
		$this->load->model("cotizacion_m");
		$result=$this->cotizacion_m->add_iva($id_cotizacion,$total);

		echo json_encode($result);
	}

	public function del_iva()
	{
		$id_cotizacion=$this->input->post("id_cotizacion");
		//$iva=$this->input->post("iva");
		$total=$this->input->post("total_final");
		$this->load->model("cotizacion_m");
		$result=$this->cotizacion_m->del_iva($id_cotizacion,$total);

		echo json_encode($result);
	}

	public function guardar()
	{
		$this->load->model("cotizacion_m");

		$total_venta=0;
		$productos=$this->input->post("productos");
		$person_id=$this->input->post("person_id");
		$comentarios=$this->input->post("comentarios");
		$iva=$this->input->post("iva");

		if(sizeof($productos)==0){
			echo json_encode(array("error"=>1,"comentario"=>"No hay productos.Vacío."));
			return false;
		}


		foreach ($productos as $key) {
			$total_venta=$total_venta+($key['subtotal']);
		
			/*
			echo $key['nombre'];
			echo $key['precio'];
			echo $key['cantidad'];
			*/

		}
		if($total_venta==0 || $total_venta==null){
			echo json_encode(array("error"=>1,"comentario"=>"No hay productos.Vacío."));
			return false;	
		}
		
		
		
		$data=$this->cotizacion_m->guardar($productos,$person_id,$total_venta,$comentarios,$iva);
		echo json_encode(array("id"=>$data));


	}

	public function guardar_venta()
	{
		$id_cotizacion=$this->input->post("id_cotizacion");
		
		$tipo_pago=$this->input->post("tipo_pago");
		$total_final=$this->input->post("total_final");
		$resto=$this->input->post("resto");
		$abono=$this->input->post("abono");
		$cliente=$this->input->post("cliente");

		
		if($abono<=0){
			$abono=0;
		}
		
		$result=$this->cotizacion_m->guardar_venta($id_cotizacion,$tipo_pago,$total_final,$resto,$abono,$cliente);

		echo json_encode($result);
	}

	

	public function generar_pdf($id_cotizacion=false)
	{
		$this->load->library('pdf');
		$data['data']=$this->cotizacion_m->get_cotizaciones($id_cotizacion);
		$data['productos']=$this->cotizacion_m->get_productos($id_cotizacion);


		$logo=($this->Appconfig->get_logo_image());
		$empresa=$this->config->item('company');
		$direccion=nl2br($this->Location->get_info_for_key('address'));
		$telefono=$this->Location->get_info_for_key('phone');
		$web=$this->config->item('website');
		
		$message.='<style type="text/css">
	body{
		color:black;
	}

	table, th, td {
    border: 1px solid #ddd;
}

	table{
		width: 100%;
	}
	.derecha{
		text-align: right;
	}
	.centrado{
		text-align: center;
	}


</style>';

		$message='<div id="content-header" class="receipt_wrapper">
	
		<div class="centrado" style="text-align:center;">
		<h1 class="headigs"> <i class="icon fa fa-barcode"></i>
		Cotización.<p></h1></p>';
		
		$logo='<img src="'.$this->Appconfig->get_logo_image().'"><br>';

	$datos='<label><h3>'.$empresa.'</h3></label><br>
			<label>'.$direccion.'</label><br>
			<label>'.$telefono.'</label><br>
			<label>'.$web.'</label><br>
		</div>
		<br><br>
		<div class="row">
			<div class="col-md-2">
				<label>Número cotización:</label>
				<label>'.$id_cotizacion.'</label>
			</div>
			<div class="col-md-2">
				<label>Fecha:</label>
				<label>'.date_format((new DateTime($data->fecha)),"d-m-Y").'</label>
			</div>
			<div class="col-md-4">
				<label>Cliente:</label>
				<label>'.$data['data']->nombre.'</label>
				
			</div>
			<div class="col-md-4">
				
				<label>Comentarios:</label>
				<label>'.$data['data']->comentarios.'</label>
			</div>
			
		</div>
		
		
	</h1>

	<div class="content">
	<p><h3></h3></p>
	
	<table id="tabla" >
		<thead>
			<tr>
				
				<th>Nombre</th>
				<th>Precio por unidad</th>
				<th>Medidas</th>
				<th>Metros cuadrados</th>
				<th>Comentarios</th>
				<th>Cantidad</th>
				<th>Subtotal</th>
				
			</tr>
		</thead>
		<tbody>';

$prod="";

foreach($data['productos'] as $producto){
	$prod.='<tr>
					<td>'.$producto->name.'</td>
					<td>$'.$producto->precio.'</td>
					<td>Alto:'.$producto->alto.'m x Ancho:'.$producto->ancho.'m</td>	
					<td>'.$producto->metros_cuadrados.'</td>
					<td>'.$producto->comentarios.'</td>
					<td>'.$producto->quantity_purchased.'</td>
					<td>$'.$producto->total.'</td>
			</tr>
				';};
	$prod.='<tr><td></td><td></td><td></td><td></td><td></td><td><h4>IVA(16%)</h4></td><td><h2>$'.$data['data']->total_iva.'</h2></td></tr>';
	$prod.='<tr><td></td><td></td><td></td><td></td><td></td><td><h2>Total</h2></td><td><h2>$'.$data['data']->total_venta.'</h2></td></tr>';


$footer='</tbody></table>
	
</div>';

	$html_content= $message.$logo.$datos.$prod.$footer;
	
			$this->load->library('pdf');
			$this->pdf->loadHtml($html_content);
			$this->pdf->render();
			$this->pdf->stream("Cotizacion_".$id_cotizacion.".pdf", array("Attachment"=>0));
			//var_dump($data['data']->nombre);
	}

}
