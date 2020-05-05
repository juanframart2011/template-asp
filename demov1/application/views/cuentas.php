

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width: 90%;">
    <div class="modal-content">
 <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
     <h4 class="modal-title" id="myModalLabel">Cuentas Abiertas <span> | </span><a href="<?= base_url()?>index.php/welcome/reportes">  Reportes de cuentas abiertas</a></h4>
      </div>
      <div class="modal-body">
    <div class="clear"></div>
<div class="text-center"> 
 <div class="table-responsive">
        <table id="register" class="table table-bordered">
  <thead>
    <tr>
      <th>Nombre del cliente</th>
      <th>Cuenta numero</th>
      <th>Abono</th>
      <th>Deuda</th>
      <th>Fecha</th>
      <th>Cantidad a abonar</th>
      <th>Total</th>
      <th>Abonar</th>
      <th>Entregado</th>

  
    
    </tr>
  </thead>
  <tbody id="sortable">


    <?php 
    if (empty($pedidos)):
          echo "<center><h1>no hay pedidos en la base de datos </h1></center>";

          
     
     else:
  foreach ($pedidos->result() as $pedido){
    ?>
    <tr>
    <td><?= $pedido->cliente ?></td>
<td><?= $pedido->sale_id ?></td>

<td><?php setlocale(LC_MONETARY, 'en_US');  echo money_format('%#10n', $pedido->abono). "\n";   ?></td>
<td><div class="form-check2" id="<?= $pedido->resto ?>"> <?php setlocale(LC_MONETARY, 'en_US');  echo money_format('%#10n', $pedido->resto). "\n";  ?></div></td>

  <td><?= $pedido->sale_time ?></td>

  <td style="width: 10% !important;"><div class="form-check"><input style="width: 90% !important;" alt="<?= $pedido->abono ?>"  placeholder="<?= $pedido->forma_pago?>" formenctype="<?= $pedido->cliente ?>"   type="text" name="<?= $pedido->resto ?>"  class="<?= $pedido->sale_id ?>" ></div></td>
  <td><?php $a = $pedido->abono; 
            $b = $pedido->resto;
            $total = $a + $b;
            echo $total; ?></td>
  <td><div class="abonar"><button  class="<?php echo $pedido->sale_id; ?>" formenctype="<?= $pedido->cliente ?>"  type="text" name="<?= $pedido->resto ?>" id="<?php $a = $pedido->abono; 
            $b = $pedido->resto;
            $total = $a + $b;
            echo $total; ?>" alt="<?= $pedido->abono ?>" >Abonar</button></div></td>
  <td><div class="entregado"><input type="checkbox" class="<?= $pedido->resto ?>" placeholder="<?= $pedido->abono ?>" id="<?php echo $pedido->sale_id; ?>" <?php echo $pedido->entregado; ?>></div></td>
    </tr>
  <?php
  }

  endif;


     ?>
      


  </tbody>
</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

$(document).ready(function(){
    $('div.abonar > button').click(function(event) {
      clase = $(this).attr('class');
   
  
         x =  $('input:text.'+clase).val();
       check =  $('div.form-check>input:text').val();
       console.log(check);
        if (check ==0) {
          alert('favor de ingresar cantidad a abonar');
          return false;
        }else{
        sale_id= clase;
        // id_pedido=$(this).attr('class');
        resto=$(this).attr('name')-(x);
        resto2 = x;
        abono = $(this).attr('alt');
      //  tipop= ($(this).attr('formenctype')) + $(this).attr('placeholder')+':'+resto2+'</br>';
       total =parseInt(resto2)+parseInt(abono);

       costo =(resto2);
        cliente = $(this).attr('formenctype');
       denegar = parseInt(abono) + parseInt(x);
       total2 = $(this).attr('id');
       console.log(denegar)
       console.log(total2);
   //     alert(resto);
      
     // alert(sale_id+" "+resto+" "+id_pedido);
        
 if (denegar>total2 ) {
  $('#sortable').append("<div style='position: absolute; left: 25%; top: 80px; z-index: 3;' class='alert alert-danger alert-dismissable'><a style='right: -8px !important; ' href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Advertencia!</strong>El total a de la cuenta "+sale_id+", es menor a la cantidad que estas abonando por favor verifica el campo abono</div>");
  console.log('nada :v');
  return false;
 }else{
  $.ajax({url:"<?php echo base_url().'index.php/welcome/abonar'; ?>",type:'POST',data:{sale_id:sale_id,resto:resto,total:total,cliente:cliente,costo:costo},success:function(data){
        //    alert(sale_id+" "+resto);
 
   console.log('total:'+total);
   console.log('sale_id:'+sale_id);
          location.reload();
  
          }});


   console.log('resto:'+resto);

   console.log('cliente:'+cliente);


    

 //  console.log('tipo:'+tipop);
 }
}
    });

   


});




</script>
<script>

   $(document).ready(function(){
    $('div.entregado > input:checkbox').change(function () {
    if ($(this).is(":checked")) {
        
    
        resto=$(this).attr('class');
        abono=$(this).attr('placeholder');  
        total = parseInt(resto) + parseInt(abono);

        sale_id=$(this).attr('id');
        
         entregado ='checked';
          
     // alert(sale_id+" "+estado+" "+id_pedido);
        if(sale_id!="" && resto==0){

           $.ajax({url:"<?php echo base_url().'index.php/welcome/status'; ?>",type:'POST',data:{sale_id:sale_id,entregado:entregado},success:function(data){
              console.log(entregado);
              location.reload();

          }});
                   console.log(total);
    
        }else{


        


         $('#sortable').append("<div style='position: absolute; left: 25%; top: 80px; z-index: 3;' class='alert alert-danger alert-dismissable'><a style='right: -8px !important; ' href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Advertencia!</strong>No se ah pagado el total de la cuenta "+sale_id+", por lo tanto no desaparecera de esta lista hasta que no se salde la cuenta</div>");
         sale_id=$(this).attr('id');

        }
}else{
        
        
         estado ='checked';
     // alert(sale_id+" "+estado+" "+id_pedido);
        if(sale_id!=""){

             $.ajax({url:"<?php echo base_url().'index.php/welcome/status'; ?>",type:'POST',data:{sale_id:sale_id,entregado:entregado},success:function(data){
              location.reload();

          }});

        }else{

        


         $("#mens").html("No deje campos vacíos");

        }
  } 
     });


});
    

   </script>
<script>
 
</script>
    </div>
  </div>
</div>

