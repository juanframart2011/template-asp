<?php $this->load->view("partial/header"); ?>
<div id="content-header" class="hidden-print">
	<h1><i class="icon fa fa-coffee"></i> <?php echo lang('common_dashboard'); ?></h1>
</div>
<div id="breadcrumb" class="hidden-print">
	<?php echo create_breadcrumb(); ?>
	<label style="color:#A4A4A4" id="licencia"><h5></h5></label>
	
</div>


<!--
<div class="alert alert-success">Licencias</div>

<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-3">
				<label >Tiempo:</label>
				<select id="mes" name="mes">
						
						<option value="12">12 Meses</option>
						<option value="18">18 Meses</option>
						<option value="24">24 Meses</option>
				</select>
			</div>
			<div class="col-md-4">
				<label >Costo mensual:</label>
				<input type="text" id="costo_mes" size="6" disabled="disabled" value="$190">
			</div>
				
			<div class="col-md-4">
				<label >Cantidad a pagar:</label>
				<input type="text" id="costo_anual" size="6" disabled="disabled" value="$2280">
			</div>
			

					
					

			
		</div>
		<div class="row">
			<div  class="col-md-12" id="btnpaypal"> 
				<a href="https://www.paypal.me/syprint/250"><img src="https://www.paypalobjects.com/webstatic/es_MX/mktg/logos-buttons/redesign/btn_10.png" alt="undefined" /></a>
				
			</div>
		</div>
	</div>
</div>


<table class="table table-dark" style="width: 60%; text-align: center;">
	<thead>
		<tr>
			<th scope="col">Total venta</th>
			<th scope="col">Entrada de hoy</th>
			<th scope="col">Trabajos pendientes por entregar</th>
			<th scope="col">Adeudos clientes</th>
		</tr>
	</thead>
	<tbody>
		<td>$<label id="total_diario_venta"></label>
		</td>
		<td>$<label id="total_diario_abonos"></label>
		</td>
		<td><label id="trabajos_pendientes"></label>
		</td>
		<td>$<label id="deuda"></label>
		</td>
	</tbody>
</table>


-->


