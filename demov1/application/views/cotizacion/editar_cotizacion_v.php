<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.numeric.js"></script>
<style type="text/css">
	table, th, td {
    border: 1px solid #ddd;
}

	table{
		width: 100%;
	}
</style>

<div id="content-header" class="hidden-print sales_header_container">
	<h1 class="headigs"> <i class="icon fa fa-barcode"></i>
		Editar Cotización.<p><h3>Próximamente.</h3></p><span id="ajax-loader"><?php echo img(array('src' => base_url().'/img/ajax-loader.gif')); ?><br>
		</span>
		<div class="row">
			<div class="col-md-4">
				<label>Producto:</label>
				<input type="text" name="producto" id="producto">
			</div>
			<div class="col-md-4">
				<label>Cliente:</label>
				<input type="text" name="txtcliente" id="txtcliente">
				<label id="lbcliente"></label>
			</div>
			<div class="col-md-4">
				<input type="hidden" name="person_id" id="person_id">	
				<label>Comentarios:</label>
				<input type="text" name="comentarios" id="comentarios">
			</div>
			
		</div>
		
		
	</h1>
	<div class="content">
	<p><h3>Próximamente.......</h3></p>
	
	<table id="tabla">
		<thead>
			<tr>
				<th></th>
				<th>Nombre</th>
				<th>Precio por unidad</th>
				<th>Medidas</th>
				<th>Metros cuadrados</th>
				<th>Comentarios</th>
				<th>Cantidad</th>
				<th>Subtotal</th>
				
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
	<div>
		<label>Total: $</label>
		<label id="lbtotal"></label>
		<input type="hidden" name="total" id="total">
	</div>
	<div >
		<button id="guardar" class="btn btn-success">Guardar.</button></div>
	</div>
</div>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



