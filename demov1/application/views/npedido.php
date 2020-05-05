<div id="content" class="clearfix ">
		
<div id="content-header" class="hidden-print">

</div>
<div id="breadcrumb" class="hidden-print">
	<a href="http://syfors.com/muestrapos2/index.php"><i class="fa fa-home"></i>Pedidos</a>	
</div>
<div class="clear"></div>
<div class="text-center">	

		<table class="table">
  <thead>
    <tr>
      <th>Producto</th>
      <th>Comentario</th>
      <th>Fecha</th>
      <th>Foto</th>
      <th></th>
    	
  </thead>	
	<tr>
	   <?= form_open_multipart(base_url()."index.php/nuevo_pedido/nuevo")?>
		<td><input type="text" name="producto"></td>
		<td><textarea name="comentario" id="" cols="30" rows="1"></textarea></td>
		<td><input type="date" name="fecha"></td>
		<td><input type="file" name="mi_archivo"></td>
		<td><input class="btn btn-primary" type="submit" value="Nuevo Pedido"></td>
		<?php form_close(); ?>
		<!--<buton class="color">color</buton>-->
    </tr>
    <script>
    	$('.color').click(function(argument) {
    		$(".color").animate({
			   color: "#f86",
			  'margin-right':'100px' 
			}, 500); 
			$(".color").addClass('pos');
			$(".pos").click(function(argument) {
				$(".color").animate({
			   color: "000",
			  'margin-right':'-100px' 
			}, 500); 
			$(".color").removeClass('pos');	
			});
    	});
    </script>
	</tr>
 </table>
 <div class="table-responsive">
				<table id="register" class="table table-bordered">

					<thead>
						<tr>
							<th></th>
							<th>Numero de pedido</th>
							<th class="item_name_heading">Producto</th>
							<th class="sales_item sales_items_number">Comentario</th>
							<th class="sales_stock">Fecha</th>
							<th class="sales_price">Foto</th>
							<th>Eliminar</th>
							<th>Taller</th>
							<th>Isla</th>
							<th>Entregado</th>
							
						
						</tr>
					</thead>
					<tbody id="cart_contents" class="sa">
					<?php
				    if (empty($pedidos)):
				          echo "<center><h1>no hay pedidos en la base de datos</h1></center>";
				          
				     
				     else:
				     
				        foreach ($pedidos->result() as $pedido) { 
				          ?>
					<tr id="reg_item_top" bgcolor="#eeeeee" class="contenedor">
					
						
				        <td style="width: 5%;"></td>		
						<td style="width: 10%; text-align: center;">
						<?= $pedido->id_pedido ?>         
				        </td>
				        <td style="width: 10%; text-align: center;">
						<?= $pedido->producto ?>         
				        </td>
				        <td>
						<?= $pedido->comentario ?>         
				        </td>
				        <td style="width: 10%; text-align: center;"> 
						<?= $pedido->fecha ?>         
				        </td>
				        <td style="width: 25%; text-align: center;">
						<img  style="width: 50%;" src="<?= base_url()?>uploads/<?= $pedido->foto?> " alt="">        
				        </td>
				       
				        <td style="text-align: center; width: 5%;"> <div class="contenedor2"><input type="checkbox" id="<?= $pedido->id_pedido ?>   " ></div>
				        </td>
				        <td style="text-align: center; width: 5%;" class="<?php echo $pedido->taller; ?>">  <div class="contenedor3  "><input type="checkbox" id="<?= $pedido->id_pedido ?>" <?php echo $pedido->taller; ?>    ></div>
				        </td>
				        <td style="text-align: center; width: 5%;"> <div class="contenedor4"><input type="checkbox" id="<?= $pedido->id_pedido ?>" <?php echo $pedido->isla; ?>  ></div>
				        </td>
				        <td style="text-align: center; width: 5%;"> <div class="contenedor5"><input type="checkbox" id="<?= $pedido->id_pedido ?>" <?php echo $pedido->entregado; ?>  ></div>
				        </td>
				               
						
					</tr>
					       <?php }
					                 endif;
					                ?>
					</tbody>

			</table>
			</div>

 </div>
 </div>
