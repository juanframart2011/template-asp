<?php
class abonos_m extends CI_Model
{
	/*
	Determines if a given item_id is an item
	*/
	function crear_abono($sale_id,$tipo_pago,$total_final,$resto,$abono,$cliente)
	{

		$fecha=date('Y-m-d');
		$data=array("sale_id"=>$sale_id,"forma_pago"=>$tipo_pago,"fecha"=>$fecha,"total"=>$total_final,"resto"=>$resto,"abono"=>$abono,"cliente"=>$cliente);		
		$this->db->insert("phppos_abonos",$data);

		$this->db->where("sale_id",$sale_id);
		$this->db->update("phppos_sales",array("total_venta"=>$total_final));

		return $this->db->insert_id();
	
	}

	function total_diario_venta()
	{
		$this->load->helper('date');
		$fecha=date('Y-m-d');
		
		$this->db->select("sum(total_venta) total",false);
		$this->db->from("phppos_sales");
		$this->db->where("fecha",$fecha);
		$this->db->where("deleted",0);
		//$this->db->where("sale_time<=",$fecha2,false);
		$result=$this->db->get();
		return $result->row();
	}

	function total_diario_abonos()
	{
		$this->load->helper('date');
		$fecha=date('Y-m-d');
		
		$this->db->select("sum(abono) total",false);
		$this->db->from("phppos_abonos");
		$this->db->where("fecha",$fecha);
		$this->db->where("deleted",0);
		//$this->db->where("sale_time<=",$fecha2,false);
		$result=$this->db->get();
		return $result->row();
	}

	function trabajos_pendientes()
	{
		$this->load->helper('date');
		$fecha=date('Y-m-d');
		
		$this->db->select("count(*) pedidos",false);
		$this->db->from("phppos_sales_items");
		$this->db->where("hecho",0);
		$this->db->where("deleted",0);
		//$this->db->where("sale_time<=",$fecha2,false);
		$result=$this->db->get();
		return $result->row();
	}

	function deudas_clientes()
	{
		$this->load->helper('date');
		$fecha=date('Y-m-d');
		
		$this->db->select("sum(total_venta),sum(abono),(sum(total_venta)-sum(abono)) deuda",false);
		$this->db->from("phppos_sales");
		$this->db->join("phppos_abonos","phppos_sales.sale_id=phppos_abonos.sale_id");
		$this->db->where("phppos_sales.sale_id=phppos_abonos.sale_id",false);
		//$this->db->where("phppos_sales.sale_id=phppos_abonos.sale_id",0,false);
		//$this->db->where("sale_time<=",$fecha2,false);
		$this->db->where("phppos_sales.deleted",0);
		$result=$this->db->get();
		return $result->row();
	}

	//SELECT (sum(abono)-total_venta) FROM `phppos_sales` inner join phppos_abonos on (phppos_sales.sale_id=phppos_abonos.sale_id) where phppos_sales.sale_id=phppos_abonos.sale_id

	function obtener_razon()
	{
		$this->db->from("phppos_people");
		$this->db->where("phppos_people.person_id",1);
		$result=$this->db->get();
		return $result->row();
	}

	function nombre_empresa()
	{
		$this->db->select("value");
		$this->db->from("phppos_app_config");
		$this->db->where("key","company");
		$result=$this->db->get();
		return $result->result();
	}

	function web_empresa()
	{
		$this->db->select("value");
		$this->db->from("phppos_app_config");
		$this->db->where("key","website");
		$result=$this->db->get();
		return $result->row();
	}

	function telefono_empresa()
	{
		$this->db->select("phone");
		$this->db->from("phppos_locations");
		$this->db->where("location_id",1);
		$result=$this->db->get();
		return $result->row();
	}

