<?php $this->load->view("partial/header"); ?>

<div id="content-header" class="hidden-print sales_header_container">
	<h1 class="headigs"> <i class="icon fa fa-barcode"></i>
		Facturación.<p><h3>Proximamente.</h3></p><span id="ajax-loader"><?php echo img(array('src' => base_url().'/img/ajax-loader.gif')); ?><br>
		</span>
		<?php if($this->sale_lib->get_change_sale_id()) { ?>
		<small>
	    </b> 
		</small>
		<?php } ?>
	</h1>
	<div class="content">
	<p><h3>Próximamente.</h3></p>
	</div>
</div>



<?php $this->load->view("partial/footer"); ?>