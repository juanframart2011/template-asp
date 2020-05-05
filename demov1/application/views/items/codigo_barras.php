<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo lang('items_generate_barcodes'); ?></title>
	<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
</head>

<body style="margin: 0;">
	<div>
		<input type="number" name="cantidad" id="cantidad">
		<button id="generar" class="btn btn-primary">Generar etiquetas</button>
	</div>
<table width='50%' align='center' cellpadding='20'>
<tr id="rows">
	<!--
<?php 
for($k=0;$k<count($items);$k++)
{
	$item = $items[$k];
	$barcode = $item['id'];
	$text = $item['name'];

	$page_break_after = ($k == count($items) -1) ? 'auto' : 'always';
	echo "<div style='width: 2in;height: .8in;word-wrap: break-word;overflow: hidden;margin:0 auto;text-align:center;font-size: 10pt;line-height: 1em;page-break-after: $page_break_after;padding: 10px;'>".$this->config->item('company')."<br /><img src='".site_url('barcode').'?barcode='.rawurlencode($barcode).'&text='.rawurlencode($barcode)."&scale=$scale' /><br />".$text."</div>";
}
?>
-->
</tr>

	<script type="text/javascript">
		$(function(){
			$("#generar").on("click",function(){
				$("#rows").html('');
				for (var i = 0; i < $("#cantidad").val(); i++) {
					$("#rows").append("<?php for($k=0;$k<count($items);$k++){	$item = $items[$k];	$barcode = $item['id'];	$text = $item['name'];	$page_break_after = ($k == count($items) -1) ? 'auto' : 'always';echo "<div style='width: 2in;height: .8in;word-wrap: break-word;overflow: hidden;margin:0 auto;text-align:center;font-size: 10pt;line-height: 1em;page-break-after: $page_break_after;padding: 10px;'>".$this->config->item('company')."<br /><img src='".site_url('barcode').'?barcode='.rawurlencode($barcode).'&text='.rawurlencode($barcode)."&scale=$scale' /><br />".$text."</div>";}?>");	
				}
			});
			
		});	
	</script>

</table>
</body>

</html>