	function politica_empresa()
	{
		$this->db->select("return_policy");
		$this->db->from("phppos_people");
		$this->db->where("person_id",1);
		$result=$this->db->get();
		return $result->row();
	}
/*
	function productos($sale_id=false)
	{
		$this->db->select("*");
		$this->db->from("phppos_sales_items");
		$this->db->where("sale_id",$sale_id);
		$result=$this->db->get();
		return $result->result();

	}
*/
	function lista_cuentas($sale_id=false,$tabla=false)
	{	


		$this->db->select("phppos_abonos.cliente,phppos_abonos.fecha,phppos_abonos.sale_id, CONCAT('$','',FORMAT(sum(phppos_abonos.abono),1)) as total_abono, CONCAT('$','',FORMAT(phppos_sales.total_venta,1)) as total, CONCAT('$','',FORMAT((phppos_sales.total_venta-(sum(phppos_abonos.abono))),1)) as resto",false);
		$this->db->from("phppos_abonos");
		$this->db->join("phppos_sales","phppos_abonos.sale_id=phppos_sales.sale_id");
		if($sale_id)
			$this->db->where("phppos_sales.sale_id",$sale_id);
		$this->db->where("phppos_sales.deleted",0);
		$this->db->having("(select sum(abono))!= (select sum(total) total)",false);
		//$this->db->or_having("(select sum(abono))< 0",false);
		$this->db->group_by("phppos_abonos.sale_id");
		$result=$this->db->get();	
		$rows=$result->num_rows();
		if($tabla){
			return $result->result();
		}
		if($rows==1){
			return $result->row();
		}else{
			return $result->result();
		}

	}

	function lista_cuentas_elim($sale_id=false)
	{	

		$this->db->select("phppos_abonos.cliente,phppos_abonos.fecha,phppos_abonos.sale_id, CONCAT('$','',FORMAT(sum(phppos_abonos.abono),1)) as total_abono, CONCAT('$','',FORMAT(phppos_sales.total_venta,1)) as total, CONCAT('$','',FORMAT((phppos_sales.total_venta-(sum(phppos_abonos.abono))),1)) as resto",false);
		$this->db->from("phppos_abonos");
		$this->db->join("phppos_sales","phppos_abonos.sale_id=phppos_sales.sale_id");
		$this->db->where("phppos_sales.sale_id",$sale_id);
		$this->db->where("phppos_sales.deleted",0);
		//$this->db->having("(select sum(abono))!= (select sum(total) total)",false);
		
		$this->db->group_by("phppos_abonos.sale_id");
		$result=$this->db->get();	
			
		return $result->row();
		

	}

	function cuentas_eliminadas($sale_id=false,$tabla=false)
	{	

		$this->db->select("phppos_abonos.cliente,phppos_abonos.fecha,phppos_abonos.sale_id, CONCAT('$','',FORMAT(sum(phppos_abonos.abono),1)) as total_abono, CONCAT('$','',FORMAT(phppos_sales.total_venta,1)) as total, CONCAT('$','',FORMAT((phppos_sales.total_venta-(sum(phppos_abonos.abono))),1)) as resto",false);
		$this->db->from("phppos_abonos");
		$this->db->join("phppos_sales","phppos_abonos.sale_id=phppos_sales.sale_id");
		if($sale_id)
			$this->db->where("phppos_sales.sale_id",$sale_id);
		$this->db->where("phppos_sales.deleted",1);
		//$this->db->having("(select sum(abono))!= (select sum(total) total)",false);
		//$this->db->or_having("(select sum(abono))< 0",false);
		$this->db->group_by("phppos_abonos.sale_id");
		$result=$this->db->get();	
		$rows=$result->num_rows();
		if($tabla){
			return $result->result();
		}
		if($rows==1){
			return $result->row();
		}else{
			return $result->result();
		}

	}

