<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.numeric.js"></script>
<style type="text/css">
	table, th, td {
    border: 3px solid #ddd;
}

	table{
		width: 100%;
	}
	.derecha{
		text-align: right;
	}
</style>


<div id="content-header" class="receipt_wrapper" style="margin-top:30px;">
	
		<div class="row">
			<div class="col-md-12">
				<h1 class="headigs"> <i class="icon fa fa-barcode"></i>
				Realizar venta.
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
			<label>IVA(16%): $</label>
			<label><?php echo  $data->total_iva; ?> </label>
			
			</h3>
		</div>

		<div class="col-md-12">
			<h3>
			<label>Total: $</label>
			<label id="lbtotal"> </label>
			<input type="hidden" name="total_final" id="total_final">
			</h3>
		</div>
		<div class="col-md-12">
			<label>Tipo de pago:</label>
			<select name="tipo_pago" id="tipo_pago" class="input-medium" style="width: 120px;">
						<option value="Efectivo" selected="selected">Efectivo</option>
						<option value="Cheque">Cheque</option>
						<option value="Tarjeta de Regalo">Tarjeta de Regalo</option>
						<option value="Tarjeta de Débito">Tarjeta de Débito</option>
						<option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
						<option value="Transferencia">Transferencia</option>
					</select>
		</div>
		<div class="col-md-12">
			<label>Su pago:</label>
			<input type="text" name="pago" id="pago">
		</div>		
		<div class="col-md-12">
			<label id="cambio"></label>
		</div>
		<div class="col-md-12">
			<label>IVA:</label>
				<select id="iva" name="iva">
					<option value="0">No</option>
					<option value="1">Si</option>
				</select>
			
		</div>
		<div class="col-md-12">
			<button id="guardar" class="btn btn-success">Completar venta.</button>
		</div>
		<div class="col-md-12">
			<button id="imprimir" class="btn btn-info">Imprimir cotización.</button>
		</div>
		<!--
		<div class="col-md-12">
			<button id="enviar_cotizacion" data-id-cotizacion="<?php echo $data->id_cotizacion; ?>"  class="btn btn-info">Enviar cotización.</button>
		</div>
	-->
		<div class="col-md-12">
			<button id="pdf" data-id-cotizacion="<?php echo $data->id_cotizacion; ?>"  class="btn btn-info">Generar PDF.</button>
		</div>
		<button id="regresar" class="btn btn-warning">Regresar</button>

	</div>
	</div>
	
</div>


<!-- Modal -->
<div class="modal fade" tabindex="-1"  id="modal" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Ingresa el número para poder enviar la cotización.<label id="id_cuenta"></label></h5>
        
      </div>
      <div class="modal-body" style="background-color:#6ccdf3">
      		<div class="row" >
      			<div class='col-md-4'>
      				<label>Ingresa este número:</label>
      			</div>
      			<div class='col-md-3'>
      			<h3>      				
      				<label id="lbrandom" ></label>
      			</h3>
      			</div>
      			<div class='col-md-2'>
      				<label>Número:</label>
      			</div>
      			<div class='col-md-2'>
      				<input type="text" id="numero" name="numero" size="5" step="any">
      			</div>      			
      			
      		</div>

      </div>
      <div class="modal-footer">
        <button id="enviar_mail" class="btn btn-info" >Enviar cotización.</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
$(function(){
	var productos=[];
	var carrito=[];
	var total=0;
	var clientes=[];
	var total_final=<?php echo $data->total_venta; ?>;
	$("#total_final").val(total_final);
	$("#pago").numeric();
	$("#numero").numeric();

	$("#regresar").on("click",function(){
		window.history.back();
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

	$("#imprimir").on("click",function(){
		window.print();
	});

	var numero_rand,rand=0;
	var id_cotizacion="";

	$("#pdf").on("click",function(){
		id_cotizacion=$(this).attr('data-id-cotizacion');	
		url = "<?php echo base_url(); ?>index.php/cotizacion/generar_pdf/"+id_cotizacion;
		window.open(url, "", "width=600,height=600");
      	//window.open(url, '_blank');
      	return false;
	});

	$("#enviar_cotizacion").on("click",function(){
		$("#numero").val('');
		$("#modal").modal('show');
		rand=<?php echo rand(0,99999); ?>;
		console.log(rand);
		$("#lbrandom").text(rand);
		numero_rand=rand;

		id_cotizacion=$(this).attr('data-id-cotizacion');

		//window.location.href = "<?php echo base_url(); ?>index.php/cotizacion/enviar/"+id_cotizacion;
	});

	$("#enviar_mail").on("click",function(){
		console.log(parseInt($("#numero").val())+"-------"+parseInt(rand));
		if(parseInt($("#numero").val())==parseInt(numero_rand)){
			alert("Correcto");
			window.location.href = "<?php echo base_url(); ?>index.php/cotizacion/enviar/"+id_cotizacion;
		}else{
			alert("Número Incorrecto.Vuelve a intentarlo.");

		}
	});

	$("#lbtotal").text(<?php echo $data->total_venta; ?>);
	
	$("#iva").val(<?php if($data->iva){echo $data->iva;}else{echo 0;} ?>);

	$("#iva").on("change",function(){
		var iv=$(this).val();
		if(iv=="1" || iv==1){
			
			$.ajax({
		  		url:"/index.php/cotizacion/add_iva",
		  		type:"POST",
		  		dataType:"json",
		  		data:{id_cotizacion:$("#id_cotizacion").val(),total_final:$("#total_final").val()},
		  		success:function(data){
		  			if(data>=1){
		  				//alert("¡IVA agregado con éxito!");
		  				//$(location).attr('href','/index.php/cotizacion'); 
		  				window.location.reload();
		  			}

		  			
		  		
		  		},
		  		error:function(){
		  			alert("Error al guardar la Cotización.");
		  		}
		  	});



		}else{
			
			$("#lbtotal").text(total_final);
			$("#total").val(total_final);
			//$("#iva1").val("no");
			//$("#total_final").val(final);


			$.ajax({
		  		url:"/index.php/cotizacion/del_iva",
		  		type:"POST",
		  		dataType:"json",
		  		data:{id_cotizacion:$("#id_cotizacion").val(),total_final:$("#total_final").val()},
		  		success:function(data){
		  			if(data>=1){
		  				//alert("¡IVA eliminado con éxito!");
		  				//$(location).attr('href','/index.php/cotizacion'); 
		  				window.location.reload();
		  			}

		  			
		  		
		  		},
		  		error:function(){
		  			alert("Error al guardar la Cotización.");
		  		}
		  	});



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

	var total=parseFloat($("#total_final").val());
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

	if(isNaN(pagofinal)){
		pagofinal=0;
	}
	

	$.ajax({
  		url:"/index.php/cotizacion/guardar_venta",
  		type:"POST",
  		dataType:"json",
  		data:{abono:pagofinal,id_cotizacion:$("#id_cotizacion").val(),total_final:$("#total_final").val(),tipo_pago:$("#tipo_pago").val(),cliente:$("#cliene").val(),iva:$("#iva1").val()},
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