<script type="text/javascript">
$(function(){
	
	
	
	var productos=[];
	var carrito=[];
	var total=0;
	var clientes=[];


	$.ajax({
		url:"index.php/cotizacion/productos",
		type:"GET",
		dataType:"json",
		data:{autocomplete:1},
		async:false,
		success:function(data){
			data.map(function(a){
				productos.push({"label":a.name,"value":a.item_id,"unit_price":parseFloat(a.precio),"cost_price":parseFloat(a.cost_price),"cantidad":1, "alto":1,"ancho":1,"metros_cuadrados":1,"subtotal":0,"comentario":""});
			});
			
		},
		error:function(data){

		}
	});

	$.ajax({
		url:"index.php/cotizacion/clientes",
		type:"GET",
		dataType:"json",
		data:{autocomplete:1},
		async:false,
		success:function(data){
			data.map(function(a){
				clientes.push({"label":a.nombre,"value":a.person_id});
			});
			
		},
		error:function(data){

		}
	});

	$("#producto").val('');
	$("#person_id").val('');
	$("#comentarios").val('');
	$("#txtcliente").val('');
	var total=0;

$( "#producto" ).autocomplete({
      source: productos,
      select: function (event, ui) {
			    
			    var subtotal=(parseFloat(ui.item.unit_price)*parseFloat(ui.item.cantidad));
			        var posicion=carrito.push({"item_id":ui.item.value,"nombre":ui.item.label,"precio":parseFloat(ui.item.unit_price),"cost_price":ui.item.cost_price,"cantidad":ui.item.cantidad,"description":"","alto":ui.item.alto,"ancho":ui.item.ancho,"metros_cuadrados":ui.item.metros_cuadrados,"subtotal":parseFloat(ui.item.unit_price),"comentario":""});

			        posicion=posicion-1;
			        $("tbody").append("<tr class='tr"+posicion+"'><td><i class='fa fa-trash-o fa fa-2x text-error eliminar' data-item="+posicion+"></i></td><td><label>"+ui.item.label+"</label></td><td>$"+ui.item.unit_price+"</td><td>Alto:<input size='3' type='text' class='alto alto"+posicion+"' data-item="+posicion+" value="+ui.item.alto+" >Ancho:<input size='3' type='text' class='ancho ancho"+posicion+"' data-item="+posicion+"  value="+ui.item.ancho+"></td><td>Metros cuadrados:<input size='3' type='text' class='metros_cuadrados"+posicion+"' data-item="+posicion+" value="+ui.item.metros_cuadrados+" readonly='readonly'></td><td><input type='text' class='comentario comentario"+posicion+"' data-item='"+posicion+"' value="+ui.item.comentario+" ></td><td><input type='text' size='4' class='cantidad cantidad"+posicion+"' value="+ui.item.cantidad+" data-item="+posicion+" placeholder='Cantidad...'></td><td>$<label class='sublabel"+posicion+"'>"+ui.item.unit_price+"</label></td><input type='hidden' class='precio"+posicion+"' data-item='"+posicion+"' value="+ui.item.unit_price+" ><input type='hidden' class='subtotal"+posicion+"' data-item='"+posicion+"'></td> </tr>");

	
	total=total+(ui.item.unit_price);
	console.log(carrito);
	$('.alto').numeric();
	$('.ancho').numeric();
	$('.cantidad').numeric();

/*
        for (var i = 0; i < carrito.length; i++) {
        	if(typeof (carrito[i].subtotal)=="undefined" || carrito[i].subtotal=="null" || carrito[i].subtotal==null){
        		total=total+parseFloat(0);
        	}else{
        		total=total+parseFloat(carrito[i].subtotal);
        	}
                                           
        };
	*/
	$("#lbtotal").text('');
	$("#total").val(total);
	$("#lbtotal").text(total);
	$("#producto").val('');

	$(".alto").on("change",function(){
		var item=$(this).attr("data-item");		
		var alto=$(".alto"+item).val();
		var ancho=$(".ancho"+item).val();
		var cantidad=$(".cantidad"+item).val();
		var precio=$(".precio"+item).val();
		var subtotal=(alto*ancho*cantidad*precio);
		$(".sublabel"+item).text(subtotal);
		$(".metros_cuadrados"+item).val(alto*ancho);
		var metros_cuadrados=$(".metros_cuadrados"+item).val();

        carrito[item].alto =alto;
        carrito[item].ancho=ancho;
        carrito[item].cantidad=cantidad;
        carrito[item].precio=precio;
        carrito[item].subtotal=subtotal; 
        carrito[item].metros_cuadrados=metros_cuadrados; 

        var total=0;
        for (var i = 0; i < carrito.length; i++) {
            total=total+carrito[i].subtotal;                               
        };

        $("#lbtotal").text('');
        $("#lbtotal").text(total);
        $("#total").val(total);

	});

	$(".ancho").on("change",function(){
		var item=$(this).attr("data-item");		
		var alto=$(".alto"+item).val();
		var ancho=$(".ancho"+item).val();
		var cantidad=$(".cantidad"+item).val();
		var precio=$(".precio"+item).val();
		var subtotal=(alto*ancho*cantidad*precio);
		$(".sublabel"+item).text(subtotal);
		$(".metros_cuadrados"+item).val(alto*ancho);
		var metros_cuadrados=$(".metros_cuadrados"+item).val();
		 

        carrito[item].alto =alto;
        carrito[item].ancho=ancho;
        carrito[item].cantidad=cantidad;
        carrito[item].precio=precio;
        carrito[item].subtotal=subtotal;
        carrito[item].metros_cuadrados=metros_cuadrados;
       
        var total=0;
        for (var i = 0; i < carrito.length; i++) {
            total=total+carrito[i].subtotal;                               
        };

        $("#lbtotal").text('');
        $("#lbtotal").text(total);
        $("#total").val(total);

	});

	$(".cantidad").on("change",function(){
		var item=$(this).attr("data-item");		
		var alto=$(".alto"+item).val();
		var ancho=$(".ancho"+item).val();
		var cantidad=$(".cantidad"+item).val();
		var precio=$(".precio"+item).val();
		var subtotal=(alto*ancho*cantidad*precio);
		$(".sublabel"+item).text(subtotal);
		$(".metros_cuadrados"+item).val(alto*ancho);
		var metros_cuadrados=$(".metros_cuadrados"+item).val();


        carrito[item].alto =alto;
        carrito[item].ancho=ancho;
        carrito[item].cantidad=cantidad;
        carrito[item].precio=precio;
        carrito[item].subtotal=subtotal;
        carrito[item].metros_cuadrados=metros_cuadrados; 
        console.log(carrito);   

        var total=0;
        for (var i = 0; i < carrito.length; i++) {
        	if(carrito[i].subtotal){
				total=total+carrito[i].subtotal;     
        	}else{
        		total=total;
        	}
                                      
        };

        $("#lbtotal").text('');
        $("#lbtotal").text(total);
        $("#total").val(total);

	});

	

	$(".eliminar").on("click",function(){
		
		var item=($(this).attr("data-item"));
		total=total-carrito[item].subtotal;
		$(this).parents('tr').eq(0).remove();
		
		console.log("Item:"+item+"Longitud:"+carrito.length);
		
		console.log("Total:"+total);

		
/*
		if(typeof (carrito[item].subtotal)=="undefined" || carrito[item].subtotal=="null" || carrito[item].subtotal==null){
        		sub=total+parseFloat(0);
        	}else{
        		sub=total+parseFloat(carrito[item].subtotal);
        	}
*/
		
		$("#lbtotal").text('');
        $("#lbtotal").text(total);
        $("#total").val(total);
		
        delete carrito[item];


		/*
		$.each( carrito, function( index, value ){
		    if(index==item){
		    	carrito.splice(carrito[item], 1);
                console.log("Eliminado"+index);
                console.log(carrito);
                
                
                return false;
                //throw "Cualquier Cosa";

		    }
		    return false;
		});
		*/
		return false;
		

	});

	$(".comentario").on("change",function(){
		var item=$(this).attr("data-item");		
		var comentario=$(".comentario"+item).val();
        carrito[item].comentario =comentario;
    
	});



	}

});





$( "#txtcliente" ).autocomplete({
      source: clientes,
      select: function (event, ui) {
			    $("#lbcliente").text(ui.item.label);
			    $("#person_id").val(ui.item.value);
		}
});





function eliminar(item)
	{ 	
		console.log("Item:"+item+"Longitud:"+carrito.length);

		$.each( carrito, function( index, value ){
		    if(index==item){
		    	carrito.splice(carrito[index], 1);
                console.log("Eliminado"+index);
                console.log(carrito);
                return false;
		    }else{
		    	console.log("No existe:"+item);
		    	return false;
		    }
		});
		
		return false;
                   

		//var carrito = [{mes:'Jan'}, {mes:'March'}, {mes:'April'}, {mes:'June'}];
		/*
		if($.inArray(0, carrito) !== -1){

			//delete carrito[item];
		}


	/*
		console.log(item);
		var indice = carrito.indexOf(item); // obtenemos el indice
		carrito.splice(item, 1); // 1 es la cantidad de elemento a eliminar
 */	
		console.log( carrito );
           

	}
    //Recorrer el areeglo con la posicion enviada que es id
  
$("#guardar").on("click",function(){
	if($("#person_id").val()=="" || $("#person_id").val()==null){
		alert("Selecciona un cliente.");
		return false;
	}

	$.ajax({
  		url:"/index.php/cotizacion/guardar",
  		type:"POST",
  		dataType:"json",
  		data:{productos:carrito,person_id:$("#person_id").val(),comentarios:$("#comentarios").val()},
  		success:function(data){
  			if(data.error==1){
  				alert("¡Error!.Agrega productos a la cotizacion.");
  				return false;
  			}
  			if(data.id!=0){
  				alert("Cotización guardada correctamente.");
  				location.reload();
  			}else{
  				alert("Error al guardar la Cotización.");
  			}
  		
  		},
  		error:function(){
  			alert("Error al guardar la Cotización.");
  		}
  	});
});
  	


});

</script>