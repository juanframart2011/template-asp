<div class="row">
	<div class="alert alert-info" role="alert">
  <strong>Lista de cuentas abiertas.</strong> 
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



<!--
<div class="alert alert-info" role="alert">
  <strong>Lista de cuentas abiertas.</strong> 
</div>

<div class="row" id="lista">
	<table class="table table-responsive" id="rep">
		<thead>
			<tr>
				<td>Id venta</td>
				<td>Fecha</td>
				<td>Cliente</td>
				<td>Abono</td>
				<td>Resto</td>
				<td>Total</td>
				<td>Abonar</td>
				
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>

</div>
-->


<div class="row">
	<div class="alert alert-info" role="alert">
  <strong>Pedidos pagados y terminados.</strong> 
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



<!--
<br><br>
<div class="alert alert-info" role="alert">
  <strong>Pedidos terminados y pagados.</strong> 
</div>
<div class="row">
	<table class="table responsive" id="entregos">
		<thead>
			<tr>
				<td>Id venta</td>
				<td>Total</td>
				<td>Abonos</td>
				<td>Cliente</td>
				<td>Entregar</td>
			</tr>
		</thead>
	</table>
</div>
-->


<div class="row">
	<div class="alert alert-info" role="alert">
  <strong>Pedidos pagados y no terminados.</strong> 
</div>
	<div class="col-md-12">
		<table id="cuentas_pagadas_no_terminadas" class="display" cellspacing="0" width="100%">
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


<!--
<div class="alert alert-info" role="alert">
  <strong>Pedidos pagados y no terminados.</strong> 
</div>
<div class="row">
	<table class="table responsive" id="pagados2">
		<thead>
			<tr>
				<td>Id venta</td>
				<td>Total</td>
				<td>Abonos</td>
				<td>Cliente</td>
				<td>Entregar</td>
			</tr>
		</thead>
	</table>
</div>
-->


<div class="row">
	<div class="alert alert-info" role="alert">
  <strong>Pedidos entregados.</strong> 
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
/*
		$.ajax({
			url:"<?php echo base_url().'index.php/abonos/lista_cuentas'; ?>",
			type:"GET",
			dataType:"json",
			async:false,
			success:function(data){
				
					console.log(data);
					if(data.sale_id){
							$("#rep tbody").append("<tr><td>"+data.sale_id+"</td><td>"+data.fecha+"</td><td>"+data.cliente+"</td><td>$"+data.total_abono+"</td><td>$"+data.resto+"</td><td>$"+data.total+"</td><td><button class='info btn' data-sale_id="+data.sale_id+">"+data.sale_id+"</button></td></tr>");
					}else{
						data.map(function(a){
							$("#rep tbody").append("<tr><td>"+a.sale_id+"</td><td>"+a.fecha+"</td><td>"+a.cliente+"</td><td>$"+a.total_abono+"</td><td>$"+a.resto+"</td><td>$"+a.total+"</td><td><button class='info btn' data-sale_id="+a.sale_id+">"+a.sale_id+"</button></td>");
						});
					}
					


				
				$(".info").on("click",function(){
						
						$("#tbodyproductos").html("");
						$("#exampleModalLong").modal('show');
						var sale_id=$(this).attr('data-sale_id');
						$("#btn_abonar").attr("data-sale_id",sale_id);
						$("#id_cuenta").text(sale_id);
						$("#imprimir").attr("href","index.php/abonos/imprimir_abono/"+sale_id);
						$("#lista_abonos").html('');
						$("#lista_abonos").append("<div class='col-md-4'>Abono</div><div class='col-md-4'>Fecha</div><div class='col-md-4'>Forma de pago</div>");



					$.ajax({
						url:"<?php echo base_url().'index.php/abonos/productos'; ?>",
						type:"GET",
						dataType:"json",
						data:{sale_id:sale_id},
						async:false,
						success:function(data){
							if(data.name)
							{
								$("#tbodyproductos").append("<tr><td>"+data.name+"</td><td>"+data.quantity_purchased+"</td><td>$"+data.item_unit_price+"</td><td>"+data.comentarios+"</td></tr>");
								
							}else{
								data.map(function(a){
									$("#tbodyproductos").append("<tr><td>"+a.name+"</td><td>"+a.quantity_purchased+"</td><td>$"+a.item_unit_price+"</td><td>"+a.comentarios+"</td></tr>");
								});
							}
							
							
						},
						error:function(data){

						}
					});




						//Obtener el abono 
						$.ajax({
							url:"<?php echo base_url().'index.php/abonos/lista_cuentas'; ?>",
							type:"GET",
							dataType:"json",
							data:{sale_id:sale_id},
							async:false,
							success:function(data){
								$("#resto").text("$"+data.resto);
								$("#abono_final").val(data.resto);
								$("#total_cuenta").text(data.total);
							},
							error:function(data){

							}
						});


						$.ajax({
							url: "<?php echo base_url().'index.php/abonos/lista_abonos'; ?>",
							type:"GET",
							dataType:"json",
							data:{sale_id:sale_id},
							async:false,
							success:function(data){

								if(data.sale_id){
									$("#lista_abonos").append("<div class='col-md-4'>$"+data.abono+"</div><div class='col-md-4'>"+data.fecha+"</div><div class='col-md-4'>"+data.forma_pago+"</div>");
								}else{
									data.map(function(a){
									$("#lista_abonos").append("<div class='col-md-4'>$"+a.abono+"</div><div class='col-md-4'>"+a.fecha+"</div><div class='col-md-4'>"+a.forma_pago+"</div>");
									});
								}
								
								
							},
							error:function(){

							}
						});


						

				});	
			},
			error:function(data){

			}
		});

*/
		$("#btn_abonar").on("click",function(){

			
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
								error:function(){
								
								}
							});

							
							$("#exampleModalLong").modal('hide');
							$(this).prop('disabled',false);
							window.location.href ="<?php echo base_url(); ?>index.php/abonos/imprimir_abono/"+sale_id;
							//location.reload();
		});

