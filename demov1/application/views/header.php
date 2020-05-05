<head>
		<title>Syventa</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<base href="<?= base_url()?>">
		<link rel="icon" href="<?= base_url()?>favicon.ico" type="image/x-icon">
		
					<link rel="stylesheet" rev="stylesheet" href="<?= base_url()?>css/bootstrap.min.css?14.1" media="all">
					<link rel="stylesheet" rev="stylesheet" href="<?= base_url()?>css/jquery.gritter.css?14.1" media="all">
					<link rel="stylesheet" rev="stylesheet" href="<?= base_url()?>css/jquery-ui.css?14.1" media="all">
					<link rel="stylesheet" rev="stylesheet" href="<?= base_url()?>css/unicorn.css?14.1" media="all">
					<link rel="stylesheet" rev="stylesheet" href="<?= base_url()?>css/custom.css?14.1" media="all">
					<link rel="stylesheet" rev="stylesheet" href="<?= base_url()?>css/datepicker.css?14.1" media="all">
					<link rel="stylesheet" rev="stylesheet" href="<?= base_url()?>css/bootstrap-select.css?14.1" media="all">
					<link rel="stylesheet" rev="stylesheet" href="<?= base_url()?>css/select2.css?14.1" media="all">
					<!--
					<link rel="stylesheet" rev="stylesheet" href="<?= base_url()?>css/font-awesome.min.css?14.1" media="all">
					-->
					<link rel="stylesheet" rev="stylesheet" href="<?= base_url()?>css/fontawesome.css" media="all">
					<link rel="stylesheet" rev="stylesheet" href="<?= base_url()?>css/jquery.loadmask.css?14.1" media="all">
					<link rel="stylesheet" rev="stylesheet" href="<?= base_url()?>css/token-input-facebook.css?14.1" media="all">
				<script type="text/javascript">
			var SITE_URL= "<?= base_url()?>index.php";
		</script>
		
					<script src="<?= base_url()?>js/all.js?14.1" type="text/javascript" language="javascript" charset="UTF-8"></script>
			
		
		<script type="text/javascript">
			COMMON_SUCCESS = "\u00c9xito";
			COMMON_ERROR = "Error";
			$.ajaxSetup ({
				cache: false,
				headers: { "cache-control": "no-cache" }
			});
			
			$(document).ready(function()
			{
				//Ajax submit current location
				$("#employee_current_location_id").change(function()
				{
					$("#form_set_employee_current_location_id").ajaxSubmit(function()
					{
						window.location.reload(true);
					});
				});	
			});
		</script>
		
	</head>
<div id="header" class="hidden-print">
			<h1><a href="<?= base_url()?>index.php"><img src="<?= base_url()?>img/header_logo.png" class="hidden-print header-log" id="header-logo" alt=""></a></h1>		
				<a id="menu-trigger" href="#"><i class="fa fa-bars fa fa-2x"></i></a>	
		<div class="clear"></div>
		</div>
		<div id="user-nav" class="hidden-print hidden-xs">
			<ul class="btn-group ">
		
				<li class="btn  hidden-xs disabled">
					
				</li>
									<li class="btn "><a href="<?= base_url()?>index.php/config"><i class="icon fa fa-cog"></i><span class="text">Configuración</span></a></li>
				        <li class="btn  ">
					<a href="<?= base_url()?>index.php/home/logout"><i class="fa fa-power-off"></i><span class="text">Salir</span></a>				</li>
			</ul>
		</div>
<div id="sidebar" class="hidden-print minibar ">
			
			<ul style="display: block;">
            					<li><a href="<?= base_url()?>index.php"><i class="icon fa fa-coffee"></i><span class="hidden-minibar">Inicio</span></a></li>
									<li ><a href="<?= base_url()?>index.php/customers"><i class="fa fa-group"></i><span class="hidden-minibar">Clientes</span></a></li>
									<li><a href="<?= base_url()?>index.php/items"><i class="fa fa-table"></i><span class="hidden-minibar">Inventario</span></a></li>
									<li><a href="<?= base_url()?>index.php/item_kits"><i class="fa fa-inbox"></i><span class="hidden-minibar">Grupos</span></a></li>
									<li><a href="<?= base_url()?>index.php/pedidos"><i class="fa fa-check-circle"></i><span class="hidden-minibar">Pedidos</span></a></li>
									<li><a href="<?= base_url()?>index.php/suppliers"><i class="fa fa-download"></i><span class="hidden-minibar">Proveedores</span></a></li>
									<li><a href="<?= base_url()?>index.php/reports"><i class="fa fa-bar-chart-o"></i><span class="hidden-minibar">Reportes</span></a></li>
									<li><a href="<?= base_url()?>index.php/receivings"><i class="fa fa-cloud-download"></i><span class="hidden-minibar">Entradas</span></a></li>
									<li><a href="<?= base_url()?>index.php/sales"><i class="fa fa-shopping-cart"></i><span class="hidden-minibar">Venta</span></a></li>
									<li><a href="<?= base_url()?>index.php/employees"><i class="fa fa-user"></i><span class="hidden-minibar">Empleados</span></a></li>
									<li><a href="<?= base_url()?>index.php/giftcards"><i class="fa fa-credit-card"></i><span class="hidden-minibar">Regalos</span></a></li>
									<li><a href="<?= base_url()?>index.php/config"><i class="fa fa-cogs"></i><span class="hidden-minibar">Tienda</span></a></li>
									<li><a href="<?= base_url()?>index.php/locations"><i class="fa fa-home"></i><span class="hidden-minibar">Ubicaciones</span></a></li>
				
				
                <li>
                	<a href="<?= base_url()?>index.php/home/logout"><i class="fa fa-power-off"></i><span class="hidden-minibar">Salir</span></a>
                </li>
			</ul>
		</div>