	function productos_elim($sale_id=false)
	{
		$this->db->select("phppos_items.name, phppos_sales_items.comentarios, FORMAT(phppos_sales_items.quantity_purchased,2) quantity_purchased, FORMAT(phppos_sales_items.item_unit_price,2) item_unit_price",false);
		$this->db->from("phppos_sales_items");
		$this->db->join("phppos_items","phppos_sales_items.item_id=phppos_items.item_id");
		$this->db->where("phppos_sales_items.sale_id",$sale_id);
		$this->db->where("phppos_sales_items.deleted",0);
		$result=$this->db->get();

		return $result->result();

	}

	function cliente($sale_id=false)
	{
		$this->db->select("CONCAT(first_name,' ',last_name) cliente",false);
		$this->db->from("phppos_people");
		$this->db->join("phppos_sales","phppos_people.person_id=phppos_sales.customer_id");
		$this->db->where("phppos_sales.sale_id",$sale_id);	
		$this->db->where("phppos_sales.deleted",0);	
		//$this->db->order_by("fecha","DESC");
		$result=$this->db->get();
		$rows=$result->num_rows();

		if($rows<=1)
			return $result->row();
		return $result->result();
	}

	function lista_abonos($sale_id=false)
	{
		$this->db->select("phppos_abonos.*, DATE_FORMAT(fecha,'%d-%m-%Y') fecha_abono",false);
		$this->db->from("phppos_abonos");
		$this->db->where("sale_id",$sale_id);	
		$this->db->where("phppos_abonos.deleted",0);	
		$this->db->order_by("fecha","DESC");
		$result=$this->db->get();
		$rows=$result->num_rows();

		if($rows<=1)
			return $result->row();
		return $result->result();
	}

	function add_abono($sale_id=false,$abono=false,$tipo_pago=false)
	{
		$this->db->select("cliente",false);
		$this->db->from("phppos_abonos");
		$this->db->where('cliente is NOT NULL', NULL, FALSE);		
		$this->db->where("sale_id",$sale_id);		
		$result=$this->db->get();
		$cliente=$result->row()->cliente;
	   
		$this->db->flush_cache();
		$fecha=date('Y-m-d');
		$this->db->insert("phppos_abonos",array("sale_id"=>$sale_id,"abono"=>$abono,"forma_pago"=>$tipo_pago,"fecha"=>$fecha,"cliente"=>$cliente));
		return $this->db->insert_id();
	}

	function saldo($sale_id)
	{
		$this->db->select("total-(sum(abono)) saldo",false);
		$this->db->from("phppos_abonos");
		$this->db->where("phppos_abonos.sale_id",$sale_id);
		$this->db->where("phppos_abonos.deleted",0);
		//$this->db->where("");
		$result=$this->db->get();
		return $result->row();
	}

	function cuentas_terminadas()
	{

		$data=array();
		//SELECT phppos_abonos.sale_id, sum(phppos_abonos.abono),sum(phppos_abonos.total) FROM `phppos_abonos` group by phppos_abonos.sale_id HAVING (sum(phppos_abonos.abono)=sum(phppos_abonos.total)) 
		$this->db->select("cliente,sale_id, CONCAT('$','',FORMAT(sum(abono),1)) as abono, CONCAT('$','',FORMAT(sum(total),1)) as total",false);
		$this->db->from("phppos_abonos");
		$this->db->where("entregado",0);
		$this->db->group_by("sale_id");
		$this->db->having("(sum(phppos_abonos.abono))=(sum(phppos_abonos.total)) ");
		$this->db->where("phppos_abonos.deleted",0);
		$result=$this->db->get();

		//return $result->result();

		$i=0;
		foreach($result->result() as $row)
		{
			$this->db->select("*");
			$this->db->from("phppos_sales_items");
			$this->db->where("sale_id",$row->sale_id);
			$this->db->where("phppos_sales_items.deleted",0);
			$result=$this->db->get();
			$total_rows=$result->num_rows();

			$this->db->select("*");
			$this->db->from("phppos_sales_items");
			$this->db->where("phppos_sales_items.deleted",0);
			$this->db->where("sale_id",$row->sale_id);
			$this->db->where("hecho",1);
			$result=$this->db->get();
			$listas=$result->num_rows();


			if($total_rows==$listas)
			{
				$data[$i]=array("sale_id"=>$row->sale_id,"cliente"=>$row->cliente,"abono"=>$row->abono,"total"=>$row->total,"listas"=>$listas,"total_items"=>$total_rows);
				$i++;

			}

		}

		return $data;

	}


