<style type="text/css">
	body {margin: 0px;}
</style>

<?php 
$total=0;
echo '<div id="company_logo" style="text-align:center">';
echo img(array("src" => "img/logo/LOGO_THE_PRINT_SHOP.png","width"=>"5%","height"=>"5%"));

echo '</div>';

echo "<div style='text-align:center'>".($empresa[0]->value)."<br>"; 
echo ($telefono->phone)."<br>";
echo "<div id='company_logo'><img src='http://syfors.com/syprint/index.php/app_files/view/1' alt=''></div>";
echo ($web_empresa->value)."<br> </div>";
echo "<b>Recibo de abonos.  # Venta: ".$sale_id["sale_id"]." </b><br>";
echo date('d-m-Y H:i:s')."<br>";
	echo "<table><thead><tr><th>Artículo</th><th>Precio</th><th>Cant.</th><th>Subtotal</th></tr></thead>";
	foreach ($productos as $value) {
		echo "<tbody><tr><td>".$value->name."</td><td>$".number_format($value->item_unit_price, 2, '.', '')."</td><td>".number_format($value->quantity_purchased, 2, '.', '')."</td><td>$".number_format(($value->item_unit_price)*($value->quantity_purchased), 2, '.', '')."</td><td></tbody>";
		//$total=$total+($value->item_unit_price)*($value->quantity_purchased);

	}
	$total=($total_venta->total_venta);
	echo "</table>";
	echo "Cliente:".$cliente->cliente;
	echo "<br><b>Total: $".$total;
	echo "   Abono: $".($total_abono->total_abono);
	echo "   Resto: $".($total-($total_abono->total_abono))."</b><br>";
	echo "Lista de abonos:<br>";

	echo "<table><thead><tr><th>Abono</th><th>Fecha</th></tr></thead>";
	foreach ($abonos as $val) {
			if($val->abono){
		echo "<tbody><tr><td>$".($val->abono)."</td><td>".($val->fecha_abono)."</td></tr></tbody>";
		}
	}
	
	echo "</table>";

/*
echo ($politica->value)."<br>";

 
*/
 echo "<button class='imprimir btn btn-success'>Imprimir</button>
 	   <button class='atras btn btn-success'>Regresar</button>";
?>
<script src="<?php echo base_url(); ?>js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">

	$(function(){
		window.print();
		$('.imprimir').click(function(){
		    window.print();
		    return false;
		});
		$('.atras').click(function(){
		    window.location.href = "<?php echo base_url(); ?>index.php/abonos/abonar";
		    return false;
		});
	});
</script>