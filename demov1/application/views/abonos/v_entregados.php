<div class="row">
	<div class="col-md-12">
		<a href="/index.php/abonos/abonar">
			<button class="btn btn-primary" >Abonar</button>
		</a>
		<a href="/index.php/abonos/cuenta_term_pagada">
			<button class="btn btn-primary" >Cuentas pagadas y terminadas</button>
		</a>
		<a href="/index.php/abonos/cuenta_pagada_no_term">
			<button class="btn btn-primary" >Cuentas pagadas en producción</button>
		</a>
		<a href="/index.php/abonos/entregados">
			<button class="btn btn-primary" >Pedidos entregados.</button>
		</a>
		<a href="/index.php/abonos/eliminar_venta">
			<button class="btn btn-primary" >Eliminar venta.</button>
		</a>
		<a href="/index.php/abonos/ventas_eliminadas">
      		<button class="btn btn-primary" >Ventas eliminadas.</button>
    	</a>
	</div>
</div>

<div class="row">
	<div class="alert alert-info" role="alert">
  <h3>Pedidos entregados.</h3>
</div>
	<div class="col-md-12">
		<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Id venta</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Forma de pago</th>
                
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Id venta</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Forma de pago</th>
                
            </tr>
        </tfoot>
    </table>
	</div>
</div>


<script type="text/javascript">
	$(function(){
	$('#myModal').on('shown.bs.modal', function () {
    $('#myInput').focus()
});

		$("#checkentregar").prop("checked",false);
		$("#abono").numeric();
		var cont=0;


		$('#example').DataTable({
			"ajax": {
				url:"<?php echo base_url().'index.php/abonos/entregadas'; ?>",
				type:"GET",
				//dataType:"json",
				//data:{sale_id:$("#id_sale").val()},
				async:false,
				
				error:function(data){

				}      				
      		

			},
			"columns": [
				            { "data": "sale_id" },
				            { "data": "cliente" },
				            { "data": "fecha" },
				            { "data": "total" },
				            { "data": "forma_pago" }
				            
			],
			"language": {
                "url": "<?php echo base_url(); ?>js/Spanish.json"
            },
			"columnDefs": [
		{
			"render": function ( data, type, row ) {
				return 	'<button class="btn btn-success">'+row.sale_id+'</button>';
			},
			
		}
	],
		});


	});
</script>