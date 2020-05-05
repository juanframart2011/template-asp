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
	<h3>Abonar.</h3>
  	<!--<strong>Lista de cuentas abiertas.</strong> -->
</div>
	<div class="col-md-12">
		<table id="cuentas" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Id venta</th>                
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Abono</th>
                <th>Resto</th>
                <th>Total</th>
                <th>Abonar</th>                
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Id venta</th>                
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Abono</th>
                <th>Resto</th>
                <th>Total</th>
                <th>Abonar</th>                
            </tr>
        </tfoot>
    </table>
	</div>
</div>




<!-- Modal -->
<div class="modal fade" tabindex="-1"  id="exampleModalLong" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cuenta: <label id="id_cuenta"></label></h5>
        
      </div>
      <div class="modal-body" style="background-color:#6ccdf3">
      		<div class="row" id="form">
      			<div class='col-md-1'>
      				<label>Resto:</label>
      			</div>
      			<div class='col-md-2'>
      				<input type="hidden" name="abono_final" id="abono_final">
      				<label id="resto" ></label>
      			</div>
      			<div class='col-md-2'>
      				<label>Abono:</label>
      			</div>
      			<div class='col-md-2'>
      				<input type="text" id="abono" name="abono" size="5" step="any" style="width: 70px;">
      			</div>
      			<div class="col-md-3" >
      				<select name="tipo_pago" id="tipo_pago" class="input-medium" style="width: 120px;">
						<option value="Efectivo" selected="selected">Efectivo</option>
						<option value="Cheque">Cheque</option>
						<option value="Tarjeta de Regalo">Tarjeta de Regalo</option>
						<option value="Tarjeta de Débito">Tarjeta de Débito</option>
						<option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
						<option value="Transferencia">Transferencia</option>
					</select>
      			</div>
      			<div class='col-md-2'>

      				<button class="btn btn-success" id="btn_abonar">Abonar</button>
      			</div>
      		</div>
      		<div class="row">
      			<div class="col-md-3">
      				<label>Total:$ </label>
      				<label id="total_cuenta"></label>
      			</div>
      			<div class="col-md-3">
      				<label>Entregar: </label>
      				<input type="checkbox" id="checkentregar" >
      			</div>
      			
      		</div>
      		<div class="row" style="padding-top: 40px;"></div>
        	<div class="row" id="lista_abonos">
        		<div class='col-md-4'></div><div class='col-md-4'></div><div class='col-md-4'></div>
        	</div>

        	<div class="row" style="padding-top: 40px;"></div>
        	<div class="row" id="">
      			<table class="table" id="table">
      				<thead>
      					<th>Producto</th>	      				
	      				<th>Cantidad</th>
	      				<th>Precio <label style="color:red">(SIN IVA)</label></th>
	      				<th>Descripcion</th>
      				</thead>
      				<tbody id="tbodyproductos">
      					
      				</tbody>
      				
      			</table>
      			
      		</div>


      </div>
      <div class="modal-footer">
        <a id="imprimir" href="" > <button class="btn btn-info" >Imprimir abonos</button></a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
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

		$("#btn_abonar").on("click",function(){
      $(this).prop("disabled",true);
			
							var sale_id=$(this).attr('data-sale_id');
							if(cont>=1)
							{
								return false;
							}
						    cont++;
							$(this).prop('disabled',true);
							var abono=$("#abono").val();
							if(abono<=0){
								alert("Cantidad incorrecta.");
								$(this).prop('disabled',false);
								location.reload();
								return false;
							}
							var abono_final=parseFloat($("#abono_final").val());
							
							
							if(abono>abono_final)
							{
								alert("No puedes abonar mas de lo que te deben.");
								$(this).prop('disabled',false);
								location.reload();
								return false;
							}


							var tipo_pago=$("#tipo_pago").val();
							$.ajax({
								url: "<?php echo base_url().'index.php/abonos/add_abono'; ?>",
								type:"POST",
								dataType:"json",
								data:{sale_id:sale_id,abono:abono,tipo_pago:tipo_pago},
								async:false,
								success:function(data){
									alert("Haz abonado con éxito.");



							$.ajax({
								url: "<?php echo base_url().'index.php/abonos/saldo'; ?>",
								type:"GET",
								dataType:"json",
								data:{sale_id:sale_id},
								async:false,
								success:function(data){
									
/*
									if( $('.micheckbox').attr('checked') ) {
									    alert('Seleccionado');
									}
*/

									if(data.saldo!=0 && $('#checkentregar').prop('checked')){
										alert("No puedes entregar.Aún no se ha liquidado la cuenta.");

									}

									if(data.saldo==0 && $('#checkentregar').prop('checked')){
										

									$.ajax({
										url:"<?php echo base_url().'index.php/abonos/entregar'; ?>",
										type:"GET",
										dataType:"json",
										data:{sale_id:sale_id},
										async:false,
										success:function(data){
											if(data!=0){
												alert("Entregado Correctamente");
												//location.reload();
											}else{
												alert("Intentalo de nuevo.");
											}
										},
										error:function(data){

										}      				
						      		});


									}


								},
								error:function(){
								
								}
							});


								},
                complete:function(){
                  $(this).prop("disabled",false);
                },
								error:function(){
								
								}
							});

							
							$("#exampleModalLong").modal('hide');
							$(this).prop('disabled',false);
							window.location.href ="<?php echo base_url(); ?>index.php/abonos/imprimir_abono/"+sale_id;
							//location.reload();
		});



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


		$("#cuentas").DataTable({
            "ajax": {
                url:"<?php echo base_url(); ?>index.php/abonos/lista_cuentas",
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
				            { "data": "fecha" },
				            { "data": "cliente" },
				            { "data": "total_abono" },
				            { "data": "resto" },
				            { "data": "total"}                            
            ],
            "language": {
                "url": "<?php echo base_url(); ?>js/Spanish.json"
            },
            "columnDefs": [
            {
            "render": function ( data, type, row ) {
                return  '<button class="btn btn-success info" data-sale_id='+row.sale_id+'>'+row.sale_id+'</button><script>$(".info").on("click",function(){$("#tbodyproductos").html("");$("#exampleModalLong").modal("show");var sale_id=$(this).attr("data-sale_id");$("#btn_abonar").attr("data-sale_id",sale_id);$("#id_cuenta").text(sale_id);$("#imprimir").attr("href","index.php/abonos/imprimir_abono/"+sale_id);$("#lista_abonos").html("");$("#lista_abonos").append("<div class=col-md-4>Abono</div><div class=col-md-4>Fecha</div><div class=col-md-4>Forma de pago</div>");$.ajax({url:"<?php echo base_url().'index.php/abonos/productos'; ?>",type:"GET",dataType:"json",data:{sale_id:sale_id},async:false,success:function(data){if(data.name){$("#tbodyproductos").append("<tr><td>"+data.name+"</td><td>"+data.quantity_purchased+"</td><td>$"+data.item_unit_price+"</td><td>"+data.comentarios+"</td></tr>");}else{data.map(function(a){$("#tbodyproductos").append("<tr><td>"+a.name+"</td><td>"+a.quantity_purchased+"</td><td>$"+a.item_unit_price+"</td><td>"+a.comentarios+"</td></tr>");});}},error:function(data){}});$.ajax({url:"<?php echo base_url().'index.php/abonos/lista_cuentas'; ?>",type:"GET",dataType:"json",data:{sale_id:sale_id},async:false,success:function(data){$("#resto").text("$"+data.resto);$("#abono_final").val(data.resto);$("#total_cuenta").text(data.total);},error:function(data){}});$.ajax({url: "<?php echo base_url().'index.php/abonos/lista_abonos'; ?>",type:"GET",dataType:"json",		data:{sale_id:sale_id},	async:false,                               		success:function(data){if(data.sale_id){$("#lista_abonos").append("<div class=col-md-4>$"+data.abono+"</div><div class=col-md-4>"+data.fecha+"</div><div class=col-md-4>"+data.forma_pago+"</div>");}else{data.map(function(a){$("#lista_abonos").append("<div class=col-md-4>$"+a.abono+"</div><div class=col-md-4>"+a.fecha+"</div><div class=col-md-4>"+a.forma_pago+"</div>");});}                },error:function(data){}});});';
                },
            "targets": 6
            
            }
        ],
        });


		
		

	});
</script>