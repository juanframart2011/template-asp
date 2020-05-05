<div id="content" class="clearfix ">

<div id="content-header" class="hidden-print">
<h4>Lista de pedidos.</h4>
<a href="<?php echo base_url(); ?>index.php/pedidos/eliminados">
  <button id="" class="btn btn-info">Ir a Pedidos terminados.</button>
</a>

</div>

<div id="breadcrumb" class="hidden-print">

  <a href="#"><i class="fa fa-home"></i>Pedidos</a> 

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
      <th>Eliminar de la lista</th>
      <th>Subir Captura de pantalla</th>
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
  <td style="width: 20%;">
    <form>
    <textarea name="descripcion" id="id<?= $pedido->id_sales_items ?>sal<?= $pedido->sale_id ?>ite<?= $pedido->item_id ?>"  data-id-sales-items="<?= $pedido->id_sales_items ?>" data-item-id="<?= $pedido->item_id ?>" data-sale-id="<?= $pedido->sale_id ?>" rows="7">
      <?= $pedido->descripcion ?>
    </textarea>
  
    <button class="cambiar-descripcion btn btn-success" data-id-sales-items="<?= $pedido->id_sales_items; ?>" data-item-id="<?= $pedido->item_id ?>" data-sale-id="<?= $pedido->sale_id ?>">Cambiar Descr.</button>

    </form>
      
  </td>
  
  <td><?= $pedido->name ?></td>
  <td><?= $pedido->cantidad ?></td>
  <td><?= $pedido->sale_time ?></td>
  
  <td class="text-center"><div class="form-check2" >
    <button class="btn terminar btn-success" data-id-sales-items="<?= $pedido->id_sales_items; ?>" data-item-id="<?= $pedido->item_id ?>" data-sale-id="<?= $pedido->sale_id ?>">Terminar</button>


  </td>
   <td><div style=" border: 1px dotted;display:<?php echo $pedido->display; ?>; " id="foo" class="imagen" style="width: 200px; height: 200px; " contentEditable="true"  ><br><br><br><br><br> <button style="" class="imagen btn btn-primary" title=""  value="<?php echo $pedido->item_id; ?>" id="<?php echo $pedido->sale_id; ?>" >Subir Captura de Pantalla</button></div><div class="fadebox"></div></td>
   <td><div class="captura"  style="width: 200px; height: 200px">   <?php echo '<img class="imagen" src="data:image/png;base64,'.$pedido->imagen.'" alt="" />'; ?> </div></td>
    </tr>

  <?php

  }

  endif;

     ?>

      


  </tbody>



</table>

</div>


    
   


</div>

<script type="text/javascript">
  $(function(){

      $(".cambiar-descripcion").on("click",function(){
        var sale_id=$(this).attr("data-sale-id");
        var item_id=$(this).attr("data-item-id");
        var id_sales_items=$(this).attr("data-id-sales-items");
        var descripcion=$("#id"+id_sales_items+"sal"+sale_id+"ite"+item_id).val();
        console.log(sale_id+' '+item_id+descripcion+' '+id_sales_items);

        $.ajax({
        url:"<?php echo base_url(); ?>index.php/pedidos/descripcion",
        type:"POST",
        data:{id_sales_items:id_sales_items, sale_id:sale_id,item_id:item_id,descripcion:descripcion},
        success:function(data){
          console.log("data");
          console.log(data);
          alert("Descripcion guardada correctamente");
          location.reload();
        },
        error:function(){
          alert("Error");
        }

      });

        return false;
      });


    $(".terminar").on("click",function(){
      var sale_id=$(this).attr('data-sale-id');
      var item_id=$(this).attr('data-item-id');
      var id_sales_items=$(this).attr("data-id-sales-items");
  

      $.ajax({
        url:"<?php echo base_url(); ?>index.php/pedidos/terminar",
        type:"POST",
        data:{id_sales_items:id_sales_items, sale_id:sale_id,item_id:item_id},
        success:function(){
          alert("Correctamente");
          window.location.href = "<?php echo base_url(); ?>index.php/pedidos/eliminados";
        },
        error:function(){
          alert("Error");
        }

      });


    });
  });
</script>


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

<script>

  $(document).ready(function(){



    $('div.imagen > button').click(function(event) {

      clase = $(this).attr('class');

          

      

            //  x =  $('input:text.'+clase).val();

      x =  $('div.imagen > img').attr('src');



      patron ="data:image/png;base64,";

      nuevoValor ="";

      id = $(this).attr('id');

      item_id = $(this).attr('value');

      img = x.replace(patron, nuevoValor);

      displ = 'none;';

      edita = 'false';

           // nombre = $('div.imagen > input:text').val(x);

     console.log(id);

     console.log(img);

       $.ajax({url:"<?php echo base_url().'index.php/pedidos/imagen'; ?>",type:'POST',data:{id:id,img:img,item_id:item_id,displ:displ},success:function(data){

        

 location.reload();



  

          }});





       });



     });

</script>

<style type="text/css">

    .vergrande{

      display: none;

      position: absolute;

      top: 1%;

      left: 15%;

      width: 20%;

      height: 25%;

      z-index: 1002;

      overflow: auto;

      width: 74% !important;



    }

    [contentEditable=true]:empty:not(:focus):before{

        content:attr(data-text)

    }

    .fadebox{

      display: none;

      position: absolute;

      top: 0%;

      left: 0%;

      width: 100%;

      height: 100%;

      background-color: #0003;

      z-index: 1001;

      -moz-opacity: 0.8;

      opacity: .80;

      filter: alpha(opacity=80);

    }



</style>

<script type="text/javascript">

    $(document).ready(function(){

      $("#register").removeData();


    $('div.captura > img').click(function(event) {

        

          $(this).css('display','block');

          $(this).toggleClass('vergrande');

          $(document).scrollTop(0);

          if ($('.fadebox').css('display') == 'none')

            $('.fadebox').css('display','block');

          else

            $('.fadebox').css('display','none');

         });

     });

</script>