	function cta_pagada_no_ter()
	{
		//CONCAT('$','',FORMAT(total,1)) as total
		//CONCAT('$','',FORMAT(sum(total),1)) as abono
		$data=array();
		//SELECT phppos_abonos.sale_id, sum(phppos_abonos.abono),sum(phppos_abonos.total) FROM `phppos_abonos` group by phppos_abonos.sale_id HAVING (sum(phppos_abonos.abono)=sum(phppos_abonos.total)) 
		$this->db->select("cliente,sale_id, CONCAT('$','',FORMAT(sum(abono),1)) as abono, CONCAT('$','',FORMAT(sum(total),1)) as total",false);
		$this->db->from("phppos_abonos");
		$this->db->where("phppos_abonos.deleted",0);
		$this->db->where("entregado",0);
		$this->db->group_by("sale_id");
		$this->db->having("(sum(phppos_abonos.abono))=(sum(phppos_abonos.total)) ");
		$result=$this->db->get();

		//return $result->result();

		$i=0;
		foreach($result->result() as $row)
		{
			$this->db->select("*");
			$this->db->from("phppos_sales_items");
			$this->db->where("phppos_sales_items.deleted",0);
			$this->db->where("sale_id",$row->sale_id);
			$result=$this->db->get();
			$total_rows=$result->num_rows();

			$this->db->select("*");
			$this->db->from("phppos_sales_items");
			$this->db->where("phppos_sales_items.deleted",0);
			$this->db->where("sale_id",$row->sale_id);
			$this->db->where("hecho",0);
			$result=$this->db->get();
			$listas=$result->num_rows();


			if($total_rows==$listas)
			{
				$data[$i]=array("sale_id"=>$row->sale_id,"cliente"=>$row->cliente,"abono"=>$row->abono,"total"=>$row->total,"listas"=>$listas,"total_items"=>$total_rows);
				$i++;

			}

		}

		return $data;

	}

	function productos($sale_id=false)
	{
		$this->db->select("phppos_items.name, phppos_sales_items.comentarios, FORMAT(phppos_sales_items.quantity_purchased,2) quantity_purchased, FORMAT(phppos_sales_items.item_unit_price,2) item_unit_price",false);
		$this->db->from("phppos_sales_items");
		$this->db->join("phppos_items","phppos_sales_items.item_id=phppos_items.item_id");
		$this->db->where("phppos_sales_items.sale_id",$sale_id);
		$this->db->where("phppos_sales_items.deleted",0);
		$result=$this->db->get();

		if($result->num_rows==1){
			return $result->row();
		}

		return $result->result();

	}

	function productos_eliminados($sale_id=false)
	{
		$this->db->select("phppos_items.name, phppos_sales_items.comentarios, FORMAT(phppos_sales_items.quantity_purchased,2) quantity_purchased, FORMAT(phppos_sales_items.item_unit_price,2) item_unit_price",false);
		$this->db->from("phppos_sales_items");
		$this->db->join("phppos_items","phppos_sales_items.item_id=phppos_items.item_id");
		$this->db->where("phppos_sales_items.sale_id",$sale_id);
		$this->db->where("phppos_sales_items.deleted",1);
		$result=$this->db->get();
		return $result->result();

	}


	function total_venta($sale_id)
	{
		$this->db->select("total_venta");
		$this->db->from("phppos_sales");
		$this->db->where("phppos_sales.deleted",0);
		$this->db->where("sale_id",$sale_id);
		$result=$this->db->get();
		return $result->row();
	}

