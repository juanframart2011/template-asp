
<style type="text/css">
  .totales{
     }
    .totales {
  background: #9bceef;
border-radius: 15px 15px 15px 15px;
width: 70px;
text-align: center;
height: 45px;
padding-top: 1%;
cursor: pointer;

  }
      .totales span:hover{

color: #fff;
  }
</style>
<div id="content" class="clearfix ">
    
<div id="content-header" class="hidden-print">

</div>
<div id="breadcrumb" class="hidden-print">
  <a href="<?= base_url()?>"><i class="fa fa-home"></i>Reportes de pedidos</a> 
</div>
<div id="breadcrumb" class="hidden-print">
  <label for="">Busqueda Por Fecha</label>
  <?= form_open('welcome/buscari'); ?>
  <div class="form-group">
      <label for="">Desde:
      <input type="date" name="fecha1" class="form-control"></label>
      <label for="">Hasta:
      <input type="date" name="fecha2" class="form-control"></label>
      <div class="">
      <input type="submit" class="btn btn-primary" value="Buscar">
      </div>
  </div>
  <?= form_close(); ?>
</div>
<div class="clear"></div>
<div class="text-center"> 
 <div class="table-responsive">
        <table id="register" class="table table-bordered">

          <thead>
            <tr>
              <th></th>
              <th>Cliente</th>
              <th class="item_name_heading">Numero de pedido</th>
              <th class="sales_item sales_items_number">Total</th>
              <th class="sales_stock">Deuda</th>
              <th class="sales_price">Fecha</th>
            </tr>
          </thead>
          <tbody id="cart_contents" class="sa">


    <?php 
    $sum = 0;
    if (empty($pedidos)):
          echo "<center><h1>no hay pedidos en la base de datos </h1></center>";

          
     
     else:
	foreach ($pedidos->result() as $pedido){
		?>
	  <tr>
    <td></td>
	  <td><a href="<?= base_url().'index.php/welcome/reporte/'.$pedido->sale_id ?>"><?= $pedido->cliente ?></a></td>
<td><?= $pedido->sale_id ?></td>

<td><?php setlocale(LC_MONETARY, 'en_US');  echo money_format('%#10n', $pedido->abono). "\n";  ?></td>
<td><div class="form-check2" id="<?= $pedido->resto ?>"> <?php setlocale(LC_MONETARY, 'en_US');  echo money_format('%#10n', $pedido->resto). "\n";  ?></div></td>

  <td><?= $pedido->fecha ?></td>


    </tr>

	<?php
	
//echo $pedido->total_pago;
  }

	endif;

     ?>
      


  </tbody>
</table>

</div>
<script type="text/javascript">

$(document).ready(function(){
    $('div.form-check > input:text').mouseout(function () {
 
    
        sale_id=$(this).attr('id');
         id_pedido=$(this).attr('class');
        resto=$(this).attr('name')-($(this).val());
        resto2 = $(this).val();
        abono = $(this).attr('alt');
        tipop= ($(this).attr('formenctype')) + $(this).attr('placeholder')+':'+resto2+'</br>';
       // =parseInt(resto2)+parseInt(abono);
        costo = resto+abono;

   //     alert(resto);
      
     // alert(sale_id+" "+resto+" "+id_pedido);
        
 if (resto2 =="" && resto2 =="" ) {
  console.log('nada :v');

 }else{
  $.ajax({url:"<?php echo base_url().'index.php/welcome/abonar'; ?>",type:'POST',data:{sale_id:sale_id,resto:resto,id_pedido:id_pedido,costo:costo,tipop:tipop},success:function(data){
        //    alert(sale_id+" "+resto);
   console.log('resto:'+resto);
  
   console.log('costo'+id_pedido);
          }});


   console.log('resto:'+resto);
  
   console.log('costo'+id_pedido);
   console.log('tipo:'+tipop);
 }
   
          
     });


});




</script>
<script>
  $('div.abonar > button').click(function() {
    location.reload();
});
</script>
<script type="text/javascript">
  $('.totales').click(function (argument) {
   $('html,body').animate({ scrollTop: 9999 }, 'slow');
  });
</script>
</body>
</html>