


<div class="alert alert-info" role="alert">
  <strong>Reporte de ventas.</strong> 
</div>
<div class="row">	
	
	<div class="col-md-6">
	<div class="alert alert-info" role="alert">
  		<strong>Total por dia.</strong> 
	</div>
		<label>Selecciona la fecha:</label><input type="text" id="fecha" name="fecha">
		<button id="enviar" class="btn btn-primary">Total</button><br>
		<h3><label>Total:$</label><label id="total" ></label></h3>
	</div>
	<div class="col-md-6">
		<div class="alert alert-info" role="alert">
  			<strong>Total por periodo.</strong> 
		</div>
		<div class="row">
			<div class="col-md-6">
				<label>Selecciona la fecha inicial:</label>
				<input type="text" id="fecha1" name="fecha1">
			</div>
			<div class="col-md-6">
				<label>Selecciona la fecha final:</label>
				<input type="text" id="fecha2" name="fecha2">
			</div>
		</div>	
		<div class="row">
			<div class="col-md-12">
				<button id="enviarfecha" class="btn btn-primary">Total</button><br>
			
				<h3><label>Total:$</label><label id="totalfecha" ></label></h3>
			</div>
		</div>
		
		
	</div>

	
</div>

<div class="row">		
	<div class="col-md-6">
		<div class="alert alert-info" role="alert">
  			<strong>Ganancia por periodo.</strong> 
		</div>

		<div class="row">
			<div class="col-md-6">
				<label>Selecciona la fecha inicial:</label>
				<input type="text" id="fec1" name="fec1">
			</div>
			<div class="col-md-6">
				<label>Selecciona la fecha final:</label>
				<input type="text" id="fec2" name="fec2">
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<button id="ganancia" class="btn btn-primary">Total</button><br>
			</div>
			<div class="col-md-6">
				<h3><label>Total:$</label><label id="totalganancia" ></label></h3>
			</div>
		</div>		
	</div>
	<div class="col-md-6">

	</div>

	
</div>

<div class="row">
	<div class="col-md-12">
		<div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
	</div>	
</div>



<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>





<script type="text/javascript">
$(function(){
	$("#fecha").datepicker({
		format:"yyyy-mm-dd"
	});

	$("#fecha1").datepicker({
		format:"yyyy-mm-dd"
	});

	$("#fecha2").datepicker({
		format:"yyyy-mm-dd"
	});


	$("#fec1").datepicker({
		format:"yyyy-mm-dd"
	});

	$("#fec2").datepicker({
		format:"yyyy-mm-dd"
	});

	$.ajax({
			url:"<?php echo base_url().'index.php/abonos/ultimos_dias'; ?>",
			type:"GET",
			dataType:"json",
			
			async:false,
			success:function(dato){
				

	function grafica(dato){
			Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'ultimos 7 dias'
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Pesos $'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Total: <b>$ {point.y:.1f} </b>'
    },

    series: [{
        data: dato
    }]
});
	}

	grafica(dato)
				



				
			},
			error:function(data){

			}
		});

	$("#enviar").on("click",function(){
		$.ajax({
			url:"<?php echo base_url().'index.php/abonos/total_diario'; ?>",
			type:"GET",
			dataType:"json",
			data:{fecha:$("#fecha").val()},
			async:false,
			success:function(data){
				if(data.total==null){
					data.total=0;
				}
				$("#total").text(data.total);
			},
			error:function(data){

			}
		});
	});

	$("#ganancia").on("click",function(){
		$.ajax({
			url:"<?php echo base_url().'index.php/abonos/ganancia'; ?>",
			type:"GET",
			dataType:"json",
			data:{fecha1:$("#fec1").val(),fecha2:$("#fec2").val()},
			async:false,
			success:function(data){
				if(data.ganancia==null){
					data.ganancia=0;
				}
				$("#totalganancia").text(data.ganancia);
			},
			error:function(data){

			}
		});
	});


	$("#enviarfecha").on("click",function(){
		$.ajax({
			url:"<?php echo base_url().'index.php/abonos/periodo'; ?>",
			type:"GET",
			dataType:"json",
			data:{fecha1:$("#fecha1").val(),fecha2:$("#fecha2").val()},
			async:false,
			success:function(data){
				if(data.total==null){
					data.total=0;
				}
				$("#totalfecha").text(data.total);
			},
			error:function(data){

			}
		});
	});
	
	

	}
);
</script>
