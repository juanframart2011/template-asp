
<style type="text/css">
	.top{
		margin-top: 15px;
	}
</style>
<div id="content-header" class="hidden-print">
	<h1 > <i class="fa fa-pencil"></i>  Buscar factura	</h1>
</div>
<div id="breadcrumb" class="hidden-print">
	<?php echo create_breadcrumb(); ?> <a class="current" href="#">Buscar factura</a>
</div>
<div class="clear"></div>

<div class="row">
	<div class="col-md-6">
		<div class="col-md-12 top">
			<label class="col-md-3" for="rfc">RFC:</label>
			<input class="col-md-6 " type="text" id="rfc">
		</div>
		<div class="col-md-12 top"><label>y/ó</label></div>
		<div class="col-md-12 top">
			<label class="col-md-3" for="sale_id">Número de venta:</label>
			<input class="col-md-6 " type="text" id="sale_id" >
		</div>
		
		<div class="col-md-12 top">
			<div class="col-md-3"></div>
			<button id="buscar_facturas" type="submit" class="col-md-6 top btn btn-primary btn-MD">Buscar factura.</button>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<table id="example" class="display" cellspacing="0" width="100%">
	        <thead>
	            <tr>
	                <th>Número de venta</th>
	                <th>Razón Social</th>
	                <th>Total</th>
	                <th>Fecha timbrado</th>	
	                <th>Reimprimir factura</th>	                   
	            </tr>
	        </thead>
	        <tfoot>
	            <tr>
	                <th>Número de venta</th>
	                <th>Razón Social</th>
	                <th>Total</th>
	                <th>Fecha timbrado</th>	     
	                <th>Reimprimir factura</th>	           
	            </tr>
	        </tfoot>
	        <tbody>
	        </tbody>
	    </table>
	</div>
</div>


<!--
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
-->


