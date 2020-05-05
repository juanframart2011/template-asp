<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.numeric.js"></script>
<style type="text/css">
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


</style>



		
	<?php
		$logo=($this->Appconfig->get_logo_image());
		$empresa=$this->config->item('company');
		$direccion=nl2br($this->Location->get_info_for_key('address'));
		$telefono=$this->Location->get_info_for_key('phone');
		$web=$this->config->item('website');
	?>
<!--
	<img src="<?php echo $this->Appconfig->get_logo_image(); ?>">
-->
<?php $message='
<div id="content-header" class="receipt_wrapper">
	<h1 class="headigs"> <i class="icon fa fa-barcode"></i>
		Cotización.<p></h1></p>
		<div class="centrado">';
		
	$logo='<img src="'.$this->Appconfig->get_logo_image().'"><br>'; ?>

	<?php
	$datos='			
			<label><h3>'.$empresa.'</h3></label><br>
			<label>'.$direccion.'</label><br>
			<label>'.$telefono.'</label><br>
			<label>'.$web.'</label><br>
		</div>
		<br><br>
		<div class="row">
			<div class="col-md-2">
				<label>Número cotización:</label>
				<label>'.$data->id_cotizacion.'</label>
			</div>
			<div class="col-md-2">
				<label>Fecha:</label>
				<label>'.date_format((new DateTime($data->fecha)),"d-m-Y").'</label>
			</div>
			<div class="col-md-4">
				<label>Cliente:</label>
				<label>'.$data->nombre.'</label>
				<input type="hidden" name="cliente" id="cliente" value="'.$data->nombre.'">
			</div>
			<div class="col-md-4">
				
				<label>Comentarios:</label>
				<label>'.$data->comentarios.'</label>
			</div>
			
		</div>
		
		
	</h1>

	<div class="content">
	<p><h3></h3></p>
	
	<table id="tabla">
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
foreach($productos as $producto){$prod.='					
				<tr>
					<td>'.$producto->name.'</td>
					<td>$'.$producto->precio.'</td>
					<td>Alto:'.$producto->alto.'m x Ancho:'.$producto->ancho.'m</td>	
					<td>'.$producto->metros_cuadrados.'</td>
					<td>'.$producto->comentarios.'</td>
					<td>'.$producto->quantity_purchased.'</td>
					<td>$'.$producto->total.'</td>
				</tr>
				';};


$footer='</tbody></tbody></table>
	<div class="row derecha">
		<div class="col-md-12">
			<h3>
			<label>Total: $</label>
			<label id="lbtotal">'.$data->total_venta.'</label>	
			</h3>		
		</div>
		
	</div>
</div>'; ?>



<div id="content-header" class="receipt_wrapper" style="margin-top:30px;">
	
		<div class="row">
			<div class="col-md-12">
				<h1 class="headigs"> <i class="icon fa fa-barcode"></i>
				Cotización.
				</h1>
			</div>
		</div> 
	
		
		<div class="row" style="margin-left: 10px;">
			<div class="col-md-2">
				<label>Número cotización:</label>
				<label><?php echo $data->id_cotizacion; ?></label>
			</div>
			<div class="col-md-2">
				<label>Fecha:</label>
				<label><?php $fecha=new DateTime($data->fecha); echo date_format($fecha,'d-m-Y'); ?></label>
			</div>
			<div class="col-md-4">
				<label>Cliente:</label>
				<label><?php echo $data->nombre; ?></label>
				<input type="hidden" name="cliente" id="cliente" value="<?php echo $data->nombre; ?>">
			</div>
			<div class="col-md-4">
				<input type="hidden" name="person_id" id="person_id">	
				<input type="hidden" name="id_cotizacion" id="id_cotizacion" value="<?php echo $data->id_cotizacion; ?>">
				<input type="hidden" name="iva1" id="iva1">
				<label>Comentarios:</label>
				<label><?php echo $data->comentarios; ?></label>
			</div>
			
		</div>

	<div class="content" style="margin-left:20px;margin-right: 20px;">
	
	<table id="tabla" border="3">
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
		<tbody>
			<?php 
				foreach($productos as $producto){
					?>
				<tr>
					<td><?php echo $producto->name; ?></td>
					<td>$<?php echo $producto->precio; ?></td>
					<td>Alto:<?php echo $producto->alto; ?>m x Ancho:<?php echo $producto->ancho; ?>m</td>					
					<td><?php echo $producto->metros_cuadrados; ?></td>
					<td><?php echo $producto->comentarios; ?></td>
					<td><?php echo $producto->quantity_purchased; ?></td>
					<td>$<?php echo $producto->total; ?></td>
				</tr>
				<?php }

			?>
			
		</tbody>
	</table>
	<div class="row derecha">
		<div class="col-md-12">
			<h3>
			<label>Total: $</label>
			<label id="lbtotal"> </label>
			
			</h3>
		</div>
		
		
	</div>
	</div>
	
</div>



<?php
	
	$html_content= $message.$logo.$datos.$prod.$footer;
	$cont=str_replace(" ", "", $html_content);
				
?>
<form id="pdf" method="get" action="<?php echo base_url(); ?>index.php/cotizacion/generar_pdf">
	<input type="hidden" name="contenido" id="contenido" value="<?php echo $cont; ?>
	">

	<button id="regresar" class="btn btn-success">Generar pdf.</button>
</form>


<br>
<button id="regresar" class="btn btn-warning">Regresar a cotizaciones.</button>

<script type="text/javascript">
$(function(){
	var productos=[];
	var carrito=[];
	var total=0;
	var clientes=[];
	var total_final=<?php echo $data->total_venta; ?>;
	$("#pago").numeric();

	$("#regresar").on("click",function(){
		window.location.href = "<?php echo base_url(); ?>index.php/cotizacion";
	});

	$("#pdf").on("submit",function(){

	});


	$.ajax({
		url:"index.php/cotizacion/productos",
		type:"GET",
		dataType:"json",
		data:{autocomplete:1},
		async:false,
		success:function(data){
			data.map(function(a){
				productos.push({"label":a.name,"value":a.item_id,"unit_price":parseFloat(a.precio),"cost_price":parseFloat(a.cost_price),"cantidad":1, "alto":1,"ancho":1,"metros_cuadrados":1,"subtotal":0,"comentario":""});
			});
			
		},
		error:function(data){

		}
	});

	$.ajax({
		url:"index.php/cotizacion/clientes",
		type:"GET",
		dataType:"json",
		data:{autocomplete:1},
		async:false,
		success:function(data){
			data.map(function(a){
				clientes.push({"label":a.nombre,"value":a.person_id});
			});
			
		},
		error:function(data){

		}
	});

	$("#lbtotal").text(<?php echo $data->total_venta; ?>);
	$("#iva1").val("no");

	$("input:radio[name=iva]").on("change",function(){
		var radio=$('input:radio[name=iva]:checked').val();
		if(radio=="si"){
			var t=total_final*0.16;
			var final=total_final+t;
			$("#lbtotal").text(final);
			$("#total").val(final);
			$("#iva1").val("si");
		}else{
			
			$("#lbtotal").text(total_final);
			$("#total").val(total_final);
			$("#iva1").val("no");
		}
	});


	$("#producto").val('');
	$("#person_id").val('');
	$("#comentarios").val('');
	$("#txtcliente").val('');
	var total=0;
    $("#pago").val("");
    $("#cambio").text("");

$("#guardar").on("click",function(){
	$("#cambio").text("");

	var total=parseFloat($("#total").val());
	var pago=parseFloat($("#pago").val());

	if(pago==null || pago==0 || pago=="")
	{
		pago=0;
	}

	if(pago>=total){
		var cambio=pago-total;
		$("#cambio").text("Su cambio: $"+cambio);
		var pagofinal=$("#total").val();
		
		alert("Cambio: $"+cambio);
	}else{
		pagofinal=pago;
		
	}
	

	$.ajax({
  		url:"/index.php/cotizacion/guardar_venta",
  		type:"POST",
  		dataType:"json",
  		data:{abono:pagofinal,id_cotizacion:$("#id_cotizacion").val(),total_final:$("#total").val(),tipo_pago:$("#tipo_pago").val(),cliente:$("#cliene").val(),iva:$("#iva1").val()},
  		success:function(data){
  			if(data>=1){
  				alert("¡Venta realizada con éxito!");
  				$(location).attr('href','/index.php/cotizacion'); 
  				window.location.href("/index.php/cotizacion");
  			}

  			
  		
  		},
  		error:function(){
  			alert("Error al guardar la Cotización.");
  		}
  	});
});
  	


});

</script>