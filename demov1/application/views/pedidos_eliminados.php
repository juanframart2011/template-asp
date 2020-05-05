<div id="content" class="clearfix ">

<div id="content-header" class="hidden-print">
<h4>Pedidos terminados.</h4>
<a href="<?php echo base_url(); ?>index.php/pedidos">
  <button id="" class="btn btn-info">Ir a Pedidos en producción.</button>
</a>

</div>



<div class="modal" tabindex="-1" role="dialog" id="modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Eliminar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿Deseas eliminar el pedido?<label id="lbpedido"></label></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn_eliminar">Eliminar pedido.</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>



<div id="breadcrumb" class="hidden-print">

  <a href="#"><i class="fa fa-home"></i>Pedidos terminados</a> 

</div>

<div class="clear"></div>

 <div class="table-responsive" style="margin-left: -150px">

        <table id="register" class="table table-bordered">

  <thead>
    <tr>
      <th>Id </th>
      <th>Cliente </th>
      <th>Comentarios</th>     
      <th>Producto</th>
      <th>Cantidad</th>
      <th>Fecha</th>      
      <th>Opciones</th>
      <!--
      <th>Subir Captura de pantalla</th>
    -->
      <th>Captura</th>
    </tr>
  </thead>

<style>

  

  .captura  img{
    width: 100%;
  }

  #foo img{
    width: 100%;
  }

</style>



    <?php 

    if (empty($pedidos)):
          echo "<center><h1>no hay pedidos en la base de datos </h1></center>";    

     else:

  foreach ($pedidos->result() as $pedido){
  //  id="pedido_<?= $dido->sale_id"

    ?>

       <tr  class="reali <?=$pedido->estado ?>">

  <td><?= $pedido->sale_id ?></td>
  <td><?= $pedido->cliente ?></td>
  <td style="width: 20%;"><?= $pedido->descripcion ?></td>
  
  <td><?= $pedido->name ?></td>
  <td><?= $pedido->cantidad ?></td>
  <td><?= $pedido->sale_time ?></td>
  
  <td class="text-center"><div class="form-check2" >
    <button class="terminar btn btn-success" data-id-sales-items="<?= $pedido->id_sales_items; ?>" data-item-id="<?= $pedido->item_id ?>" data-sale-id="<?= $pedido->sale_id ?>">Regresar pedido a prod.</button>
    <!--
    <button class="eliminar btn btn-danger" data-item-id="<?= $pedido->item_id ?>" data-sale-id="<?= $pedido->sale_id ?>">Eliminar.</button>
    -->

  </td>
<!--
   <td>
      <div style=" border: 1px dotted;display:<?php echo $pedido->display; ?>; " id="foo" class="imagen" style="width: 200px; height: 200px; " contentEditable="true"  ><br><br><br><br><br> <button style="" class="imagen btn btn-primary" title=""  value="<?php echo $pedido->item_id; ?>" id="<?php echo $pedido->sale_id; ?>" >Subir Captura de Pantalla</button></div><div class="fadebox"></div>
   </td>
-->
   <td><div class="captura"  style="width: 200px; height: 200px">   <?php echo '<img class="imagen" src="data:image/png;base64,'.$pedido->imagen.'" alt="" />'; ?> </div></td>
    </tr>

  <?php

  }

  endif;

     ?>

      
<style type="text/css">

  .comen{

  -webkit-transition: all 1s ease-in;

-moz-transition: all 1s ease-in;

-ms-transition: all 1s ease-in;

-o-transition: all 1s ease-in;

transition: all 1s ease-in;

    height: 150px;

overflow: auto !important;

width: 100%;

  }

  .realizado{
  color: #61f661 !important;
}



</style>

  </tbody>



</table>

</div>




</div>

<script type="text/javascript">
  $(function(){
  	var sale_id,item_id=0;
  	$(".eliminar").on("click",function(){
      var sale_id=$(this).attr('data-sale-id');
      var item_id=$(this).attr('data-item-id');
      $("#lbpedido").text(sale_id);
      $("#modal").modal('show');console.log(sale_id+'--'+item_id);

       $("#btn_eliminar").on("click",function(){
    	
    	$.ajax({
	        url:"<?php echo base_url(); ?>index.php/pedidos/delete",
	        type:"POST",
	        data:{sale_id:sale_id,item_id:item_id},
	        success:function(){
	          alert("Correctamente");
	          location.reload();
	        },
	        error:function(){
	          alert("Error");
	        }

      	});
    });

      
    });



    $(".terminar").on("click",function(){
      var sale_id=$(this).attr('data-sale-id');
      var item_id=$(this).attr('data-item-id');
      var id_sales_items=$(this).attr("data-id-sales-items");

      $.ajax({
        url:"<?php echo base_url(); ?>index.php/pedidos/regresa_a_produccion",
        type:"POST",
        data:{id_sales_items:id_sales_items,sale_id:sale_id,item_id:item_id},
        success:function(){
          alert("Correctamente");
          location.reload();
        },
        error:function(){
          alert("Error");
        }

      });


    });
  });
</script>