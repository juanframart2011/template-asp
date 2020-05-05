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
  <h3>Cuentas pagadas y terminadas.</h3>
</div>
	<div class="col-md-12">
		<table id="cuentas_pagadas_terminadas" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td>Id venta</td>
				<td>Total</td>
				<td>Abonos</td>
				<td>Cliente</td>
				<td>Entregar</td>             
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td>Id venta</td>
				<td>Total</td>
				<td>Abonos</td>
				<td>Cliente</td>
				<td>Entregar</td>                
            </tr>
        </tfoot>
    </table>
	</div>
</div>





<!-- Modal -->
<div class="modal fade" tabindex="-1"  id="modalentregar" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cuenta: <label id="cuenta"></label></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color:#6ccdf3">
      		<input type="hidden" id="id_sale">
      		<div class="row" id="productos">
      			<table class="table" id="table">
      				<thead>
      					<th>Producto</th>	      				
	      				<th>Cantidad</th>
	      				<th>Precio</th>
	      				<th>Descripcion</th>
      				</thead>
      				<tbody id="tbody">
      					
      				</tbody>
      				
      			</table>
      			
      		</div>
      		<div class="row" style="padding-top: 40px;"></div>
        	<div class="row" id="lista_abonos">
        		<div class='col-md-4'></div><div class='col-md-4'></div><div class='col-md-4'></div>
        	</div>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-primary" id="terminar" data="">Entregar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
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


		$("#terminar").on("click",function(){
      		$.ajax({
				url:"<?php echo base_url().'index.php/abonos/entregar'; ?>",
				type:"GET",
				dataType:"json",
				data:{sale_id:$("#id_sale").val()},
				async:false,
				success:function(data){
					if(data!=0){
						alert("Entregado Correctamente");
						location.reload();
					}else{
						alert("Intentalo de nuevo.");
					}
				},
				error:function(data){

				}      				
      		});
		});      	



		//Datatable cuentas pagadas terminadas
		$("#cuentas_pagadas_terminadas").DataTable({
            "ajax": {
                url:"<?php echo base_url(); ?>index.php/abonos/cuentas_terminadas",
                type:"GET",
                //dataType:"json",
                data:{tabla:1},
                //async:false,
                beforeSend: function(xhr){
                xhr.setRequestHeader('SYFORS-KEY', '<?php echo $empleado["key"]; ?>')},
                async:false,                
                error:function(data){

                }                   
           
            },
            
            destroy: true,
            
            "columns": [
                           
                            { "data": "sale_id" },
				            { "data": "total" },
				            { "data": "abono" },
				            { "data": "cliente" }                          
            ],
            "language": {
                "url": "<?php echo base_url(); ?>js/Spanish.json"
            },
            "columnDefs": [
            {
            "render": function ( data, type, row ) {
                return  '<button class="btn btn-success btn-entregar" data-sale_id='+row.sale_id+'>'+row.sale_id+'</button><script>$(".btn-entregar").on("click",function(){var sale_id=$(this).attr("data-sale_id");$("#id_sale").val(sale_id);$("#cuenta").text(sale_id);$("#table tbody").html("");$("#tbody").html("");$.ajax({url:"<?php echo base_url().'index.php/abonos/productos'; ?>",type:"GET",dataType:"json",data:{sale_id:sale_id},async:false,success:function(data){if(data.name){	$("#tbody").append("<tr><td>"+data.name+"</td><td>"+data.quantity_purchased+"</td><td>$"+data.item_unit_price+"</td><td>"+data.comentarios+"</td></tr>");$("#btn-terminar data").attr(444);}else{data.map(function(a){var cantidad=parseFloat(a.quantity_purchased);cantidad=cantidad.toFixed(2);var precio=parseFloat(a.item_unit_price);precio=precio.toFixed(2);$("#table tbody").append("<tr><td>"+a.name+"</td><td>"+(cantidad)+"</td><td>$"+precio+"</td><td>"+a.comentarios+"</td></tr>");});}},error:function(data){}});$("#modalentregar").modal("show");});';
                },
            "targets": 4
            
            }
        ],
        });




		
		

	});
</script>