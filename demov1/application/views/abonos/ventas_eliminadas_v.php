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
  <h3>Ventas eliminadas.</h3>
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
                <th>Detalles</th>                
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
                <th>Detalles</th>                
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
           <label>Detalles de la venta eliminada.</label>
            
          </div>
          
          
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
                url:"<?php echo base_url(); ?>index.php/abonos/cuentas_elim_get",
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
                return  '<button class="btn btn-success info" data-sale_id='+row.sale_id+'>'+row.sale_id+'</button><script>$(".info").on("click",function(){$("#tbodyproductos").html("");$("#exampleModalLong").modal("show");var sale_id=$(this).attr("data-sale_id");$("#btn_abonar").attr("data-sale_id",sale_id);$("#id_cuenta").text(sale_id);$("#imprimir").attr("href","index.php/abonos/imprimir_abono/"+sale_id);$("#lista_abonos").html("");$.ajax({url:"<?php echo base_url().'index.php/abonos/productos_eliminados'; ?>",type:"GET",dataType:"json",data:{sale_id:sale_id},async:false,success:function(data){if(data.name){$("#tbodyproductos").append("<tr><td>"+data.name+"</td><td>"+data.quantity_purchased+"</td><td>$"+data.item_unit_price+"</td><td>"+data.comentarios+"</td></tr>");}else{data.map(function(a){$("#tbodyproductos").append("<tr><td>"+a.name+"</td><td>"+a.quantity_purchased+"</td><td>$"+a.item_unit_price+"</td><td>"+a.comentarios+"</td></tr>");});}},error:function(data){}});});';
                },
            "targets": 6
            
            }
        ],
        });


    
    

  });
</script>