
    <?php 
    $total = 0;
     
  
    if (empty($pedidos)):
          echo "<center><h1>no hay pedidos en la base de datos </h1></center>";

          
     
     else:
  foreach ($pedidos->result() as $pedido){
    ?>
 <div id="totales"> <?php 

  $total = $total + $pedido->total_pago;  
  ?></h1></div>

  <?php
  

  }

  endif;

     ?>
<div class="col-md-6"> <h1>Ganancia Total: <span style="color:green;"><?php setlocale(LC_MONETARY, 'en_US');  echo money_format('%#10n', $total ). "\n"; ?></span></h1></div>
</div>