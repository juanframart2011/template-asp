<style type="text/css">
	.modal-backdrop{
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 1030;
  background-color: #333333;
  opacity:0.8; 
}
</style>

<div class="row">
	<div class="alert alert-info" role="alert">
  	<strong>Buscar abonos de una cuenta.</strong> 
</div>
<div class="col-md-12">
	<div class="col-md-12">
		<label>Escribe el número de la venta</label>
		<input type="text" name="sale_id" id="sale_id">
		<button id="buscar"	class="btn btn-success">Buscar</button>
	</div>
</div>

	<div class="col-md-6">
	<table class="table table-responsive">
		<thead>
			<tr>
				<th>Fecha</th>
				<th>Abono</th>
				<th>Editar abono</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
		

	</table>
	</div>
</div>

<div id="modal" class="modal fade" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modificar abono</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="tablamodal">
        	<thead>
        		<tr>
        			<td>Fecha</td>
        			<td>Abono</td>
        		</tr>
        	</thead>
        	<tbody>
        		
        	</tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#deleteConfirmation">
         Delete
      </button>
      <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addContact">
         Add New Contact
      </button>
    </div>
  </div>


<!-- Modal 1 -->
<div class="modal fade" id="deleteConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete</h4>
      </div>
      <div class="modal-body">
        <h5>Are you sure you want to delete this contact?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="deleteNo" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="deleteOk">Yes</button>
      </div>
    </div>
  </div>
</div>
  
<!-- Modal 2 -->
<div class="modal fade" id="addContact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New Contact</h4>
      </div>
      <div class="modal-body">
        <label>First Name </label><input> <br>
      <label>Last Name </label><input> <br>
      <label>Address </label><input> <br>
      <label>Phone Number </label><input> <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="addConfirm">Confirm</button>
      </div>
    </div>
  </div>
</div>
  
</div>  
	


<script type="text/javascript">
	$(function(){
		$('#modal').on('shown.bs.modal', function () {
	    $('#myInput').focus();

	});

		$('#modal').on('hidden.bs.modal', function(e) {
  $('#foma1')[0].reset()
})


	$("#buscar").on("click",function(e){
		e.preventDefault();
		$.ajax({
			url:"<?php echo base_url().'index.php/abonos/lista_abonos'; ?>",
			type:"GET",
			dataType:"json",
			data:{sale_id:$("#sale_id").val()},
			async:false,
			success:function(data){
				data.map(function(a){
					$("table tbody").append("<tr><td>"+a.fecha+"</td><td>$"+a.abono+"</td><td><button class='editar btn btn-info' data-fecha="+a.fecha+"  data-abono="+a.abono+" data-sale_id="+a.sale_id+" data-id_venta="+a.id_venta+">Editar</button></td></tr>");

				});
				$(".editar").on("click",function(){
					$("#tablamodal").modal("show");
						var abono=$(this).attr("data-abono");
						var id_venta=$(this).attr("data-id_venta");
						var fecha=$(this).attr("data-fecha");
						$("#tablamodal tbody").append("<tr><td>"+fecha+"</td><td>"+abono+"</td></tr>");
						$("#addContact").modal("show");
						
						return false;
					});
				
			},
			error:function(data){

			}      				
		});
	});

	



		$("#checkentregar").prop("checked",false);
		$("#abono").numeric();
		var cont=0;

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