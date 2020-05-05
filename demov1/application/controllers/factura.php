<?php

require_once ("secure_area.php");

defined('BASEPATH') OR exit('No direct script access allowed');

 class Factura extends Secure_area
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('facturas_m');

	}

	public function buscar()
	{
		$this->load->view('partial/header');
		$this->load->view('factura/buscar_factura');
		$this->load->view('partial/footer');

	}

	public function form_email()
	{
		$this->load->view('partial/header');
		$this->load->view('factura/form_xml');
		$this->load->view('partial/footer');
	}

	public function enviar_xml()
	{
		$this->load->view("partial/header");

		$this->load->library('email');
		$data=$this->facturas_m->obtener_correo();
		$remitente=$data->email;
		$razon_social=$this->facturas_m->obtener_razon();
		//var_dump($razon_social);

		//Archivo 1
		$file = $_FILES["archivo1"];
	    $nombre = $file["name"];
	    $tipo = $file["type"];
	    $ruta_provisional = $file["tmp_name"];
	    $size = $file["size"];
	    $dimensiones = getimagesize($ruta_provisional);
	    $width = $dimensiones[0];
	    $height = $dimensiones[1];
	    $carpeta = "././facturas/";
		$src = $carpeta.$nombre;

		//Archivo 2
		$file2 = $_FILES["archivo2"];
	    $nombre2 = $file2["name"];
	    $tipo2 = $file2["type"];
	    $ruta_provisional2 = $file2["tmp_name"];
	    $size2 = $file2["size"];
	    $dimensiones2 = getimagesize($ruta_provisional2);
	    $width2 = $dimensiones2[0];
	    $height2 = $dimensiones2[1];
	    $carpeta = "././facturas/";
		$src2 = $carpeta.$nombre2;
		
		if( (move_uploaded_file($ruta_provisional, $src)) && (move_uploaded_file($ruta_provisional2, $src2))){
				
				$asunto=$this->input->post("asunto");
				$mensaje=$this->input->post("mensaje");
				$destinatario=$this->input->post("correo");

	            $this->email->from($remitente, $razon_social->razon_social);
				$this->email->to($destinatario);
				$this->email->subject($asunto);
				$this->email->message($mensaje);
				$this->email->attach('facturas/'.$nombre);
				$this->email->attach('facturas/'.$nombre2);
		
	             if ($this->email->send()) {
	                 $datos['mensaje']="Mensaje enviado con éxito.";
	                 $this->load->view("factura/mensaje_correo",$datos);
	                 return true;
	             } else {
	                 $datos['mensaje']="Ha ocurrido un error:".show_error($this->email->print_debugger());
	                 $this->load->view("factura/mensaje_correo",$datos);
	             }
		}else{
			$datos['mensaje']="Vuelve a intentarlo.Carga el pdf y el xml.";
			$this->load->view("factura/mensaje_correo",$datos);
		}
        
        
        $this->load->view("partial/footer");





			
			//$archivo1=$this->input->get("archivo1");
			//$archivo2=$this->input->get("archivo2");


/*
			$this->email->from('francisco@syfors.com', 'Your Name');
			$this->email->to('franciscoramirezvalerio@gmail.com');
			$this->email->subject($asunto);
			$this->email->message($mensaje);
			$this->email->attach('C:/icono.png');
			//$this->email->attach('img/hue.png');
			
		

if($this->email->send())
         {
          echo 'Email send.';
         }
         else
        {
         show_error($this->email->print_debugger());
        }
		




		$this->load->library("email");

		$destinatario="franciscoramirezvalerio@gmail.com";
		//$data=$this->facturas_m->obtener_datos_empresa();
		//$remitente=$data->email;
		//$razon_social=$data->razon_social;
		echo json_encode($remitente);
		return false;
		$asunto=$this->input->get("asunto");
		$mensaje=$this->input->get("mensaje");
		$archivo1=$this->input->get("archivo1");
		$archivo2=$this->input->get("archivo2");

		$this->email->from($remitente, $razon_social);
		$this->email->to($destinatario); 
		//$this->email->cc('another@another-example.com'); 
		//$this->email->bcc('them@their-example.com');
		$this->email->attach($archivo1);
		$this->email->attach($archivo2);
		$this->email->subject($asunto);
		$this->email->message($mensaje); 
		$this->email->send();
*/

	}

	public function buscar_cliente()
	{
		$rfc=$this->input->get("rfc");	
		$data=$this->facturas_m->buscar_rfc($rfc);
		$cont=0;
		foreach ($data as $key => $value) {			
			$datos[$cont]=array("id"=>$value->rfc,"label"=>$value->rfc,"value"=>$value->rfc);
			$cont++;
		}		

# echo the json data back to the html web page
		echo json_encode($datos);

	}

	public function buscar_email()
	{
		$rfc=$this->input->get('rfc');

		$data=$this->facturas_m->buscar_email($rfc);
		echo json_encode($data->email);
	}

	public function ver_xml()
	{
		$this->load->view('partial/header');
		$this->load->view('factura/ver_xml');
		$this->load->view('partial/footer');

	}	

	public function buscar_facturas()
	{
		$rfc=$this->input->post("rfc");
		$sale_id=$this->input->post("sale_id");

		if($rfc==null && $sale_id==null){
			echo "Datos incompletos.";
			return false;
		}
			

		$data=$this->facturas_m->buscar_facturas($rfc,$sale_id);
		$datos["data"]=$data;
		echo json_encode($data);
	}

	public function cambiar_rfc_mostrador()
	{
		$rfc=$this->input->post("rfc");
		if(!$rfc){
			show_error("No existe el RFC.", 500, $heading = 'No existe RFC.');
			return false;
		}
		$data=$this->facturas_m->cambiar_rfc_mostrador($rfc);
		if($data){
			show_error("Cambio realizado correctamente.", 200, $heading = 'Cambio realizado correctamente.');
		}else{
			show_error("No existe el RFC.", 500, $heading = 'No existe RFC.');
		}
	
	}

	public function facturas_mostrador($id_factura)
	{
		
		$data=$this->facturas_m->obtener_facturas_mostrador($id_factura);
		$datos["data"]=$data;
		echo json_encode($data);

	}
	

	public function index()
	{
		$fecha='25-04-2017';
		$data=$this->facturas_m->prueba($fecha);
		var_dump($data);
		/*
		//this data will be passed on to the view
		$data['the_content']='mPDF and CodeIgniter are cool!';
		 
		//load the view, pass the variable and do not show it but "save" the output into $html variable
		$html=$this->load->view('facturas/pdf_output', $data, true); 
		 
		//this the the PDF filename that user will get to download
		$pdfFilePath = "the_pdf_output.pdf";
		 
		//load mPDF library
		$this->load->library('m_pdf');
		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		$pdf->WriteHTML($html);
		//offer it to user via browser download! (The PDF won't be saved on your server HDD)
		$pdf->Output($pdfFilePath, "D");
		*/
		echo "FIN DOCUMENTO";
	}



	public function ver_factura()
	{
		//$this->load->view('facturas/pdf_output');
	}

	public function realizar_factura($sale_id,$id_cliente)
	{
		//$id_cliente=126;
		echo '<!DOCTYPE html> <meta charset="utf-8">';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>';

		$this->load->helper('array_helper');

		
		//$data=$this->facturas_m->obtener_datos_mi_empresa();
		//var_dump($data);

		echo '<form action="http://localhost:8080/facturacion3/index.php" method="post">';
		echo '<input type="hidden" name="sale_id" value="'.$sale_id.'">
			  <input type="hidden" name="person_id" value="'.$id_cliente.'">
		 ';

		$person_id=1;
		$data["datos_empresa"]=$this->facturas_m->obtener_datos_empresa($person_id);
		$data_cliente["cliente"]=$this->facturas_m->obtener_datos_empresa($id_cliente);
		$productos["listado"]=$this->facturas_m->obtener_productos($sale_id);
		$logo=$this->facturas_m->logo();
		$url=$this->facturas_m->url();
		//var_dump($data);
		
		date_default_timezone_set('America/Monterrey');
		$fecha_emision=date('d/m/Y H:i:s');

		$file = $this->Appfile->get(1);
		header("Content-type: ".get_mime_by_extension($file->file_name));
		$logo2=$file->file_name;		
		$urllogo=$url.'/img/logo/'.$logo2;	   
		foreach ($data["datos_empresa"] as $key){

				echo '
					<input type="hidden" name="emisor_razon_social" value="'.$key->razon_social.'">
					<input type="hidden" name="emisor_rfc" value="'.$key->rfc.'">
					<input type="hidden" name="emisor_calle" value="'.$key->calle.'">
					<input type="hidden" name="emisor_num_ext" value="'.$key->num_exterior.'">
					<input type="hidden" name="emisor_num_int" value="'.$key->num_interior.'">
					<input type="hidden" name="emisor_colonia" value="'.$key->colonia.'">
					<input type="hidden" name="emisor_localidad" value="'.$key->city.'">
					<input type="hidden" name="emisor_referencia" value="">
					<input type="hidden" name="emisor_municipio" value="'.$key->delegacion.'">
					<input type="hidden" name="emisor_estado" value="'.$key->state.'">
					<input type="hidden" name="emisor_pais" value="MÉXICO">
					<input type="hidden" name="emisor_cp" value="'.$key->zip.'">
					<input type="hidden" name="emisor_regimen_fiscal" value="RÉGIMEN GENERAL DE LEY PERSONAS MORALES">
					<input type="hidden" name="lugar_expedicion" value="'.$key->delegacion.', '.$key->state.'">
					<input type="hidden" name="logo" id="logo" value="'.$urllogo.'">
				';



				$razon_social=$key->razon_social;
				$rfc=$key->rfc;
				$calle=$key->calle;
				$numero_exterior=$key->num_exterior;
				$numero_interior=$key->num_interior;
				$colonia=$key->colonia;
				$localidad=$key->localidad;
				//$referencia=$key->referencia;
				$municipio=$key->delegacion;
				$estado=$key->state;
				$pais="MÉXICO";
				$cp=$key->zip;
				$regimen_fiscal=$key->regimen_fiscal;
		
		} 

		foreach ($data_cliente["cliente"] as $cliente){
			$receptor_razon_social=$_POST['receptor_razon_social'];
			$receptor_rfc=$_POST['receptor_rfc'];
			$receptor_calle=$_POST['receptor_calle'];
			$receptor_num_ext=$_POST['receptor_num_ext'];
			$receptor_num_int=$_POST['receptor_num_int'];
			$receptor_colonia=$_POST['receptor_colonia'];
			$receptor_localidad=$_POST['receptor_localidad'];
			$receptor_referencia=$_POST['receptor_referencia'];
			$receptor_municipio=$_POST['receptor_municipio'];
			$receptor_estado=$_POST['receptor_estado'];
			$pais="MÉXICO";
			$receptor_cp=$_POST['receptor_cp'];

			echo '
				<input type="hidden" name="receptor_razon_social" value="'.$cliente->razon_social.'">
				<input type="hidden" name="receptor_rfc" value="'.$cliente->rfc.'">
				<input type="hidden" name="receptor_calle" value="'.$cliente->calle.'">
				<input type="hidden" name="receptor_num_ext" value="'.$cliente->num_exterior.'">
				<input type="hidden" name="receptor_num_int" value="'.$cliente->num_interior.'">
				<input type="hidden" name="receptor_colonia" value="'.$cliente->colonia.'">
				<input type="hidden" name="receptor_localidad" value="'.$cliente->city.'">
				<input type="hidden" name="receptor_referencia" value="">
				<input type="hidden" name="receptor_municipio" value="'.$cliente->delegacion.'">
				<input type="hidden" name="receptor_estado" value="'.$cliente->state.'">
				<input type="hidden" name="receptor_cp" value="'.$cliente->zip.'">

			';

			$nom_cliente=$cliente->first_name.' '.$cliente->last_name;
			$razon_social_cliente=$cliente->razon_social;
			$rfc_cliente=$cliente->rfc;
			$calle_cliente=$cliente->calle;
			$num_exterior_cliente=$cliente->num_exterior;
			$num_interior_cliente=$cliente->num_interior;
			$colonia_cliente=$cliente->colonia;
			$localidad_cliente=$cliente->localidad;
			$municipio_cliente=$cliente->delegacion;
			$estado_cliente=$cliente->state;
			$pais_cliente="MÉXICO";
			$cp_cliente=$cliente->zip;

			

		}



		

		echo '<style type="text/css">
	.margen-izq{
		margin-left: 50px;
	}
	.margen-der{
		margin-right: 50px;
	}
	.fuente-titulos{
		font-family: Arial,
		font-size: small;

	}
	.alinear-derecha{
		text-align: right;
	}
	.logo{
		max-width:100px;
		max-height:100px;
	}
	.centrado{
		text-align:center;
	}
	.bordes{
		
		border: inset 0pt;

	}
	.color-encabezado{
		background-color:gainsboro;
	}
	.color-productos{
		background-color:beige;
		border-style: hidden;
	}
</style>

<style>

table.auto{table-layout: auto}

th {
    padding: 1px;
    text-align: left;
}
.fuente{
	font-size: 60%;
}
</style>
</head>
<body>


<table  style="width:100%;margin-left: 15px; margin-right: 15px;font-family: Arial; font-size: 9px;">
    <tr style="width:10%">
        <td class="centrado" rowspan="6">'; 
		echo '<a href="javascript:history.back(-1);"><img id="logobd" class="logo" src="http://'.$urllogo.'"></a>';
		
		echo' 
		</td>
        <td style="width:60%">'.$razon_social.'</td>
        <td style="width:30%;text-align: right">Fecha y hora de certificación:'.$fecha_emision.'</td>        
    </tr>
    <tr>
        <td>'.$rfc.'</td>
        <td style="width:30%;text-align: right">Fecha de emisión:'.$fecha_emision.'</td>        
    </tr>
    <tr>
        <td> Calle:'.$calle.'   No:'.$numero_exterior.'   CP:'.$cp.' </td>
        <td style="width:30%;text-align: right">Serie/Folio:</td>      
    </tr>
    <tr>
    	<td>Colonia:'.$colonia.'    Localidad:'.$localidad.'</td>
        <td style="width:30%;text-align: right">No de serie del Certificado del SAT:</td>
        
    </tr>
    <tr>
    	<td> Estado:'.$estado.'    Delegación/Municipio:'.$municipio.'</td>
        <td style="width:30%;text-align: right">Núm. venta:'.$sale_id.'</td>        
    </tr>
    <tr>        
        <td>Regimen fiscal:'.$regimen_fiscal.'</td>
        <td style="width:20%;text-align: right"></td>        
    </tr>
    <tr>
    	<td colspan="3">Cliente: </td>
    </tr>
     <tr>
    	<td colspan="3">Razón Social:'.$razon_social_cliente.'  </td>
    </tr>
    <tr>
    	<td colspan="3">RFC:'.$rfc_cliente.'</td>
    </tr>
     <tr>
    	<td colspan="3">Calle:'.$calle_cliente.'    No exterior:'.$num_exterior_cliente.' No interior:'.$num_interior_cliente.'</td>
    </tr>
    <tr>
    	<td colspan="3">Colonia:'.$colonia_cliente.'    CP:'.$cp_cliente.'</td>
    </tr>
    <tr>
    	<td colspan="3">Delegación/Municipio:'.$municipio_cliente.'</td>
    </tr>
    <tr>
    	<td colspan="3">Localidad:'.$localidad_cliente.'</td>
    </tr>
    <tr>
    	<td colspan="3">Estado:'.$estado_cliente.',    '.$pais_cliente.'</td>
    </tr>
</table>

<table style="width:100%;margin-left: 15px; margin-right: 15px;font-family: Arial; font-size: 9px; padding-top:20px" id="productos">
	<thead>
		<tr class="color-encabezado">
			<td  colspan="2" >Descripción</td>
			<td>Unidad</td>
			<td>Cantidad</td>
			<td>Precio U.</td>
			<td>Importe</td>
		</tr>
	</thead>
	<tbody>'; 


			
			

			//DESCRIPCION
	//VALOR UNITARIO
	//IMPORTE
	//CANTIDAD
	//UNIDAD
	//NUMERO DE IDENTIFICACION
			


			$iva=0;
			$subtotal=0;
			$total=0;
			$contador=0;
			$subtotal=0;
			foreach($productos['listado'] as $key){
				
			$contador++;
			echo '<tr class="color-productos"><td colspan="2">';
					echo $key->name;
			echo '</td><td>';
					echo $key->unity;
			echo '</td><td>';
					echo number_format($key->quantity_purchased, 2, '.', '');
			echo '</td><td>';
					$producto_sin_impuesto=($key->unit_price)-($key->unit_price*0.16);
					$producto_sin_impuesto=number_format($producto_sin_impuesto, 2, '.','');
					echo '$'.$producto_sin_impuesto;
			echo '</td><td>';
					//echo number_format((($producto_sin_impuesto)*($key->quantity_purchased)),2,'.','');
					$importe=number_format((($producto_sin_impuesto)*($key->quantity_purchased)),2,'.','');
					echo $importe;
					//echo '$'.$key->importe;
			echo '</td></tr>';

			$subtotal=$subtotal+(($producto_sin_impuesto)*($key->quantity_purchased));
			$iva=$iva+((($key->unit_price*$key->quantity_purchased)*0.16));

			echo '<input type="hidden" name="producto'.$contador.'" value="'.$key->name.'"> 
			      <input type="hidden" name="precio_unitario'.$contador.'" value="'.$producto_sin_impuesto.'"> 
			      <input type="hidden" name="importe'.$contador.'" value="'.$importe.'">   
			      <input type="hidden" name="cantidad'.$contador.'" value="'.$key->quantity_purchased.'"> 
			      <input type="hidden" name="unidad'.$contador.'" value="'.$key->unity.'">
			      <input type="hidden" name="item_id'.$contador.'" value="'.$key->item_id.'">  ';

			//$iva=$iva+$key->iva;
			//$subtotal=$subtotal+$key->importe;
			$total=$subtotal+$iva;
			$total = number_format($total, 2, '.', '');

			

		}	

/*
		$formato_pago=$_POST['formato_pago'];
	$condiciones_pago=$_POST['condiciones_pago'];
	$subtotal=$_POST['subtotal'];
	$descuento=$_POST['descuento'];
	$motivo_descuento=$_POST['motivo_descuento'];
	$tipo_cambio=$_POST['tipo_cambio'];
	$moneda=$_POST['moneda'];
	$total=$_POST['total'];
	$tipo_comprobante=$_POST['tipo_comprobante'];
	$metodo_pago=$_POST['metodo_pago'];
	$lugar_expedicion=$_POST['localidad_emisor'].', '.$_POST['estado_emisor'];
	$numero_cuenta=$_POST['numero_cuenta'];
	$folio_fiscal_original="";
	$serie_folio_fiscal="";
	$fecha_folio_fiscal=null;
	$monto_folio_fiscal=0;

*/
		

echo '
	</tbody>
	<tfoot class="color-productos">
    	<tr>
	      <td>Condiciones de pago:
		      <select name="condiciones_pago">
		      	<option value="contado">Contado</option>
		      	<option value="crédito">Crédito</option>
		      </select>
	      </td>
	      <td>Método de pago:
	      	  <select id="metodo_pago" name="metodo_pago">
		      	<option value="01" selected>Efectivo.</option>
		      	<option value="02">Cheque nominativo.</option>
		      	<option value="03">Transferencia electrónica de fondos.</option>
		      	<option value="04">Tarjeta de crédito.</option>
		      	<option value="05">Monedero electrónico.</option>
		      	<option value="06">Dinero electrónico.</option>
		      	<option value="07">Vales de despensa.</option>
		      	<option value="08">Tarjeta de débito.</option>
		      	<option value="09">Tarjeta de Servicio.</option>
		      	<option value="10">Otros.</option>
		      	<option value="11">N/A.</option>

		      </select>
	      </td>
	      <td></td>
	      <td></td>
	      <td>Subtotal:</td>
	      <td>$'.number_format($subtotal, 2,'.','').'</td>
     	</tr>
     	<tr>
	      <td>Moneda: MXN  TC:
	      	 <select name="tipo_comprobante">
		      	<option value="ingreso">Ingreso</option>
		      	<option value="egreso">Egreso</option>
		      	<option value="traslado">Traslado</option>
		      </select>
	      </td>
	      <td>Forma de pago:
	      	  <select name="forma_pago">
		      	<option value="pago en una sola exhibición">Pago en una sola exhibición</option>
		      	<option value="pago en parcialidades">Pago en parcialidades</option>
		    
		      </select>
	      </td>
	      <td></td>
	      <td></td>
	      <td>IVA:</td>
	      <td>$'.number_format($iva,2,'.','').'</td>
     	</tr>
     	<tr>
	      <td>Núm. Cta. Pago:<input type="text" name="numero_cuenta"></td>
	      <td>
	      	Descuento:<input type="text" name="descuento" size="6"><br> Motivo del descuento:<input type="motivo_descuento" name="motivo_descuento" >
	      </td>
	      <td></td>
	      <td></td>
	      <td>Total:</td>
	      <td>$'.$total.'</td>
     	</tr>
     	<tr>
	      <td>Impuesto de traslado:<input type="text" name="tipo_impuesto_traslado" size="10"><br>
	      		Tasa Impuesto:<input type="text" name="tasa_impuesto_traslado" size="10"><br>
	      		Importe Impuesto:<input type="text" name="importe_impuesto_traslado" size="10">

	      </td>
	      <td>
	      	Impuesto tipo retención:<input type="text" name="tipo_impuesto_retencion" size="10"><br>
	      	Importe impuesto retención:<input type="text" name="importe_impuesto_retencion" size="10">
	      </td>
	      <td></td>
	      <td></td>
	      <td></td>
	      <td></td>
     	</tr>

    </tfoot>
</table>

';
	echo '<input type="hidden" name="subtotal" value="'.$subtotal.'" >
		  
		  <input type="hidden" id="factura_mostrador" name="factura_mostrador" value="">
	      <input type="hidden" name="iva" value="'.$iva.'">
	      <input type="hidden" name="total" value="'.$total.'"> ';
/*
	echo '
	<table style="width:100%;margin-left: 15px; margin-right: 15px;font-family: Arial; font-size: 9px; position:absolute;bottom:3px;">
    <tr>
       <td colspan="2">Observaciones:</td>        
    </tr>
    <tr>
        <td rowspan="3">qr</td>
        <td>Fecha de emisión:</td>
            
    </tr>
    <tr>
    	<td>3
    	</td>
    </tr>
    <tr>
    	<td>4
    	</td>
    </tr>
    
</table>
	';
*/

		

//Se le da un valor a las variables

/*
$variable1 = "Hola";

$variable2 = "como estas";

$arreglo=array();
$arreglo['nombre']='Francisco';
$arreglo['ap_paterno']='Ramirez';
$arreglo['ap_materno']='Valerio';
echo $variable1;



foreach ($arreglo as $key => $value) {
	echo $key."=>".$value;
}
*/
//echo "<a href='http://facturacion.hopto.org:8080/facturacion/index.php?variable1=$variable1?arreglo=$arreglo' >Enlace</a>";

echo '<button type="submit" value="ENviar">Timbrar facturar.</button><input type="button" name="imprimir" value="Imprimir" onclick="window.print();">
		</form>';

echo '
<script>
	$(function(){
		$("#metodo_pago1").on("change",function(){
			var valor= $("#metodo_pago1 option:selected").val();
			var texto = $("#metodo_pago1 option:selected").html();
			$("#metodo_pago").val(valor+"-"+texto);
		});
	});
</script>';


	}

	
	public function guardar_factura()
	{


  		$fecha_venta=$this->input->get("fecha_venta");
		$sale_id=$this->input->get("sale_id");
		$person_id=$this->input->get("person_id");
		$factura_mostrador=$this->input->get("factura_mostrador");
		$total_factura_mostrador=$this->input->get("total_factura_mostrador");
		$cadena_original=$this->input->get("cadena_original");
		$sello_digital_cfd=$this->input->get("sello_digital_cfd");
		$sello_sat=$this->input->get("sello_sat");
		$sello_cfd=$this->input->get("sello_cfd");
		$uuid=$this->input->get("uuid");
		$num_certificado_sat=$this->input->get("num_certificado_sat");
		$num_certificado_emisor=$this->input->get("num_certificado_emisor");
		$fecha_timbrado=$this->input->get("fecha_timbrado");

		$condiciones_pago=$this->input->get("condiciones_pago");
		$metodo_pago=$this->input->get("metodo_pago");
		$tc=$this->input->get("tc");
		$forma_pago=$this->input->get("forma_pago");
		$numero_cuenta=$this->input->get("numero_cuenta");
		$descuento=$this->input->get("descuento");
		$motivo_descuento=$this->input->get("motivo_descuento");
		$tipo_impuesto_traslado=$this->input->get("tipo_impuesto_traslado");
		$tasa_impuesto_traslado=$this->input->get("tasa_impuesto_traslado");
		$importe_impuesto_traslado=$this->input->get("importe_impuesto_traslado");
		$tipo_impuesto_retencion=$this->input->get("tipo_impuesto_retencion");
		$importe_impuesto_retencion=$this->input->get("importe_impuesto_retencion");


		if($factura_mostrador)
			$sale_id=NULL;
		
		
		$factura=$this->facturas_m->guardar_factura($fecha_venta,$sale_id,$person_id,$factura_mostrador,$total_factura_mostrador, $condiciones_pago,$metodo_pago,$tc,$forma_pago,$numero_cuenta,$descuento,$motivo_descuento,$tipo_impuesto_traslado,$tasa_impuesto_traslado,$importe_impuesto_traslado,$tipo_impuesto_retencion,$importe_impuesto_retencion,  $cadena_original,$sello_digital_cfd,$sello_sat,$sello_cfd,$uuid,$num_certificado_sat,$num_certificado_emisor,$fecha_timbrado);

		echo "FActura:".$factura;
		
	}

	public function factura_diaria()
	{
		$data["datos"]=$this->facturas_m->obtener_datos_empresa();
		//var_dump($data);
		$this->load->view('partial/header');
		$this->load->view('factura/factura_mostrador',$data);
		$this->load->view('partial/footer');
	}

	public function facturar_venta()
	{
		$data["datos"]=$this->facturas_m->obtener_datos_empresa();
		//var_dump($data);
		$this->load->view('partial/header');
		$this->load->view('factura/facturar_venta',$data);
		$this->load->view('partial/footer');
	}

	public function buscar_ventas_sin_factura()
	{
		$sale_id=$this->input->get('sale_id');
		$data=$this->facturas_m->buscar_venta($sale_id);

		$datos["data"]=$data;
		echo json_encode($data);


		
	}

	public function facturar_ventas_mostrador()
	{
		$this->load->helper('date');
		/*
		$fecha=$this->input->get("fecha");
		$fecha = date("Y-m-d", strtotime($fecha));
		echo $fecha;
		*/
		$datestring = '%Y-%m-%d';
		$fechaingresada=strtotime($this->input->get("fecha"));

		
		$fecha= mdate($datestring, $fechaingresada);
		$result=$this->facturas_m->total_venta_mostrador($fecha);
		if($result->total==0 || $result->total=="" || $result->total==null){

			$result=0;
			echo $result;
			return false;
		}
		echo $result->total;
	}
	
	public function reimprimir_factura($sale_id,$id_cliente)
	{

		$person_id=1;
		$data["datos_empresa"]=$this->facturas_m->obtener_datos_empresa($person_id);
		$data_cliente["cliente"]=$this->facturas_m->obtener_datos_empresa($id_cliente);
		$productos["listado"]=$this->facturas_m->obtener_productos($sale_id);
		$factura["listado"]=$this->facturas_m->obtener_factura($sale_id);
		$logo=$this->facturas_m->logo();
		$url=$this->facturas_m->url();
		//var_dump($factura["listado"]);
		
		date_default_timezone_set('America/Monterrey');
		$fecha_emision=date('d/m/Y H:i:s');

		
		//$id_cliente=126;
		echo '<!DOCTYPE html> <meta charset="utf-8">
			<style>
			.celda{
				width: 80%;
				float: left;
				white-space: pre; /* CSS 2.0 */
				white-space: pre-wrap; /* CSS 2.1 */
				white-space: pre-line; /* CSS 3.0 */
				white-space: -pre-wrap; /* Opera 4-6 */
				white-space: -o-pre-wrap; /* Opera 7 */
				white-space: -moz-pre-wrap; /* Mozilla */
				white-space: -hp-pre-wrap; /* HP */
				word-wrap: break-word; /* IE 5+ */
			}
			.ancho{
				width: 100%;
			}
			.logo{
				max-width:100px;
				max-height:100px;
			}
			.fuente{
				font-size: 8px;
				font-family: Arial;
			}
			</style>

		';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>';

		$this->load->helper('array_helper');

		
		//$data=$this->facturas_m->obtener_datos_mi_empresa();
		//var_dump($data);

		//echo '<form action="http://facturacion.hopto.org:8080/facturacion/" method="post">';
		echo '<input type="hidden" name="sale_id" value="'.$sale_id.'">
			  <input type="hidden" name="person_id" value="'.$id_cliente.'">
		 ';


		$file = $this->Appfile->get(1);
		header("Content-type: ".get_mime_by_extension($file->file_name));
		$logo2=$file->file_name;		
		$urllogo=$url.'/img/logo/'.$logo2;	   
		foreach ($data["datos_empresa"] as $key){

				echo '
					<input type="hidden" name="emisor_razon_social" value="'.$key->razon_social.'">
					<input type="hidden" name="emisor_rfc" value="'.$key->rfc.'">
					<input type="hidden" name="emisor_calle" value="'.$key->calle.'">
					<input type="hidden" name="emisor_num_ext" value="'.$key->num_exterior.'">
					<input type="hidden" name="emisor_num_int" value="'.$key->num_interior.'">
					<input type="hidden" name="emisor_colonia" value="'.$key->colonia.'">
					<input type="hidden" name="emisor_localidad" value="'.$key->city.'">
					<input type="hidden" name="emisor_referencia" value="">
					<input type="hidden" name="emisor_municipio" value="'.$key->delegacion.'">
					<input type="hidden" name="emisor_estado" value="'.$key->state.'">
					<input type="hidden" name="emisor_pais" value="MÉXICO">
					<input type="hidden" name="emisor_cp" value="'.$key->zip.'">
					<input type="hidden" name="emisor_regimen_fiscal" value="RÉGIMEN GENERAL DE LEY PERSONAS MORALES">
					<input type="hidden" name="lugar_expedicion" value="'.$key->delegacion.', '.$key->state.'">
					<input type="hidden" name="logo" id="logo" value="'.$urllogo.'">
				';



				$razon_social=$key->razon_social;
				$rfc=$key->rfc;
				$calle=$key->calle;
				$numero_exterior=$key->num_exterior;
				$numero_interior=$key->num_interior;
				$colonia=$key->colonia;
				$localidad=$key->localidad;
				//$referencia=$key->referencia;
				$municipio=$key->delegacion;
				$estado=$key->state;
				$pais="MÉXICO";
				$cp=$key->zip;
				$regimen_fiscal=$key->regimen_fiscal;
		
		} 

		foreach ($data_cliente["cliente"] as $cliente){
			$receptor_razon_social=$_POST['receptor_razon_social'];
			$receptor_rfc=$_POST['receptor_rfc'];
			$receptor_calle=$_POST['receptor_calle'];
			$receptor_num_ext=$_POST['receptor_num_ext'];
			$receptor_num_int=$_POST['receptor_num_int'];
			$receptor_colonia=$_POST['receptor_colonia'];
			$receptor_localidad=$_POST['receptor_localidad'];
			$receptor_referencia=$_POST['receptor_referencia'];
			$receptor_municipio=$_POST['receptor_municipio'];
			$receptor_estado=$_POST['receptor_estado'];
			$pais="MÉXICO";
			$receptor_cp=$_POST['receptor_cp'];

			echo '
				<input type="hidden" name="receptor_razon_social" value="'.$cliente->razon_social.'">
				<input type="hidden" name="receptor_rfc" value="'.$cliente->rfc.'">
				<input type="hidden" name="receptor_calle" value="'.$cliente->calle.'">
				<input type="hidden" name="receptor_num_ext" value="'.$cliente->num_exterior.'">
				<input type="hidden" name="receptor_num_int" value="'.$cliente->num_interior.'">
				<input type="hidden" name="receptor_colonia" value="'.$cliente->colonia.'">
				<input type="hidden" name="receptor_localidad" value="'.$cliente->city.'">
				<input type="hidden" name="receptor_referencia" value="">
				<input type="hidden" name="receptor_municipio" value="'.$cliente->delegacion.'">
				<input type="hidden" name="receptor_estado" value="'.$cliente->state.'">
				<input type="hidden" name="receptor_cp" value="'.$cliente->zip.'">

			';

			$nom_cliente=$cliente->first_name.' '.$cliente->last_name;
			$razon_social_cliente=$cliente->razon_social;
			$rfc_cliente=$cliente->rfc;
			$calle_cliente=$cliente->calle;
			$num_exterior_cliente=$cliente->num_exterior;
			$num_interior_cliente=$cliente->num_interior;
			$colonia_cliente=$cliente->colonia;
			$localidad_cliente=$cliente->localidad;
			$municipio_cliente=$cliente->delegacion;
			$estado_cliente=$cliente->state;
			$pais_cliente="MÉXICO";
			$cp_cliente=$cliente->zip;

			

		}

		foreach($factura["listado"] as $facturas){
			$condiciones_pago=$facturas->condiciones_pago;
			$metodo_pago=$facturas->metodo_pago;
			$tc=$facturas->tc;
			$forma_pago=$facturas->forma_pago;
			$numero_cuenta=$facturas->numero_cuenta;
			$descuento=$facturas->descuento;
			$motivo_descuento=$facturas->motivo_descuento;
			$tipo_impuesto_traslado=$facturas->tipo_impuesto_traslado;
			$tasa_impuesto_traslado=$facturas->tasa_impuesto_traslado;
			$importe_impuesto_traslado=$facturas->importe_impuesto_traslado;
			$tipo_impuesto_retencion=$facturas->tipo_impuesto_retencion;
			$importe_impuesto_retencion=$facturas->importe_impuesto_retencion;
			$cadena_original=$facturas->cadena_original;
			$sello_digital_cfd=$facturas->sello_digital_cfd;
			$sello_sat=$facturas->sello_sat;
			$sello_cfd=$facturas->sello_cfd;
			$uuid=$facturas->uuid;
			$num_certificado_sat=$facturas->num_certificado_sat;
			$num_certificado_emisor=$facturas->num_certificado_emisor;
			$fecha_timbrado=$facturas->fecha_timbrado;

		}



	//$metodo_pago=$data_cliente->metodo_pago;		
	if($metodo_pago=="01")
	{
		$metodo_pago_letra="Efectivo";
	}
	if($metodo_pago=="02")
	{
		$metodo_pago_letra="Cheque nominativo";
	}
	if($metodo_pago=="03")
	{
		$metodo_pago_letra="Transferencia electrónica de fondos";
	}
	if($metodo_pago=="04")
	{
		$metodo_pago_letra="Tarjeta de crédito";
	}
	if($metodo_pago=="05")
	{
		$metodo_pago_letra="Monedero electrónico";
	}
	if($metodo_pago=="06")
	{
		$metodo_pago_letra="Dinero electrónico";
	}
	if($metodo_pago=="07")
	{
		$metodo_pago_letra="Vales de despensa";
	}
	if($metodo_pago=="08")
	{
		$metodo_pago_letra="Tarjeta de débito";
	}
	if($metodo_pago=="09")
	{
		$metodo_pago_letra="Tarjeta de Servicio";
	}
	if($metodo_pago=="10")
	{
		$metodo_pago_letra="Otros";
	}
	if($metodo_pago=="11")
	{
		$metodo_pago_letra="N/A";
	}



		

		echo '<style type="text/css">
	.margen-izq{
		margin-left: 50px;
	}
	.margen-der{
		margin-right: 50px;
	}
	.fuente-titulos{
		font-family: Arial,
		font-size: small;

	}
	.alinear-derecha{
		text-align: right;
	}
	.logo{
		max-width:100px;
		max-height:100px;
	}
	.centrado{
		text-align:center;
	}
	.bordes{
		
		border: inset 0pt;

	}
	.color-encabezado{
		background-color:gainsboro;
	}
	.color-productos{
		background-color:beige;
		border-style: hidden;
	}
</style>

<style>

table.auto{table-layout: auto}

th {
    padding: 1px;
    text-align: left;
}
.fuente{
	font-size: 60%;
}
</style>
</head>
<body>


<table  style="width:100%;margin-left: 15px; margin-right: 15px;font-family: Arial; font-size: 9px;">
    <tr style="width:10%">
        <td class="centrado" rowspan="6">'; 
		echo '<a href="javascript:history.back(-1);"><img id="logobd" class="logo" src="http://'.$urllogo.'"></a>';
		
		echo' 
		</td>
        <td style="width:60%">'.$razon_social.'</td>
        <td style="width:30%;text-align: right">Fecha y hora de certificación:'.$fecha_emision.'</td>        
    </tr>
    <tr>
        <td>'.$rfc.'</td>
        <td style="width:30%;text-align: right">Fecha de emisión:'.$fecha_emision.'</td>        
    </tr>
    <tr>
        <td> Calle:'.$calle.'   No:'.$numero_exterior.'   CP:'.$cp.' </td>
        <td style="width:30%;text-align: right">No de serie del Certificado del SAT:'.$num_certificado_sat.'</td>      
    </tr>
    <tr>
    	<td>Colonia:'.$colonia.'    Localidad:'.$localidad.'</td>
        <td style="width:30%;text-align: right">No de serie del Certificado emisor:'.$num_certificado_emisor.'</td>
        
    </tr>
    <tr>
    	<td> Estado:'.$estado.'    Delegación/Municipio:'.$municipio.'</td>
        <td style="width:30%;text-align: right">Núm. venta:'.$sale_id.'</td>        
    </tr>
    <tr>        
        <td>Regimen fiscal:'.$regimen_fiscal.'</td>
        <td style="width:20%;text-align: right"></td>        
    </tr>
    <tr>
    	<td colspan="3">Cliente: </td>
    </tr>
     <tr>
    	<td colspan="3">Razón Social:'.$razon_social_cliente.'  </td>
    </tr>
    <tr>
    	<td colspan="3">RFC:'.$rfc_cliente.'</td>
    </tr>
     <tr>
    	<td colspan="3">Calle:'.$calle_cliente.'    No exterior:'.$num_exterior_cliente.' No interior:'.$num_interior_cliente.'</td>
    </tr>
    <tr>
    	<td colspan="3">Colonia:'.$colonia_cliente.'    CP:'.$cp_cliente.'</td>
    </tr>
    <tr>
    	<td colspan="3">Delegación/Municipio:'.$municipio_cliente.'</td>
    </tr>
    <tr>
    	<td colspan="3">Localidad:'.$localidad_cliente.'</td>
    </tr>
    <tr>
    	<td colspan="3">Estado:'.$estado_cliente.',    '.$pais_cliente.'</td>
    </tr>
</table>

<table style="width:100%;margin-left: 15px; margin-right: 15px;font-family: Arial; font-size: 9px; padding-top:20px" id="productos">
	<thead>
		<tr class="color-encabezado">
			<td  colspan="2" >Descripción</td>
			<td>Unidad</td>
			<td>Cantidad</td>
			<td>Precio U.</td>
			<td>Importe</td>
		</tr>
	</thead>
	<tbody>'; 


			
			

			//DESCRIPCION
	//VALOR UNITARIO
	//IMPORTE
	//CANTIDAD
	//UNIDAD
	//NUMERO DE IDENTIFICACION
			


			$iva=0;
			$subtotal=0;
			$total=0;
			$contador=0;
			$subtotal=0;
			foreach($productos['listado'] as $key){
				
			$contador++;
			echo '<tr class="color-productos"><td colspan="2">';
					echo $key->name;
			echo '</td><td>';
					echo $key->unity;
			echo '</td><td>';
					echo number_format($key->quantity_purchased, 2, '.', '');
			echo '</td><td>';
					$producto_sin_impuesto=($key->unit_price)-($key->unit_price*0.16);
					$producto_sin_impuesto=number_format($producto_sin_impuesto, 2, '.','');
					echo '$'.$producto_sin_impuesto;
			echo '</td><td>';
					//echo number_format((($producto_sin_impuesto)*($key->quantity_purchased)),2,'.','');
					$importe=number_format((($producto_sin_impuesto)*($key->quantity_purchased)),2,'.','');
					echo $importe;
					//echo '$'.$key->importe;
			echo '</td></tr>';

			$subtotal=$subtotal+(($producto_sin_impuesto)*($key->quantity_purchased));
			$iva=$iva+((($key->unit_price*$key->quantity_purchased)*0.16));

			echo '<input type="hidden" name="producto'.$contador.'" value="'.$key->name.'"> 
			      <input type="hidden" name="precio_unitario'.$contador.'" value="'.$producto_sin_impuesto.'"> 
			      <input type="hidden" name="importe'.$contador.'" value="'.$importe.'">   
			      <input type="hidden" name="cantidad'.$contador.'" value="'.$key->quantity_purchased.'"> 
			      <input type="hidden" name="unidad'.$contador.'" value="'.$key->unity.'">
			      <input type="hidden" name="item_id'.$contador.'" value="'.$key->item_id.'">  ';

			//$iva=$iva+$key->iva;
			//$subtotal=$subtotal+$key->importe;
			$total=$subtotal+$iva;
			$total = number_format($total, 2, '.', '');

			

		}	

/*
		$formato_pago=$_POST['formato_pago'];
	$condiciones_pago=$_POST['condiciones_pago'];
	$subtotal=$_POST['subtotal'];
	$descuento=$_POST['descuento'];
	$motivo_descuento=$_POST['motivo_descuento'];
	$tipo_cambio=$_POST['tipo_cambio'];
	$moneda=$_POST['moneda'];
	$total=$_POST['total'];
	$tipo_comprobante=$_POST['tipo_comprobante'];
	$metodo_pago=$_POST['metodo_pago'];
	$lugar_expedicion=$_POST['localidad_emisor'].', '.$_POST['estado_emisor'];
	$numero_cuenta=$_POST['numero_cuenta'];
	$folio_fiscal_original="";
	$serie_folio_fiscal="";
	$fecha_folio_fiscal=null;
	$monto_folio_fiscal=0;

*/
		

echo '
	</tbody>
	<tfoot class="color-productos">
    	<tr>
	      <td>Condiciones de pago: '.$condiciones_pago.'
		     
	      </td>
	      <td>Método de pago: '.$metodo_pago.'-'.$metodo_pago_letra.'
	      	  
	      </td>
	      <td></td>
	      <td></td>
	      <td>Subtotal:</td>
	      <td>$'.number_format($subtotal, 2,'.','').'</td>
     	</tr>
     	<tr>
	      <td>Moneda: MXN  TC: '.$tc.'
	      	 
	      </td>
	      <td>Forma de pago: '.$forma_pago.'
	      	  
	      </td>
	      <td></td>
	      <td></td>
	      <td>IVA:</td>
	      <td>$'.number_format($iva,2,'.','').'</td>
     	</tr>
     	<tr>
	      <td>Núm. Cta. Pago: '.$numero_cuenta.'</td>
	      <td>
	      	Descuento: '.$descuento.'<br> Motivo del descuento: '.$motivo_descuento.'
	      </td>
	      <td></td>
	      <td></td>
	      <td>Total:</td>
	      <td>$'.$total.'</td>
     	</tr>
     	<tr>
	      <td>Impuesto de traslado: '.$tipo_impuesto_traslado.'<br>
	      		Tasa Impuesto: '.$tasa_impuesto_traslado.'<br>
	      		Importe Impuesto: '.$importe_impuesto_traslado.'

	      </td>
	      <td>
	      	Impuesto tipo retención: '.$tipo_impuesto_retencion.'<br>
	      	Importe impuesto retención: '.$importe_impuesto_retencion.'
	      </td>
	      <td></td>
	      <td></td>
	      <td></td>
	      <td></td>
     	</tr>

    </tfoot>
</table>

';
	echo '<input type="hidden" name="subtotal" value="'.$subtotal.'" >
		  <input type="hidden" id="metodo_pago" name="metodo_pago" value="">
	      <input type="hidden" name="iva" value="'.$iva.'">
	      <input type="hidden" name="total" value="'.$total.'"> ';

//echo '<button type="submit" value="Eviar">Timbrar facturar.</button></form>';

echo '
<script>
	$(function(){
		$("#metodo_pago1").on("change",function(){
			var valor= $("#metodo_pago1 option:selected").val();
			var texto = $("#metodo_pago1 option:selected").html();
			$("#metodo_pago").val(valor+"-"+texto);
		});
	});
</script>';



echo '
<div style="bottom: 10px ; position: absolute;" class="celda ancho">
<label class="fuente" >Sello digital del CFDI:'.$sello_digital_cfd.'</label>
<br>
<label class="fuente" >Sello digital del SAT:<br>'.$sello_sat.'</label>
<br>
<label class="fuente" >Cadena original del complemento de certificación digital del SAT:'.$cadena_original.'</label>
</div>



';

	}



	public function realizar_factura_mostrador()
	{
	    
		$this->load->helper('date');
		//$id_cliente=126;
		echo '<!DOCTYPE html> <meta charset="utf-8">';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>';

		$this->load->helper('array_helper');
		$importe_total=$this->input->get("importe");
		$fecha_venta=$this->input->get("fecha_venta");
		$fecha_venta=date($fecha_venta);
	
	
		$date=date_create($fecha_venta);
		$fecha1=date_format($date,"Y-m-d H:i:s");

		$fecha_venta2=date_create($fecha_venta.' 23:59:59');	
		$fecha2=date_format($fecha_venta2,"Y-m-d H:i:s");
		
		$person_id=1;
		$data["datos_empresa"]=$this->facturas_m->obtener_datos_empresa($person_id);
		$data_cliente["cliente"]=$this->facturas_m->obtener_datos_empresa();
		$productos["listado"]=$this->facturas_m->obtener_productos($sale_id);
		$logo=$this->facturas_m->logo();
		$url=$this->facturas_m->url();

		foreach($data_cliente["cliente"] as $key){
			$id_cliente=$key->person_id;
			
		}

		echo '<form action="http://facturacion.hopto.org:8080/facturacion/" method="post">';
		echo '<input type="hidden" name="sale_id" value="'.$sale_id.'">
			  <input type="hidden" name="person_id" value="'.$id_cliente.'">
			  <input type="hidden" name="fecha_venta" value="'.$fecha_venta.'">
			 
		 ';

		
		//var_dump($data);
		
		date_default_timezone_set('America/Monterrey');
		$fecha_emision=date('d/m/Y H:i:s');

		$file = $this->Appfile->get(1);
		header("Content-type: ".get_mime_by_extension($file->file_name));
		$logo2=$file->file_name;		
		$urllogo=$url.'/img/logo/'.$logo2;	   
		foreach ($data["datos_empresa"] as $key){

				echo '
					<input type="hidden" name="emisor_razon_social" value="'.$key->razon_social.'">
					<input type="hidden" name="emisor_rfc" value="'.$key->rfc.'">
					<input type="hidden" name="emisor_calle" value="'.$key->calle.'">
					<input type="hidden" name="emisor_num_ext" value="'.$key->num_exterior.'">
					<input type="hidden" name="emisor_num_int" value="'.$key->num_interior.'">
					<input type="hidden" name="emisor_colonia" value="'.$key->colonia.'">
					<input type="hidden" name="emisor_localidad" value="'.$key->city.'">
					<input type="hidden" name="emisor_referencia" value="">
					<input type="hidden" name="emisor_municipio" value="'.$key->delegacion.'">
					<input type="hidden" name="emisor_estado" value="'.$key->state.'">
					<input type="hidden" name="emisor_pais" value="MÉXICO">
					<input type="hidden" name="emisor_cp" value="'.$key->zip.'">
					<input type="hidden" name="emisor_regimen_fiscal" value="RÉGIMEN GENERAL DE LEY PERSONAS MORALES">
					<input type="hidden" name="lugar_expedicion" value="'.$key->delegacion.', '.$key->state.'">
					<input type="hidden" name="logo" id="logo" value="'.$urllogo.'">
				';



				$razon_social=$key->razon_social;
				$rfc=$key->rfc;
				$calle=$key->calle;
				$numero_exterior=$key->num_exterior;
				$numero_interior=$key->num_interior;
				$colonia=$key->colonia;
				$localidad=$key->localidad;
				//$referencia=$key->referencia;
				$municipio=$key->delegacion;
				$estado=$key->state;
				$pais="MÉXICO";
				$cp=$key->zip;
				$regimen_fiscal=$key->regimen_fiscal;
		
		} 

		foreach ($data_cliente["cliente"] as $cliente){
			$receptor_razon_social=$_POST['receptor_razon_social'];
			$receptor_rfc=$_POST['receptor_rfc'];
			$receptor_calle=$_POST['receptor_calle'];
			$receptor_num_ext=$_POST['receptor_num_ext'];
			$receptor_num_int=$_POST['receptor_num_int'];
			$receptor_colonia=$_POST['receptor_colonia'];
			$receptor_localidad=$_POST['receptor_localidad'];
			$receptor_referencia=$_POST['receptor_referencia'];
			$receptor_municipio=$_POST['receptor_municipio'];
			$receptor_estado=$_POST['receptor_estado'];
			$pais="MÉXICO";
			$receptor_cp=$_POST['receptor_cp'];

			echo '
				<input type="hidden" name="receptor_razon_social" value="'.$cliente->razon_social.'">
				<input type="hidden" name="receptor_rfc" value="'.$cliente->rfc.'">
				<input type="hidden" name="receptor_calle" value="'.$cliente->calle.'">
				<input type="hidden" name="receptor_num_ext" value="'.$cliente->num_exterior.'">
				<input type="hidden" name="receptor_num_int" value="'.$cliente->num_interior.'">
				<input type="hidden" name="receptor_colonia" value="'.$cliente->colonia.'">
				<input type="hidden" name="receptor_localidad" value="'.$cliente->city.'">
				<input type="hidden" name="receptor_referencia" value="">
				<input type="hidden" name="receptor_municipio" value="'.$cliente->delegacion.'">
				<input type="hidden" name="receptor_estado" value="'.$cliente->state.'">
				<input type="hidden" name="receptor_cp" value="'.$cliente->zip.'">

			';

			$nom_cliente=$cliente->first_name.' '.$cliente->last_name;
			$razon_social_cliente=$cliente->razon_social;
			$rfc_cliente=$cliente->rfc;
			$calle_cliente=$cliente->calle;
			$num_exterior_cliente=$cliente->num_exterior;
			$num_interior_cliente=$cliente->num_interior;
			$colonia_cliente=$cliente->colonia;
			$localidad_cliente=$cliente->localidad;
			$municipio_cliente=$cliente->delegacion;
			$estado_cliente=$cliente->state;
			$pais_cliente="MÉXICO";
			$cp_cliente=$cliente->zip;

			

		}



		

		echo '<style type="text/css">
	.margen-izq{
		margin-left: 50px;
	}
	.margen-der{
		margin-right: 50px;
	}
	.fuente-titulos{
		font-family: Arial,
		font-size: small;

	}
	.alinear-derecha{
		text-align: right;
	}
	.logo{
		max-width:100px;
		max-height:100px;
	}
	.centrado{
		text-align:center;
	}
	.bordes{
		
		border: inset 0pt;

	}
	.color-encabezado{
		background-color:gainsboro;
	}
	.color-productos{
		background-color:beige;
		border-style: hidden;
	}
</style>

<style>

table.auto{table-layout: auto}

th {
    padding: 1px;
    text-align: left;
}
.fuente{
	font-size: 60%;
}
</style>
</head>
<body>


<table  style="width:100%;margin-left: 15px; margin-right: 15px;font-family: Arial; font-size: 9px;">
    <tr style="width:10%">
        <td class="centrado" rowspan="6">'; 
		echo '<a href="javascript:history.back(-1);"><img id="logobd" class="logo" src="http://'.$urllogo.'"></a>';
		
		echo' 
		</td>
        <td style="width:60%">'.$razon_social.'</td>
        <td style="width:30%;text-align: right">Fecha y hora de certificación:'.$fecha_emision.'</td>        
    </tr>
    <tr>
        <td>'.$rfc.'</td>
        <td style="width:30%;text-align: right">Fecha de emisión:'.$fecha_emision.'</td>        
    </tr>
    <tr>
        <td> Calle:'.$calle.'   No:'.$numero_exterior.'   CP:'.$cp.' </td>
        <td style="width:30%;text-align: right">Serie/Folio:</td>      
    </tr>
    <tr>
    	<td>Colonia:'.$colonia.'    Localidad:'.$localidad.'</td>
        <td style="width:30%;text-align: right">No de serie del Certificado del SAT:</td>
        
    </tr>
    <tr>
    	<td> Estado:'.$estado.'    Delegación/Municipio:'.$municipio.'</td>
        <td style="width:30%;text-align: right">Núm. venta:'.$sale_id.'</td>        
    </tr>
    <tr>        
        <td>Regimen fiscal:'.$regimen_fiscal.'</td>
        <td style="width:20%;text-align: right"></td>        
    </tr>
    <tr>
    	<td colspan="3">Cliente: </td>
    </tr>
     <tr>
    	<td colspan="3">Razón Social:'.$razon_social_cliente.'  </td>
    </tr>
    <tr>
    	<td colspan="3">RFC:'.$rfc_cliente.'</td>
    </tr>
     <tr>
    	<td colspan="3">Calle:'.$calle_cliente.'    No exterior:'.$num_exterior_cliente.' No interior:'.$num_interior_cliente.'</td>
    </tr>
    <tr>
    	<td colspan="3">Colonia:'.$colonia_cliente.'    CP:'.$cp_cliente.'</td>
    </tr>
    <tr>
    	<td colspan="3">Delegación/Municipio:'.$municipio_cliente.'</td>
    </tr>
    <tr>
    	<td colspan="3">Localidad:'.$localidad_cliente.'</td>
    </tr>
    <tr>
    	<td colspan="3">Estado:'.$estado_cliente.',    '.$pais_cliente.'</td>
    </tr>
</table>

<table style="width:100%;margin-left: 15px; margin-right: 15px;font-family: Arial; font-size: 9px; padding-top:20px" id="productos">
	<thead>
		<tr class="color-encabezado">
			<td  colspan="2" >Descripción</td>
			<td>Unidad</td>
			<td>Cantidad</td>
			<td>Precio U.</td>
			<td>Importe</td>
		</tr>
	</thead>
	<tbody>'; 


			
			

			//DESCRIPCION
	//VALOR UNITARIO
	//IMPORTE
	//CANTIDAD
	//UNIDAD
	//NUMERO DE IDENTIFICACION
			


			$iva=0;
			$subtotal=0;
			$total=0;
			$contador=0;
			$subtotal=0;
			
				
			$contador++;
			echo '<tr class="color-productos"><td colspan="2">';
					echo 'Venta al mostrador';
			echo '</td><td>';
					echo 'N/A';
			echo '</td><td>';
					echo '1.0';
			echo '</td><td>';
					$producto_sin_impuesto=($importe_total)-($importe_total*0.16);
					$producto_sin_impuesto=number_format($producto_sin_impuesto, 2, '.','');
					echo '$'.$producto_sin_impuesto;
			echo '</td><td>';
					//echo number_format((($producto_sin_impuesto)*($key->quantity_purchased)),2,'.','');
					echo '$'.$producto_sin_impuesto;
					//echo '$'.$key->importe;
			echo '</td></tr>';

			$subtotal=$subtotal+(($producto_sin_impuesto)*($key->quantity_purchased));
			$iva=$iva+((($importe_total)*0.16));

			echo '<input type="hidden" name="producto1" value="Venta al mostrador"> 
			      <input type="hidden" name="precio_unitario1" value="'.$producto_sin_impuesto.'"> 
			      <input type="hidden" name="importe1" value="'.$producto_sin_impuesto.'">   
			      <input type="hidden" name="cantidad1" value="1"> 
			      <input type="hidden" name="unidad1" value="N/A">
			      <input type="hidden" name="item_id1" value="">  ';

			//$iva=$iva+$key->iva;
			//$subtotal=$subtotal+$key->importe;
			$total=$producto_sin_impuesto+$iva;
			$total = number_format($total, 2, '.', '');

			

		

/*
		$formato_pago=$_POST['formato_pago'];
	$condiciones_pago=$_POST['condiciones_pago'];
	$subtotal=$_POST['subtotal'];
	$descuento=$_POST['descuento'];
	$motivo_descuento=$_POST['motivo_descuento'];
	$tipo_cambio=$_POST['tipo_cambio'];
	$moneda=$_POST['moneda'];
	$total=$_POST['total'];
	$tipo_comprobante=$_POST['tipo_comprobante'];
	$metodo_pago=$_POST['metodo_pago'];
	$lugar_expedicion=$_POST['localidad_emisor'].', '.$_POST['estado_emisor'];
	$numero_cuenta=$_POST['numero_cuenta'];
	$folio_fiscal_original="";
	$serie_folio_fiscal="";
	$fecha_folio_fiscal=null;
	$monto_folio_fiscal=0;

*/
		

echo '
	</tbody>
	<tfoot class="color-productos">
    	<tr>
	      <td>Condiciones de pago:
		      <select name="condiciones_pago">
		      	<option value="contado">Contado</option>
		      	<option value="crédito">Crédito</option>
		      </select>
	      </td>
	      <td>Método de pago:
	      	  <select id="metodo_pago" name="metodo_pago">
		      	<option value="01" selected>Efectivo.</option>
		      	<option value="02">Cheque nominativo.</option>
		      	<option value="03">Transferencia electrónica de fondos.</option>
		      	<option value="04">Tarjeta de crédito.</option>
		      	<option value="05">Monedero electrónico.</option>
		      	<option value="06">Dinero electrónico.</option>
		      	<option value="07">Vales de despensa.</option>
		      	<option value="08">Tarjeta de débito.</option>
		      	<option value="09">Tarjeta de Servicio.</option>
		      	<option value="10">Otros.</option>
		      	<option value="11">N/A.</option>

		      </select>
	      </td>
	      <td></td>
	      <td></td>
	      <td>Subtotal:</td>
	      <td>$'.number_format($producto_sin_impuesto, 2,'.','').'</td>
     	</tr>
     	<tr>
	      <td>Moneda: MXN  TC:
	      	 <select name="tipo_comprobante">
		      	<option value="ingreso">Ingreso</option>
		      	<option value="egreso">Egreso</option>
		      	<option value="traslado">Traslado</option>
		      </select>
	      </td>
	      <td>Forma de pago:
	      	  <select name="forma_pago">
		      	<option value="pago en una sola exhibición">Pago en una sola exhibición</option>
		      	<option value="pago en parcialidades">Pago en parcialidades</option>
		    
		      </select>
	      </td>
	      <td></td>
	      <td></td>
	      <td>IVA:</td>
	      <td>$'.number_format($iva,2,'.','').'</td>
     	</tr>
     	<tr>
	      <td>Núm. Cta. Pago:<input type="text" name="numero_cuenta"></td>
	      <td>
	      	Descuento:<input type="text" name="descuento" size="6"><br> Motivo del descuento:<input type="motivo_descuento" name="motivo_descuento" >
	      </td>
	      <td></td>
	      <td></td>
	      <td>Total:</td>
	      <td>$'.$total.'</td>
     	</tr>
     	<tr>
	      <td>Impuesto de traslado:<input type="text" name="tipo_impuesto_traslado" size="10"><br>
	      		Tasa Impuesto:<input type="text" name="tasa_impuesto_traslado" size="10"><br>
	      		Importe Impuesto:<input type="text" name="importe_impuesto_traslado" size="10">

	      </td>
	      <td>
	      	Impuesto tipo retención:<input type="text" name="tipo_impuesto_retencion" size="10"><br>
	      	Importe impuesto retención:<input type="text" name="importe_impuesto_retencion" size="10">
	      </td>
	      <td></td>
	      <td></td>
	      <td></td>
	      <td></td>
     	</tr>

    </tfoot>
</table>

';
	echo '<input type="hidden" name="subtotal" value="'.$subtotal.'" >
		  <input type="hidden" name="factura_mostrador" value="1">
		  <input type="hidden" name="total_factura_mostrador" value="'.$total.'">
	      <input type="hidden" name="iva" value="'.$iva.'">
	      <input type="hidden" name="total" value="'.$total.'"> ';
/*
	echo '
	<table style="width:100%;margin-left: 15px; margin-right: 15px;font-family: Arial; font-size: 9px; position:absolute;bottom:3px;">
    <tr>
       <td colspan="2">Observaciones:</td>        
    </tr>
    <tr>
        <td rowspan="3">qr</td>
        <td>Fecha de emisión:</td>
            
    </tr>
    <tr>
    	<td>3
    	</td>
    </tr>
    <tr>
    	<td>4
    	</td>
    </tr>
    
</table>
	';
*/

		

//Se le da un valor a las variables

/*
$variable1 = "Hola";

$variable2 = "como estas";

$arreglo=array();
$arreglo['nombre']='Francisco';
$arreglo['ap_paterno']='Ramirez';
$arreglo['ap_materno']='Valerio';
echo $variable1;



foreach ($arreglo as $key => $value) {
	echo $key."=>".$value;
}
*/
//echo "<a href='http://facturacion.hopto.org:8080/facturacion/index.php?variable1=$variable1?arreglo=$arreglo' >Enlace</a>";

echo '<button type="submit" value="ENviar">Timbrar facturar.</button>
		</form>';

echo '
<script>
	$(function(){
		

	});
</script>';


	}



	public function reimprimir_factura_mostrador($id_factura)
	{
	    
		$this->load->helper('date');
		//$id_cliente=126;
		echo '<!DOCTYPE html> <meta charset="utf-8">
		<head>
			<style>
			.celda{
				width: 80%;
				float: left;
				white-space: pre; /* CSS 2.0 */
				white-space: pre-wrap; /* CSS 2.1 */
				white-space: pre-line; /* CSS 3.0 */
				white-space: -pre-wrap; /* Opera 4-6 */
				white-space: -o-pre-wrap; /* Opera 7 */
				white-space: -moz-pre-wrap; /* Mozilla */
				white-space: -hp-pre-wrap; /* HP */
				word-wrap: break-word; /* IE 5+ */
			}
			.ancho{
				width: 100%;
			}
			.logo{
				max-width:100px;
				max-height:100px;
			}
			.fuente{
				font-size: 8px;
				font-family: Arial;
			}
			</style>
		</head>

		';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>';

		$this->load->helper('array_helper');
	
		
		$person_id=1;
		$data["datos_empresa"]=$this->facturas_m->obtener_datos_empresa($person_id);
		$data_cliente=$this->facturas_m->obtener_facturas_mostrador($id_factura);
		//$productos["listado"]=$this->facturas_m->obtener_productos($sale_id);
		$logo=$this->facturas_m->logo();
		$url=$this->facturas_m->url();

			$cliente=$data_cliente->person_id;
	

	

		
		//var_dump($data);
		
		date_default_timezone_set('America/Monterrey');
		$fecha_emision=date('d/m/Y H:i:s');

		$file = $this->Appfile->get(1);
		header("Content-type: ".get_mime_by_extension($file->file_name));
		$logo2=$file->file_name;		
		$urllogo=$url.'/img/logo/'.$logo2;	   
		foreach ($data["datos_empresa"] as $key){

				
				$razon_social=$key->razon_social;
				$rfc=$key->rfc;
				$calle=$key->calle;
				$numero_exterior=$key->num_exterior;
				$numero_interior=$key->num_interior;
				$colonia=$key->colonia;
				$localidad=$key->localidad;
				//$referencia=$key->referencia;
				$municipio=$key->delegacion;
				$estado=$key->state;
				$pais="MÉXICO";
				$cp=$key->zip;
				$regimen_fiscal=$key->regimen_fiscal;
		
		} 


			$nom_cliente=$data_cliente->first_name.' '.$data_cliente->last_name;
			$razon_social_cliente=$data_cliente->razon_social;
			$rfc_cliente=$data_cliente->rfc;
			$calle_cliente=$data_cliente->calle;
			$num_exterior_cliente=$data_cliente->num_exterior;
			$num_interior_cliente=$data_cliente->num_interior;
			$colonia_cliente=$data_cliente->colonia;
			$localidad_cliente=$data_cliente->localidad;
			$municipio_cliente=$data_cliente->delegacion;
			$estado_cliente=$data_cliente->state;
			$pais_cliente="MÉXICO";
			$cp_cliente=$data_cliente->zip;

	$metodo_pago=$data_cliente->metodo_pago;		
	if($metodo_pago=="01")
	{
		$metodo_pago_letra="Efectivo";
	}
	if($metodo_pago=="02")
	{
		$metodo_pago_letra="Cheque nominativo";
	}
	if($metodo_pago=="03")
	{
		$metodo_pago_letra="Transferencia electrónica de fondos";
	}
	if($metodo_pago=="04")
	{
		$metodo_pago_letra="Tarjeta de crédito";
	}
	if($metodo_pago=="05")
	{
		$metodo_pago_letra="Monedero electrónico";
	}
	if($metodo_pago=="06")
	{
		$metodo_pago_letra="Dinero electrónico";
	}
	if($metodo_pago=="07")
	{
		$metodo_pago_letra="Vales de despensa";
	}
	if($metodo_pago=="08")
	{
		$metodo_pago_letra="Tarjeta de débito";
	}
	if($metodo_pago=="09")
	{
		$metodo_pago_letra="Tarjeta de Servicio";
	}
	if($metodo_pago=="10")
	{
		$metodo_pago_letra="Otros";
	}
	if($metodo_pago=="11")
	{
		$metodo_pago_letra="N/A";
	}

		



		

		echo '<style type="text/css">
	.margen-izq{
		margin-left: 50px;
	}
	.margen-der{
		margin-right: 50px;
	}
	.fuente-titulos{
		font-family: Arial,
		font-size: small;

	}
	.alinear-derecha{
		text-align: right;
	}
	.logo{
		max-width:100px;
		max-height:100px;
	}
	.centrado{
		text-align:center;
	}
	.bordes{
		
		border: inset 0pt;

	}
	.color-encabezado{
		background-color:gainsboro;
	}
	.color-productos{
		background-color:beige;
		border-style: hidden;
	}
</style>

<style>

table.auto{table-layout: auto}

th {
    padding: 1px;
    text-align: left;
}
.fuente{
	font-size: 60%;
}
</style>
</head>
<body>


<table  style="width:100%;margin-left: 15px; margin-right: 15px;font-family: Arial; font-size: 9px;">
    <tr style="width:10%">
        <td class="centrado" rowspan="6">'; 
		echo '<a href="javascript:history.back(-1);"><img id="logobd" class="logo" src="http://'.$urllogo.'"></a>';
		
		echo' 
		</td>
        <td style="width:60%">'.$razon_social.'</td>
        <td style="width:30%;text-align: right">Fecha y hora de certificación:'.$fecha_emision.'</td>        
    </tr>
    <tr>
        <td>'.$rfc.'</td>
        <td style="width:30%;text-align: right">Fecha de emisión:'.$fecha_emision.'</td>        
    </tr>
    <tr>
        <td> Calle:'.$calle.'   No:'.$numero_exterior.'   CP:'.$cp.' </td>
       <td style="width:30%;text-align: right">No de serie del Certificado del SAT:'.$data_cliente->num_certificado_sat.'</td>      
    </tr>
    <tr>
    	<td>Colonia:'.$colonia.'    Localidad:'.$localidad.'</td>
        <td style="width:30%;text-align: right">No de serie del Certificado emisor:'.$data_cliente->num_certificado_emisor.'</td>
        
    </tr>
    <tr>
    	<td> Estado:'.$estado.'    Delegación/Municipio:'.$municipio.'</td>
        <td style="width:30%;text-align: right"></td>        
    </tr>
    <tr>        
        <td>Regimen fiscal:'.$regimen_fiscal.'</td>
        <td style="width:20%;text-align: right"></td>        
    </tr>
    <tr>
    	<td colspan="3">Cliente: </td>
    </tr>
     <tr>
    	<td colspan="3">Razón Social:'.$razon_social_cliente.'  </td>
    </tr>
    <tr>
    	<td colspan="3">RFC:'.$rfc_cliente.'</td>
    </tr>
     <tr>
    	<td colspan="3">Calle:'.$calle_cliente.'    No exterior:'.$num_exterior_cliente.' No interior:'.$num_interior_cliente.'</td>
    </tr>
    <tr>
    	<td colspan="3">Colonia:'.$colonia_cliente.'    CP:'.$cp_cliente.'</td>
    </tr>
    <tr>
    	<td colspan="3">Delegación/Municipio:'.$municipio_cliente.'</td>
    </tr>
    <tr>
    	<td colspan="3">Localidad:'.$localidad_cliente.'</td>
    </tr>
    <tr>
    	<td colspan="3">Estado:'.$estado_cliente.',    '.$pais_cliente.'</td>
    </tr>
</table>

<table style="width:100%;margin-left: 15px; margin-right: 15px;font-family: Arial; font-size: 9px; padding-top:20px" id="productos">
	<thead>
		<tr class="color-encabezado">
			<td  colspan="2" >Descripción</td>
			<td>Unidad</td>
			<td>Cantidad</td>
			<td>Precio U.</td>
			<td>Importe</td>
		</tr>
	</thead>
	<tbody>'; 


			
			

			//DESCRIPCION
	//VALOR UNITARIO
	//IMPORTE
	//CANTIDAD
	//UNIDAD
	//NUMERO DE IDENTIFICACION
			


			$iva=0;
			$subtotal=0;
			$total=0;
			$contador=0;
			$subtotal=0;
			
				
			$contador++;
			echo '<tr class="color-productos"><td colspan="2">';
					echo 'Venta al mostrador';
			echo '</td><td>';
					echo 'N/A';
			echo '</td><td>';
					echo '1.0';
			echo '</td><td>';
					$producto_sin_impuesto=($data_cliente->total_factura_mostrador)-($data_cliente->total_factura_mostrador*0.16);
					$producto_sin_impuesto=number_format($producto_sin_impuesto, 2, '.','');
					echo '$'.$producto_sin_impuesto;
			echo '</td><td>';
					//echo number_format((($producto_sin_impuesto)*($key->quantity_purchased)),2,'.','');
					echo '$'.$producto_sin_impuesto;
					//echo '$'.$key->importe;
			echo '</td></tr>';

			$subtotal=$subtotal+($producto_sin_impuesto);
			$iva=$iva+((($data_cliente->total_factura_mostrador)*0.16));

			

			//$iva=$iva+$key->iva;
			//$subtotal=$subtotal+$key->importe;
			$total=$producto_sin_impuesto+$iva;
			$total = number_format($total, 2, '.', '');

			

		

/*
		$formato_pago=$_POST['formato_pago'];
	$condiciones_pago=$_POST['condiciones_pago'];
	$subtotal=$_POST['subtotal'];
	$descuento=$_POST['descuento'];
	$motivo_descuento=$_POST['motivo_descuento'];
	$tipo_cambio=$_POST['tipo_cambio'];
	$moneda=$_POST['moneda'];
	$total=$_POST['total'];
	$tipo_comprobante=$_POST['tipo_comprobante'];
	$metodo_pago=$_POST['metodo_pago'];
	$lugar_expedicion=$_POST['localidad_emisor'].', '.$_POST['estado_emisor'];
	$numero_cuenta=$_POST['numero_cuenta'];
	$folio_fiscal_original="";
	$serie_folio_fiscal="";
	$fecha_folio_fiscal=null;
	$monto_folio_fiscal=0;

*/
		

echo '
	</tbody>
	<tfoot class="color-productos">
    	<tr>
	      <td>Condiciones de pago:'.$data_cliente->condiciones_pago.'
		      
	      </td>
	      <td>Método de pago:'.$data_cliente->metodo_pago.'-'.$metodo_pago_letra.'
	      </td>
	      <td></td>
	      <td></td>
	      <td>Subtotal:</td>
	      <td>$'.number_format($producto_sin_impuesto, 2,'.','').'</td>
     	</tr>
     	<tr>
	      <td>Moneda: MXN  TC:'.$data_cliente->tc.'
	      	 
	      </td>
	      <td>Forma de pago:'.$data_cliente->forma_pago.'
	      	  
	      </td>
	      <td></td>
	      <td></td>
	      <td>IVA:</td>
	      <td>$'.number_format($iva,2,'.','').'</td>
     	</tr>
     	<tr>
	      <td>Núm. Cta. Pago:'.$data_cliente->numero_cuenta.'</td>
	      <td>
	      	Descuento:'.$data_cliente->descuento.'<br> Motivo del descuento: '.$data_cliente->motivo_descuento.'
	      </td>
	      <td></td>
	      <td></td>
	      <td>Total:</td>
	      <td>$'.$total.'</td>
     	</tr>
     	<tr>
	      <td>Impuesto de traslado: '.$data_cliente->tipo_impuesto_traslado.'<br>
	      		Tasa Impuesto:'.$data_cliente->tasa_impuesto_traslado.'<br>
	      		Importe Impuesto: '.$data_cliente->importe_impuesto_traslado.'

	      </td>
	      <td>
	      	Impuesto tipo retención:'.$data_cliente->tipo_impuesto_retencion.'<br>
	      	Importe impuesto retención: '.$data_cliente->importe_impuesto_retencion.'
	      </td>
	      <td></td>
	      <td></td>
	      <td></td>
	      <td></td>
     	</tr>

    </tfoot>
</table>

';
	echo '<input type="hidden" name="subtotal" value="'.$subtotal.'" >
		  <input type="hidden" name="factura_mostrador" value="1">
		  <input type="hidden" name="total_factura_mostrador" value="'.$total.'">
	      <input type="hidden" name="iva" value="'.$iva.'">
	      <input type="hidden" name="total" value="'.$total.'"> 




<div style="bottom: 10px ; position: absolute;" class="celda ancho">
<label class="fuente" >Sello digital del CFDI:'.$data_cliente->sello_digital_cfd.'</label>
<br>
<label class="fuente" >Sello digital del SAT:<br>'.$data_cliente->sello_sat.'</label>
<br>
<label class="fuente" >Cadena original del complemento de certificación digital del SAT:'.$data_cliente->cadena_original.'</label>
</div>



	      ';
/*
	echo '
	<table style="width:100%;margin-left: 15px; margin-right: 15px;font-family: Arial; font-size: 9px; position:absolute;bottom:3px;">
    <tr>
       <td colspan="2">Observaciones:</td>        
    </tr>
    <tr>
        <td rowspan="3">qr</td>
        <td>Fecha de emisión:</td>
            
    </tr>
    <tr>
    	<td>3
    	</td>
    </tr>
    <tr>
    	<td>4
    	</td>
    </tr>
    
</table>
	';
*/

		

//Se le da un valor a las variables

/*
$variable1 = "Hola";

$variable2 = "como estas";

$arreglo=array();
$arreglo['nombre']='Francisco';
$arreglo['ap_paterno']='Ramirez';
$arreglo['ap_materno']='Valerio';
echo $variable1;



foreach ($arreglo as $key => $value) {
	echo $key."=>".$value;
}
*/
//echo "<a href='http://facturacion.hopto.org:8080/facturacion/index.php?variable1=$variable1?arreglo=$arreglo' >Enlace</a>";

echo '
		</form>';

echo '
<script>
	$(function(){
		

	});
</script>';


	}





}