<script type="text/javascript">
$(function(){
	var facturas=[];
	var table;
	$("#buscar_facturas").on('click',function(){ 

		res=[];
		facturas=[];
		var listado=[];
		var datos=[];
		var rfc=$("#rfc").val();
		var sale_id=$("#sale_id").val();
		$.ajax({
			url:"index.php/factura/buscar_facturas",
			type:"POST",
			data:{rfc:rfc,sale_id:sale_id},
			dataType:"json",
			async:false,
			success:function(data){
				datos=[];
				var x= data.sale_id;
				
				if(x=='undefined' || x==undefined){	
					datos=data;
				}else{
					res.push({data:listado});
					console.log(res);

					facturas=[];
					datos.push(data);
					/*
					 $('#example').DataTable({
				    	search:true,
				    	ajax:data,
				    	"columns": [
				            { "data": "fecha_timbrado" },
				            { "data": "sale_id" }
				        ]
	    	
	    			});
	    			*/
					
				}
				
			},
			error:function(data){
				
			}
		});

		console.log(datos);
			table=$('#example').DataTable( {
				 "bDestroy": true,
				 "language": {
            "url": "<?php echo base_url();?>/js/Spanish.json"
        },
    data: datos,
     "order": [[ 0, "desc" ]],
    columns: [
        { data: 'sale_id' },
        { data: 'razon_social' },
        { data: 'total' },      
        { data: 'fecha_timbrado'}
    ],
   columnDefs: [ {
   			render: function ( data, type, row ) {
				return 	'<a href="<?php echo base_url(); ?>/index.php/factura/reimprimir_factura/'+row.sale_id+'/'+row.person_id+'"><button>Reimprimir factura.</button></a>'
			},

            targets: 4
           
            
        } ]

		
    });
		
		

			//var table = $('#example').DataTable();
  



	});  
	
/*  $('#example tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
        alert( 'You clicked on '+data[1]+'\'s row' );
    } );
	 $('#example tbody').on( 'click', 'tr', function () {
        var data = table.row( $(this).parents('tr') ).data();
        alert( data[0] +"'s salary is: "+ data[ 5 ] );
    } );

/*
	var arr=[{"id_factura":"1","person_id":"126","sale_id":"7","razon_social":"GRUPO EMPRESRIAL CLETUS","fecha_timbrado":"2017-04-01 12:12:12","total":"Efectivo: $513.68"},{"id_factura":"2","person_id":"126","sale_id":"9","razon_social":"GRUPO EMPRESRIAL CLETUS","fecha_timbrado":"2017-04-02 10:10:10","total":"Efectivo: $171.23"}];
		$('#example').DataTable( {
    data: datos,
    columns: [
        { data: 'id_factura' },
        { data: 'person_id' },
        { data: 'sale_id' },
        { data: 'razon_social' },
        { data: 'fecha_timbrado'},
        { data: 'total'}
    ]
    });
*/
/*
{
  "data": [
    [
      "Tiger Nixon",
      "System Architect",
      "Edinburgh",
      "5421",
      "2011/04/25",
      "$320,800"
    ],
    [
      "Garrett Winters",
      "Accountant",
      "Tokyo",
      "8422",
      "2011/07/25",
      "$170,750"
    ],
    [
      "Ashton Cox",
      "Junior Technical Author",
      "San Francisco",
      "1562",
      "2009/01/12",
      "$86,000"
    ],
]
}
*/
   

	function log( message ) {
			$( "<div>" ).text( message ).prependTo( "#log" );
			$( "#log" ).scrollTop( 0 );
		}

		$( "#rfc" ).autocomplete({
			minLength: 1,
	 	    delay : 400,
			source: function(request, response) { 

				jQuery.ajax({
				   url: 	 "index.php/factura/buscar_cliente",
				   data:  {
				   			rfc:$("#rfc").val()
				   	},
				   dataType: "json",

				   success: function(data) 	{

					 response(data);
				  }	

				})
	 	   },

		   select:  function(e, ui) {
				var keyvalue = ui.item.value;
				//alert("Customer number is " + keyvalue); 

			}

			/*
			source: function( request, response ) {
				$.ajax( {
					url: "index.php/factura/buscar_cliente",
					dataType: "jsonp",
					data: {
						term: request.term
					},
					success: function( data ) {
						response( data );
					}
				} );
			},
			minLength: 2,
			select: function( event, ui ) {
				log( "Selected: " + ui.item.value + " aka " + ui.item.id );
			}*/
		} );

	/*
	$(".autocompletar").keyup(function(){
					
		//en info tenemos lo que vamos escribiendo en el buscador
		var info = $(this).val();
		//hacemos la petición al método autocompletar del controlador autocompletado
		//pasando la variable info
		$.post('index.php/factura/buscar_cliente',{ rfc : info }, function(data){
						
			//si autocompletado nos devuelve algo
			if(data != '')
			{
	
				//en el div con clase contenedor mostramos la info
				$(".contenedor").html(data.rfc);
								
			}else{
								
				$(".contenedor").html('');
								
			}
	    })
					
    });
				
 
	//buscamos el elemento pulsado con live y mostramos un alert
	$(".contenedor").find("a").live('click',function(e){
		e.preventDefault();
		alert($(this).html());
	});

$("#rfc").autocomplete({
    source: 'index.php/factura/buscar_cliente' // path to the get_birds method
  });
	
		var searchRequest = null;
$("#rfc3").autocomplete({
    
    source: function(request, response) {
        if (searchRequest !== null) {
            searchRequest.abort();
        }
        searchRequest = $.ajax({
            url: 'index.php/factura/buscar_cliente',
            method: 'post',
            dataType: "json",
            data: {rfc: $("#rfc").val()},
            success: function(data) {
                searchRequest = null;
                response($.map(data.items, function(item) {
                    return {
                        value: item.rfc,
                        label: item.rfc
                    };
                }));
            }
        }).fail(function() {
            searchRequest = null;
        });
    }
});



		  
	 function obtener_rfc(){
	 	$.ajax({
				url:"index.php/factura/buscar_cliente",
				type:"GET",
				data:{rfc:rfc},
				dataType:'json',
				success:function(data){
					data.map(function(a){
						data=push(a.rfc);
					});
					
				},
				error:function(){
					console.log("eRROR");
				},


			});
	 	return data;
	 }
	 */
});



	
</script>