/*
		$.ajax({
			url:"<?php echo base_url().'index.php/abonos/cuentas_terminadas'; ?>",
			type:"GET",
			dataType:"json",
			async:false,
			success:function(data){
				console.log(data);
				data.map(function(a){
					$("#entregos").append("<tr><td>"+a.sale_id+"</td><td>$"+a.total+"</td><td>$"+a.abono+"</td><td>"+a.cliente+"</td><td><button class='btn btn-success btn-entregar' data-sale_id="+a.sale_id+">"+a.sale_id+"</button></td></tr>");
				});

				$(".btn-entregar").on("click",function(){
					var sale_id=$(this).attr("data-sale_id");
					$("#id_sale").val(sale_id);
					//$("#btn-terminar").append("data-sale_id"+sale_id);

					$("#cuenta").text(sale_id);
					$("#table tbody").html('');
					$("#tbody").html('');
					
      				$.ajax({
						url:"<?php echo base_url().'index.php/abonos/productos'; ?>",
						type:"GET",
						dataType:"json",
						data:{sale_id:sale_id},
						async:false,
						success:function(data){
							if(data.name)
							{
								$("#tbody").append("<tr><td>"+data.name+"</td><td>"+data.quantity_purchased+"</td><td>$"+data.item_unit_price+"</td><td>"+data.comentarios+"</td></tr>");
								$("#btn-terminar data").attr(444);
							}else{
								data.map(function(a){
								var cantidad=parseFloat(a.quantity_purchased);
								cantidad=cantidad.toFixed(2);
								var precio=parseFloat(a.item_unit_price);
								precio=precio.toFixed(2);
								
								$("#table tbody").append("<tr><td>"+a.name+"</td><td>"+(cantidad)+"</td><td>$"+precio+"</td><td>"+a.comentarios+"</td></tr>");
								});
							}
							
							
						},
						error:function(data){

						}
					});

      				

					
					$("#modalentregar").modal('show');


				});

			},
			error:function(){

			}
		});


		$.ajax({
			url:"<?php echo base_url().'index.php/abonos/cta_pagada_no_ter'; ?>",
			type:"GET",
			dataType:"json",
			async:false,
			success:function(data){
				console.log(data);
				data.map(function(a){
					$("#pagados2").append("<tr><td>"+a.sale_id+"</td><td>$"+a.total+"</td><td>$"+a.abono+"</td><td>"+a.cliente+"</td><td><button class='btn btn-success btn-entregar' data-sale_id="+a.sale_id+">"+a.sale_id+"</button></td></tr>");
				});

				$(".btn-entregar").on("click",function(){
					var sale_id=$(this).attr("data-sale_id");
					$("#id_sale").val(sale_id);
					//$("#btn-terminar").append("data-sale_id"+sale_id);

					$("#cuenta").text(sale_id);
					$("#table tbody").html('');
					$("#tbody").html('');
					
      				$.ajax({
						url:"<?php echo base_url().'index.php/abonos/productos'; ?>",
						type:"GET",
						dataType:"json",
						data:{sale_id:sale_id},
						async:false,
						success:function(data){
							if(data.name)
							{
								$("#tbody").append("<tr><td>"+data.name+"</td><td>"+data.quantity_purchased+"</td><td>$"+data.item_unit_price+"</td><td>"+data.comentarios+"</td></tr>");
								$("#btn-terminar data").attr(444);
							}else{
								data.map(function(a){
								var cantidad=parseFloat(a.quantity_purchased);
								cantidad=cantidad.toFixed(2);
								var precio=parseFloat(a.item_unit_price);
								precio=precio.toFixed(2);
								
								$("#table tbody").append("<tr><td>"+a.name+"</td><td>"+(cantidad)+"</td><td>$"+precio+"</td><td>"+a.comentarios+"</td></tr>");
								});
							}
							
							
						},
						error:function(data){

						}
					});

      				

					
					$("#modalentregar").modal('show');


				});

			},
			error:function(){

			}
		});

*/

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



        //Datatable cuentas pagadas y no  terminadas
		$("#cuentas_pagadas_no_terminadas").DataTable({
            "ajax": {
                url:"<?php echo base_url(); ?>index.php/abonos/cta_pagada_no_ter",
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
                return  '<button class="btn btn-success btn-entregar" data-sale_id='+row.sale_id+'>'+row.sale_id+'</button><script>$(".btn-entregar").on("click",function(){var sale_id=$(this).attr("data-sale_id");$("#id_sale").val(sale_id);$("#cuenta").text(sale_id);$("#table tbody").html("");$("#tbody").html("");$.ajax({url:"<?php echo base_url().'index.php/abonos/productos'; ?>",type:"GET",dataType:"json",data:{sale_id:sale_id},async:false,success:function(data){if(data.name){$("#tbody").append("<tr><td>"+data.name+"</td><td>"+data.quantity_purchased+"</td><td>$"+data.item_unit_price+"</td><td>"+data.comentarios+"</td></tr>");$("#btn-terminar data").attr(444);}else{data.map(function(a){var cantidad=parseFloat(a.quantity_purchased);cantidad=cantidad.toFixed(2);var precio=parseFloat(a.item_unit_price);precio=precio.toFixed(2);$("#table tbody").append("<tr><td>"+a.name+"</td><td>"+(cantidad)+"</td><td>$"+precio+"</td><td>"+a.comentarios+"</td></tr>");});}},error:function(data){}});$("#modalentregar").modal("show");});';
                },
            "targets": 4
            
            }
        ],
        });


		
		

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