<script>

	$(document).ready(function() {
$("div.contenedor2 > input:checkbox").change(function(){
  
 
  //$("#FormSubmit").hide(); //hide submit button
  //$("#LoadingImage").show(); //show loading image   
   var checked =  "checked";
   var id_pedido = $(this).attr('id'); //build a post data structure
     $.ajax({url:"<?php echo base_url().'index.php/nuevo_pedido/ocultar'; ?>",type:'POST',data:{id_pedido:id_pedido,checked:checked},success:function(data){
     		  // $("#reg_item_top").append(response);
     		   $('#reg_item_top').html(data); 
     		  console.log('bien');
     }


   
});
});

});

	

</script>
<script>
	$(document).ready(function() {
	$("div.contenedor3 > input:checkbox").change(function(){
  
     if ($(this).is(":checked")) {
  //$("#FormSubmit").hide(); //hide submit button
  //$("#LoadingImage").show(); //show loading image   

   var taller =  "checked";
   var id_pedido = $(this).attr('id'); //build a post data structure
     $.ajax({url:"<?php echo base_url().'index.php/nuevo_pedido/taller'; ?>",type:'POST',data:{id_pedido:id_pedido,taller:taller},success:function(data){
     		  // $("#reg_item_top").append(response);
     		   //$('#reg_item_top').html(data); 
     		  console.log('bien');
     }});
 }else{
 	   var taller =  " ";
   var id_pedido = $(this).attr('id'); //build a post data structure
     $.ajax({url:"<?php echo base_url().'index.php/nuevo_pedido/taller'; ?>",type:'POST',data:{id_pedido:id_pedido,taller:taller},success:function(data){
     		  // $("#reg_item_top").append(response);
     		   //$('#reg_item_top').html(data); 
     		  console.log('bien');
     }});
 }
	});
});
</script>
<script>
	$(document).ready(function() {
	$("div.contenedor4 > input:checkbox").change(function(){
  
     if ($(this).is(":checked")) {
  //$("#FormSubmit").hide(); //hide submit button
  //$("#LoadingImage").show(); //show loading image   

   var isla =  "checked";
   var id_pedido = $(this).attr('id'); //build a post data structure
     $.ajax({url:"<?php echo base_url().'index.php/nuevo_pedido/isla'; ?>",type:'POST',data:{id_pedido:id_pedido,isla:isla},success:function(data){
     		  // $("#reg_item_top").append(response);
     		   //$('#reg_item_top').html(data); 
     		  console.log('bien');
     }});
 }else{
 	   var isla =  " ";
   var id_pedido = $(this).attr('id'); //build a post data structure
     $.ajax({url:"<?php echo base_url().'index.php/nuevo_pedido/isla'; ?>",type:'POST',data:{id_pedido:id_pedido,isla:isla},success:function(data){
     		  // $("#reg_item_top").append(response);
     		   //$('#reg_item_top').html(data); 
     		  console.log('bien');
     }});
 }
	});
});
</script>
<script>
	$(document).ready(function() {
	$("div.contenedor5 > input:checkbox").change(function(){
  
     if ($(this).is(":checked")) {
  //$("#FormSubmit").hide(); //hide submit button
  //$("#LoadingImage").show(); //show loading image   

   var entregado =  "checked";
   var id_pedido = $(this).attr('id'); //build a post data structure
     $.ajax({url:"<?php echo base_url().'index.php/nuevo_pedido/entregado'; ?>",type:'POST',data:{id_pedido:id_pedido,entregado:entregado},success:function(data){
     		  // $("#reg_item_top").append(response);
     		   //$('#reg_item_top').html(data); 
     		  console.log('bien');
     }});
 }else{
 	   var entregado =  " ";
   var id_pedido = $(this).attr('id'); //build a post data structure
     $.ajax({url:"<?php echo base_url().'index.php/nuevo_pedido/entregado'; ?>",type:'POST',data:{id_pedido:id_pedido,entregado:entregado},success:function(data){
     		  // $("#reg_item_top").append(response);
     		   //$('#reg_item_top').html(data); 
     		  console.log('bien');
     }});
 }
	});
});
</script>

