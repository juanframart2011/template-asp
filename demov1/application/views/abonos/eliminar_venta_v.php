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
  		<h3>Eliminar venta.</h3>
	</div>
</div>
<div class="row">
	<div class="col-md-12" role="alert">
  		<label>Introduce el número de venta:</label>
  		<input type="text" name="sale_id" id="sale_id">
  		<button id="buscar_venta" class="btn btn-success">Buscar venta.</button>
	</div>
</div>
<div class="row">
	<div class="col-md-2" role="alert">
  		<label>Id venta:</label>
  		<label id="id_venta" ></label>  		
	</div>
	<div class="col-md-2" role="alert">
  		<label>Total:</label>
  		<label id="total_venta" ></label>  		
	</div>
	<div class="col-md-2" role="alert">
  		<label>Total abono:</label>
  		<label id="total_abono" ></label>  		
	</div>
	<div class="col-md-2" role="alert">
  		<label>Resto:</label>
  		<label id="resto" ></label>  		
	</div>
	<div class="col-md-2" role="alert">
  		<label>Fecha:</label>
  		<label id="fecha_venta" ></label>  		
	</div>
	<div class="col-md-2" role="alert">
  		<label>Cliente:</label>
  		<label id="cliente_venta" ></label>  		
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<table id="example" class="table table-reponsive" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Descripcion</th>
                
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
	</div>


<button id="eliminar" class="btn btn-danger">Eliminar venta.</button>
<input type="hidden" id="sale_id_eliminar" name="sale_id_eliminar">
</div>


<!-- Modal -->
<div class="modal fade" tabindex="-1"  id="modal" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Eliminar venta.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color:#6ccdf3">
      		<label>Venta:</label>
      		<label id="modal_venta"></label>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-primary" id="terminar" data="">Eliminar</button>
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

$("#eliminar").hide();

	$("#buscar_venta").on("click",function(){

		$.ajax({
                url:"<?php echo base_url(); ?>index.php/abonos/lista_cuentas_elim",
                type:"GET",
                dataType:"json",
                data:{sale_id:$("#sale_id").val()},
                //async:false,
                beforeSend: function(xhr){
                xhr.setRequestHeader('SYFORS-KEY', '<?php echo $empleado["key"]; ?>')},
                async:false,
                success:function(data){
                	if(data.sale_id){
						$("#id_venta").text(data.sale_id);
	                	$("#total_venta").text(data.total);
	                	$("#total_abono").text(data.total_abono);
	                	$("#resto").text(data.resto);
	                	$("#fecha_venta").text(data.fecha);
	                	$("#cliente_venta").text(data.cliente);
	                	$("#sale_id_eliminar").val(data.sale_id);
	                	$("#eliminar").show();
                	}else{
                		$("#id_venta").text('');
	                	$("#total_venta").text('');
	                	$("#total_abono").text('');
	                	$("#resto").text('');
	                	$("#fecha_venta").text('');
	                	$("#cliente_venta").text('');
	                	$("#eliminar").hide();
                		alert("No existe la venta");
                	}
                	
                	
                },                
                error:function(data){

                }                   
           
            });

		$("tbody").html('');
		$.ajax({
                url:"<?php echo base_url(); ?>index.php/abonos/productos_elim",
                type:"GET",
                dataType:"json",
                data:{sale_id:$("#sale_id").val()},
                //async:false,
                beforeSend: function(xhr){
                xhr.setRequestHeader('SYFORS-KEY', '<?php echo $empleado["key"]; ?>')},
                async:false,
                success:function(data){
                	data.map(function(a){
                		$("tbody").append("<tr ><td >"+a.name+"</td><td align='center'>$"+a.item_unit_price+"</td><td align='center'>"+a.quantity_purchased+"</td><td align='center'>"+a.comentarios+"</td></tr>");
                	});
                	               	
                },                
                error:function(data){

                }                   
           
            });

        $("#sale_id").val('');
	});

	$("#eliminar").on("click",function(){
		$("#modal_venta").text($("#sale_id_eliminar").val());
		$("#modal").modal('show');
	});

	$("#terminar").on("click",function(){
		$.ajax({
                url:"<?php echo base_url(); ?>index.php/abonos/eliminar",
                type:"POST",
                dataType:"json",
                data:{sale_id:$("#sale_id_eliminar").val()},
                //async:false,
                beforeSend: function(xhr){
                xhr.setRequestHeader('SYFORS-KEY', '<?php echo $empleado["key"]; ?>')},
                async:false,
                success:function(data){
                	alert("Venta eliminada con éxito.");
                	$("#id_venta").text('');
	                $("#total_venta").text('');
	                $("#total_abono").text('');
	                $("#resto").text('');
	                $("#fecha_venta").text('');
	                $("#cliente_venta").text('');
	                $("#eliminar").hide();
	                $("tbody").html('');
	                $("sale_id_eliminar").val('');
                	$("#modal").modal("hide");
                },                
                error:function(data){
                	alert("No se puede eliminar la venta.Vuelve a intentarlo.");
                }                   
           
            });
	});
		


	});
</script>