	function productos_abono($sale_id=false)
	{
		$this->db->select("phppos_items.name, phppos_sales_items.comentarios, phppos_sales_items.quantity_purchased quantity_purchased, phppos_sales_items.item_unit_price item_unit_price",false);
		$this->db->from("phppos_sales_items");
		$this->db->join("phppos_items","phppos_sales_items.item_id=phppos_items.item_id");
		$this->db->where("phppos_sales_items.sale_id",$sale_id);
		$this->db->where("phppos_sales_items.deleted",0);
		$result=$this->db->get();

		return $result->result();

	}

	function total_abono($sale_id=false)
	{
		$this->db->select("sum(abono) total_abono",false);
		$this->db->from("phppos_abonos");
		//$this->db->join("phppos_items","phppos_sales_items.item_id=phppos_items.item_id");
		$this->db->where("phppos_abonos.sale_id",$sale_id);
		$this->db->where("phppos_abonos.deleted",0);
		$result=$this->db->get();
		
		return $result->row();

	}


	function entregar($sale_id=false)
	{
		$this->db->where("sale_id",$sale_id);
		$this->db->update("phppos_abonos",array("entregado"=>1));
		return $this->db->affected_rows();
	
	}

	function total_diario($fecha=false)
	{
		//$fecha=date_format($fecha, 'Y-m-d');
		//echo $fecha;
		$this->db->select("sum(abono) total");
		$this->db->from("phppos_abonos");
		$this->db->where("phppos_abonos.deleted",0);
		$this->db->where("fecha",$fecha);
		$result=$this->db->get();
		return $result->row();
	}

	function ultimos_dias()
	{
		
		$this->db->select("sum(abono) abono, fecha");
		$this->db->from("phppos_abonos");
		$this->db->where("phppos_abonos.deleted",0);
		$this->db->where("fecha BETWEEN CURRENT_DATE()-7 AND CURRENT_DATE()");
		$this->db->group_by("fecha");
		$result=$this->db->get();
		
		$data=array();
		$i=0;

		foreach($result->result() as $row)
		{
			$data[$i]=array("name"=>$row->fecha,"color"=>"#FF00FF","y"=>(float)($row->abono));
			$i++;
		}

		return $data;

	}

	function periodo($fecha1=false,$fecha2=false)
	{
		$this->db->select("sum(abono) total");
		$this->db->from("phppos_abonos");
		$this->db->where("phppos_abonos.deleted",0);
		$this->db->where("fecha between '$fecha1' and '$fecha2' ");
		$result=$this->db->get();
		return $result->row();
	}

	function ganancia($fecha1=false,$fecha2=false)
	{

/*
		SELECT FORMAT(sum((item_unit_price*quantity_purchased)- ((((cost_price*100)/unit_price)*0.01 )*(item_unit_price*quantity_purchased))),2 )    FROM `phppos_items` inner join phppos_sales_items on(phppos_sales_items.item_id=phppos_items.item_id)



		
		SELECT phppos_sales_items.item_id, phppos_sales_items.sale_id, sum((((cost_price*100)/unit_price)*0.01 )*(item_unit_price*quantity_purchased))     FROM `phppos_items` inner join phppos_sales_items on(phppos_sales_items.item_id=phppos_items.item_id) WHERE phppos_sales_items.item_id =phppos_items.item_id group by phppos_sales_items.sale_id 
		*/
		$this->db->select("FORMAT(sum((item_unit_price*quantity_purchased)- ((((cost_price*100)/unit_price)*0.01 )*(item_unit_price*quantity_purchased))),2 ) ganancia",false);
		$this->db->from("phppos_items");
		$this->db->join("phppos_sales_items","phppos_sales_items.item_id=phppos_items.item_id");		
		$this->db->where("phppos_sales_items.item_id","phppos_items.item_id",false);
		$this->db->where("(phppos_sales_items.fecha BETWEEN '$fecha1' and '$fecha2')");
		$this->db->where("hecho",1);
		$this->db->where("phppos_sales_items.deleted",0);
		//$this->db->where("phppos_sales.deleted",0);
		//$this->db->group_by("phppos_sales_items.sale_id");
		$result=$this->db->get();
		return $result->row();

		/*
		$this->db->select("FORMAT(sum(( phppos_sales_items.quantity_purchased*(phppos_sales_items.item_unit_price-phppos_sales_items.item_cost_price))),2) ganancia",false);
		$this->db->from("phppos_sales_items");
		$this->db->where("(phppos_sales_items.fecha BETWEEN '$fecha1' and '$fecha2')");
		$this->db->where("hecho",1);
		*/
	}

