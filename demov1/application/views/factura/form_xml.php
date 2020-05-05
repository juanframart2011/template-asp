<style type="text/css">
	.top_row{
		padding-top:10px
	}
	.top_sec{
		padding-top: 30px
	}
</style>

<div id="content-header" class="hidden-print">
	<h1><i class="icon fa fa-group"></i>Enviar pdf y XML. </h1>
</div>
<form action="index.php/factura/enviar_xml" id="enviar_email" enctype="multipart/form-data" method="post">
<div class="row">
	<div class="col-md-6">
		<div class="col-md-12 top top_row">
			<label class="col-md-4" for="rfc">Escribe el RFC y selecciona:</label>
			<input class="col-md-7 " type="text" id="rfc">
		</div>
		
		<div class="col-md-12 top top_row">
			<label class="col-md-4" for="sale_id">Correo electrónico del cliente:</label>
			<input class="col-md-7 " type="email" name="correo" id="correo" required>
		</div>
		
		
	</div>
</div>
<div class="row top_sec">
	<label class="col-md-1">Asunto:</label>
	<input class="col-md-6" type="text" name="asunto" id="asunto" required>
</div>
<div class="row top_row" >
	<label class="col-md-1">Mensaje:</label>
	<input class="col-md-10" type="text" name="mensaje" id="mensaje" required>
</div>

<div class="row top_sec">
	<label class="col-md-1">XML:</label>
	<input class="col-md-6" type="file" name="archivo1" id="archivo1" required>
</div>
<div class="row top_row" >
	<label class="col-md-1">PDF:</label>
	<input class="col-md-10" type="file" name="archivo2" id="archivo2" required>
</div>
<div class="row top_row">
	<button style="" type="submit" class="imagen btn btn-primary col-md-offset-3 col-md-3 " title="" value="204" id="58">Enviar Correo electrónico.</button>
</div>

</form>

<script type="text/javascript">
	$(function(){
		$( "#rfc" ).autocomplete({
			minLength: 1,
	 	    delay : 400,
			source: function(request, response) { 

				jQuery.ajax({
				   url: 	 "index.php/factura/buscar_cliente",
				   data:  {
				   			rfc:$("#rfc").val()
				   	},
				   dataType: "json",

				   success: function(data) 	{

					 response(data);
				  }	

				})
	 	   },
		   select:  function(e, ui) {
				var keyvalue = ui.item.value;
				var rfc=ui.item.value;	
				//alert(rfc);
				jQuery.ajax({
				   url: 	 "index.php/factura/buscar_email",
				   data:  {
				   			rfc:rfc
				   	},
				   dataType: "json",

				   success: function(data) 	{
				   	 $("#correo").val(data);
					 $("#correo").attr("readonly",true);
				  }	

				})
			}
			
		} );

		$("#enviaraaaa").on("click",function(){
			jQuery.ajax({
				   url: 	 "index.php/factura/enviar_xml",
				 
				   data:  {
				   			asunto:$("#asunto").val(),
				   			mensaje:$("#mensaje").val(),
				   			destinatario:$("#correo").val(),
				   			archivo1:$("#archivo1").val(),
				   			archivo2:$("#archivo2").val()
				   	},
				   	 contentType: false,
                processData: false,
				 	
				   success: function(data) 	{
				   	 alert("Correcto");
				   	 return false;
				  }	,
				  error:function(){
				  	alert("Error");
				  	 return false;
				  }

				})
		});

	});
</script>