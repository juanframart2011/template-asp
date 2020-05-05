
<style type="text/css">
	.top{
		margin-top: 15px;
	}
</style>
<div id="content-header" class="hidden-print">
	<h1 > <i class="fa fa-pencil"></i>  Factura público.</h1>
</div>
<div id="breadcrumb" class="hidden-print">
	<?php echo create_breadcrumb(); ?> <a class="current" href="#">Factura diaria</a>
</div>
<div class="clear"></div>

<div class="row">
	<div class="col-md-6">
		<div class="col-md-12 top">
			<label class="col-md-3" for="rfc">Selecciona el dia a facturar:</label>
			<input class="col-md-6 " name="fecha" type="text" id="fecha">
		</div>
		
		<div class="col-md-12 top">
			<label class="col-md-3">Total: </label><label class="col-md-3" id="total"></label>
		</div>
		
		<div class="col-md-12 top">
			<div class="col-md-3"></div>
			<button id="buscar_facturas" class="col-md-6 top btn btn-primary btn-MD">Generar total.</button>
			<form action="index.php/factura/realizar_factura_mostrador" method="get">
			
		</div>
		<div class="col-md-12 top">
			<div class="col-md-3"></div>
			<button id="btn_formato" type="submit" class="col-md-6 top btn btn-primary btn-MD" disabled>Ver formato factura</button>
		</div>
	</div>
	<input type="hidden" id="fecha_venta" name="fecha_venta" vaue="">
<input type="hidden" id="importe" name="importe" value="">

</form>
	<div class="col-md-6">
		<div class="col-md-12">
			<label class="col-md-12" id="editar_rfc"><a>Editar cliente para facturas al mostrador.</a></label>
		</div>
		<div class="col-md-12">			
			
				<label class="col-md-3" for="rfc">RFC:</label>
				<input class="col-md-6 " type="text" id="rfc" disabled>	
				<button id="guardar_rfc" class="col-md-3 btn btn-primary btn-MD">Guardar.</button>			
		</div>
		<div class="col-md-12 top">
			<?php 
				foreach($datos as $value){
					?>
					<label class="col-md-2">Razón social: </label>
					<label class="col-md-10"><?php echo $value->razon_social; ?></label>
					<label class="col-md-2">RFC: </label>
					<label class="col-md-10"><?php echo $value->rfc; ?></label>
					<label class="col-md-2">Dirección: </label>
					<label class="col-md-10"><?php echo $value->calle.', #'.$value->num_exterior.', '.$value->colonia.', '.$value->localidad.', '.$value->state; ?></label>
				<?php
				}

			?>		
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<table id="example" class="display" cellspacing="0" width="100%">
	        <thead>
	            <tr>
	                <th>Número de factura</th>
	                <th>Razón social</th>
	                <th>Total</th>
	                <th>Fecha timbrado</th>	
	                <th>Reimprimir factura</th>	                   
	            </tr>
	        </thead>
	        <tfoot>
	            <tr>
	                <th>Número de factura</th>
	                <th>Razón social</th>
	                <th>Total</th>
	                <th>Fecha timbrado</th>	
	                <th>Reimprimir factura</th>	 	           
	            </tr>
	        </tfoot>
	        <tbody>
	        </tbody>
	    </table>
	</div>
</div>


 <script src="<?php echo base_url(); ?>/js/bootstrap-datepicker.js"></script>
 <!--
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
-->


<script type="text/javascript">
$(function(){

	$("#editar_rfc").on('click',function(){
		$("#rfc").prop('disabled',false);
	});

	$( "#fecha" ).datepicker({
		dateFormat: 'yy-mm-dd' 
	});

	$("#buscar_facturas").on('click',function(){
		$("#btn_formato").prop('disabled',true);
	$("#fecha_venta").val($("#fecha").val());
	var fecha=$("#fecha").val();
		$.ajax({
			url:"index.php/factura/facturar_ventas_mostrador",
			type:"GET",
			data:{fecha:fecha},
		
			success:function(data){
				$("#total").text("$"+data);
				$("#importe").val(data);
				console.log(data);
				if(data!=0){
					$("#btn_formato").prop('disabled',false);
				}
			},
			error:function(data){
				
			}
		});
	}); 


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
			}			
		} ); 

		$("#guardar_rfc").on('click',function(){
			$.ajax({
				url:"index.php/factura/cambiar_rfc_mostrador",
				type:"POST",
				data:{rfc:$("#rfc").val()},
				success:function(a){
					alert("Modificación exitosa.");
					location.reload();
				},
				error:function(){
					$("#rfc").val('');
					alert("No existe RFC.");
				}

			});
		});

			 

		res=[];
		facturas=[];
		var listado=[];
		var datos=[];
		var rfc=$("#rfc").val();
		var sale_id=$("#sale_id").val();
		$.ajax({
			url:"index.php/factura/facturas_mostrador",
			type:"POST",
			//data:{rfc:rfc,sale_id:sale_id},
			dataType:"json",
			async:false,
			success:function(data){
				datos=[];
				var x= data.sale_id;
				
				if(x=='undefined' || x==undefined){	
					datos=data;
				}else{
					res.push({data:listado});
					console.log(res);

					facturas=[];
					datos.push(data);
					
				}
				
			},
			error:function(data){
				
			}
		});

		console.log(datos);
			table=$('#example').DataTable( {
				 "bDestroy": true,
				 "language": {
            "url": "<?php echo base_url();?>/js/Spanish.json"
        },
    data: datos,
     "order": [[ 0, "desc" ]],
    columns: [
        { data: 'id_factura' },
        { data: 'razon_social' },
        { data: 'total_factura_mostrador' },      
        { data: 'fecha_timbrado'}
    ],
   columnDefs: [ {
   			render: function ( data, type, row ) {
				return 	'<a href="<?php echo base_url(); ?>/index.php/factura/reimprimir_factura_mostrador/'+row.id_factura+'"><button>Reimprimir factura</button></a>'
			},

            targets: 4
           
            
        } ]
		
    });



});



	
</script>