<div class="clear"></div>
<div class="text-center">					
	
	
</div>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript">
	$(function(){
		$("#mes").on("change",function(){
			if(($(this).val())==1 ){
				$("#costo_mes").val("$250");
				$("#costo_anual").val("$250");
				$("#btnpaypal").html('');
				$("#btnpaypal").html('<div  class="col-md-12"><a href="https://www.paypal.me/syprint/250"><img src="https://www.paypalobjects.com/webstatic/es_MX/mktg/logos-buttons/redesign/btn_10.png" alt="undefined" /></a></div>');
			}
			if(($(this).val())==3 ){
				$("#costo_mes").val("$230");
				$("#costo_anual").val("$690");
				$("#btnpaypal").html('');
				$("#btnpaypal").html('<div  class="col-md-12"><a href="https://www.paypal.me/syprint/690"><img src="https://www.paypalobjects.com/webstatic/es_MX/mktg/logos-buttons/redesign/btn_10.png" alt="undefined" /></a></div>');
			}
			if(($(this).val())==6 ){
				$("#costo_mes").val("$210");
				$("#costo_anual").val("$1260");
				$("#btnpaypal").html('');
				$("#btnpaypal").html('<div  class="col-md-12"><a href="https://www.paypal.me/syprint/1260"><img src="https://www.paypalobjects.com/webstatic/es_MX/mktg/logos-buttons/redesign/btn_10.png" alt="undefined" /></a></div>');
			}
			if(($(this).val())==12 ){
				$("#costo_mes").val("$190");
				$("#costo_anual").val("$2280");
				$("#btnpaypal").html('');
				$("#btnpaypal").html('<div  class="col-md-12"><a href="https://www.paypal.me/syprint/2280"><img src="https://www.paypalobjects.com/webstatic/es_MX/mktg/logos-buttons/redesign/btn_10.png" alt="undefined" /></a></div>');
			}
			if(($(this).val())==18 ){
				$("#costo_mes").val("$170");
				$("#costo_anual").val("$3060");
				$("#btnpaypal").html('');
				$("#btnpaypal").html('<div  class="col-md-12"><a href="https://www.paypal.me/syprint/3060"><img src="https://www.paypalobjects.com/webstatic/es_MX/mktg/logos-buttons/redesign/btn_10.png" alt="undefined" /></a></div>');
			}
			if(($(this).val())==24 ){
				$("#costo_mes").val("$150");
				$("#costo_anual").val("$3600");
				$("#btnpaypal").html('');
				$("#btnpaypal").html('<div  class="col-md-12"><a href="https://www.paypal.me/syprint/3600"><img src="https://www.paypalobjects.com/webstatic/es_MX/mktg/logos-buttons/redesign/btn_10.png" alt="undefined" /></a></div>');
			}
		});	

		var total_diario,total_abonos;

		$.ajax({
			url:"<?php echo base_url(); ?>index.php/licencia/obtener_licencia",
			type:"GET",
			dataType:"json",
			success:function(data){
				if(data.dias<=0){
					alert("Tu hosting ha caducado.Favor de comunicarte con el proveedor.");
					function deleteAllCookies() {
					    document.cookie = "phppos=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
					};
					deleteAllCookies();

					location.href="<?php echo base_url(); ?>";
					return false;
				}
				if(data.dias>6){
					$("#licencia").text("Renovación de hosting:"+data.dia+" de "+data.mes+" del "+data.ano);
					$("#licencia").css("color","#A4A4A4");
				}else{
					$("#licencia").text("¡Atención! tu hosting caduca el :"+data.dia+" de "+data.mes+" del "+data.ano);
					$("#licencia").css("color","red");
				}
			},
			error: function(){

			}
		});

		$.ajax({
			url:"<?php echo base_url(); ?>index.php/abonos/total_diario_venta",
			type:"GET",
			dataType:"json",
			async:false,
			success:function(data){
				if(data.total!=null){
					$("#total_diario_venta").text(data.total);
					total_diario=data.total;
				}else{
					$("#total_diario_venta").text(0);
					total_diario=0;
				}
			
			},
			error: function(){

			}
		});

		$.ajax({
			url:"<?php echo base_url(); ?>index.php/abonos/total_diario_abonos",
			type:"GET",
			dataType:"json",
			async:false,
			success:function(data){
				if(data.total!=null){
					$("#total_diario_abonos").text(data.total);
					total_abonos=data.total;
				}else{
					$("#total_diario_abonos").text(0);
					total_abonos=0;
				}
			},
			error: function(){

			}
		});

		$.ajax({
			url:"<?php echo base_url(); ?>index.php/abonos/trabajos_pendientes",
			type:"GET",
			dataType:"json",
			success:function(data){
				if(data.total!=0){
					$("#trabajos_pendientes").text(data.pedidos);
				}else{
					$("#trabajos_pendientes").text(0);
				}
			},
			error: function(){

			}
		});
/*
		$.ajax({
			url:"<?php echo base_url(); ?>index.php/abonos/deudas_clientes",
			type:"GET",
			dataType:"json",
			success:function(data){
				if(data.total!=0){
					$("#deuda").text(data.deuda);
				}else{
					$("#deuda").text(0);
				}
			},
			error: function(){

			}
		});
*/



		$("#enviarsugerencia").on("click",function(){
			if($("#nombre").val()=="" || $("#apellidos").val()=="" || $("#pais").val()=="" 
			|| $("#estado").val()=="" || $("#municipio").val()=="" || $("#requerimiento").val()=="" || $("#titulo").val()=="" || $("#descripcion").val()==""){
				alert("Campos incompletos.");
				return false;
			}

			$.ajax({
			url:"<?php echo base_url(); ?>index.php/email/enviar_requerimiento",
			type:"POST",
			dataType:"json",
			data:{nombre:$("#nombre").val(),apellidos:$("#apellidos").val(),pais:$("#pais").val(),estado:$("#estado").val(),municipio:$("#municipio").val(),requerimiento:$("#requerimiento").val(),titulo:$("#titulo").val(),descripcion:$("#descripcion").val()
			},
			success:function(data){
				if(data==true){
					alert("Gracias por enviar tus requerimientos.");
					$("#nombre").val('');
					$("#apellidos").val('');
					$("#pais").val('');
					$("#estado").val('');
					$("#municipio").val('');
					$("#requerimiento").val('');
					$("#titulo").val('');
					$("#descripcion").val('');
				}else{
					alert("Intentalo más tarde.");
				}
			},
			error: function(){

			}
		});
		});

		$("#otrosistema").on("click",function(){
			if($("#imprenta").val()=="" || $("#correo").val()=="" || $("#whatsapp").val()==""){
				alert("Campos incompletos.");
				return false;
			}

			


        function validar_email( email ) 
		{
		    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		    return regex.test(email) ? true : false;
		}


        var email_prueba = $("#correo").val();
 
		if( validar_email( email_prueba ) )
		{
		    
		}
		else
		{
		    alert("¡El email NO es correcto!");
		    return false;
		}


			$.ajax({
			url:"<?php echo base_url(); ?>index.php/email/otro_sistema",
			type:"POST",
			dataType:"json",
			data:{imprenta:$("#imprenta").val(),correo:$("#correo").val(),whatsapp:$("#whatsapp").val()
			},
			success:function(data){
				if(data==true){
					alert("Gracias por enviar tu solicitud.");
					$("#imprenta").val('');
					$("#correo").val('');
					$("#whatsapp").val('');
					
				}else{
					alert("Intentalo más tarde.");
				}
			},
			error: function(){

			}
		});
		});
	
	var deuda=parseInt(total_diario-total_abonos);
	if(deuda<=0){
		$("#deuda").text(0);
	}else{
		if(isNaN(deuda)){
			$("#deuda").text(0);
			return false;
		}
		$("#deuda").text(deuda);
	}
	console.log(deuda);

	});
</script>