	function entregadas()
	{
		$this->db->select("sale_id, cliente,fecha,CONCAT('$','',FORMAT(total,1)) as total,forma_pago",false);
		$this->db->from("phppos_abonos");
		$this->db->where("phppos_abonos.deleted",0);
		//$this->db->where("phppos_sales.deleted",0);
		$this->db->where("phppos_abonos.entregado",1);
		$this->db->group_by("sale_id");
		$this->db->order_by("sale_id","DESC");
		$result=$this->db->get();
		return $result->result();
	}

	function empleados()
	{
		$this->db->select("person_id,username");
		$this->db->from("phppos_employees");
		$this->db->where("deleted",0);
		$result=$this->db->get();
		return $result->result();
	}

	function por_empleado_caja($id_empleado=false,$fecha=false,$tipo_pago=false)
	{
		$this->db->select("sum(abono) total_caja,sum(total) total_venta",false);
		$this->db->from("phppos_abonos");
		$this->db->join("phppos_sales","phppos_abonos.sale_id=phppos_sales.sale_id");
		$this->db->where("phppos_abonos.deleted",0);
		$this->db->where("phppos_sales.employee_id",$id_empleado);
		$this->db->where("phppos_abonos.fecha",$fecha);

		$this->db->where("phppos_abonos.forma_pago",$tipo_pago);
		$result=$this->db->get();
		return $result->row();
	}

	function por_dia_caja($fecha=false,$tipo_pago=false)
	{
		$this->db->select("sum(abono) total_caja",false);
		$this->db->from("phppos_abonos");
		$this->db->join("phppos_sales","phppos_abonos.sale_id=phppos_sales.sale_id");
		//$this->db->where("phppos_sales.employee_id",$id_empleado);
		$this->db->where("phppos_abonos.fecha",$fecha);
		$this->db->where("phppos_abonos.deleted",0);
		$this->db->where("phppos_abonos.forma_pago",$tipo_pago);
		$result=$this->db->get();
		return $result->row();
	}

	function por_dia($fecha=false,$tipo_pago=false)
	{
		$this->db->select("sum(abono) total,forma_pago,cliente,phppos_abonos.fecha",false);
		$this->db->from("phppos_abonos");
		$this->db->join("phppos_sales","phppos_abonos.sale_id=phppos_sales.sale_id");
		//$this->db->where("phppos_sales.employee_id",$id_empleado);
		$this->db->where("phppos_abonos.deleted",0);
		$this->db->where("phppos_abonos.fecha",$fecha);
		$this->db->where("phppos_abonos.forma_pago",$tipo_pago);
		$this->db->group_by("phppos_abonos.id_venta","ASC");
		$result=$this->db->get();
		return $result->result();
	}

	function eliminar_venta($sale_id=false)
	{
		$this->db->where("sale_id",$sale_id);
		$this->db->update("phppos_abonos",array("deleted"=>1));

		$this->db->flush_cache();
		$this->db->where("sale_id",$sale_id);
		$this->db->update("phppos_sales_items",array("deleted"=>1));

		$this->db->flush_cache();
		$this->db->where("sale_id",$sale_id);
		$this->db->update("phppos_sales",array("deleted"=>1));

		return $this->db->affected_rows();

	}


}