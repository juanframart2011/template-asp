<?php
class cotizacion_m extends CI_Model
{
	/*
	Determines if a given item_id is an item
	*/
	function productos($item_id=false,$autocomplete=false)
	{
		if($autocomplete){
			$this->db->select("unit_price precio, name,item_id,REPLACE(FORMAT(unit_price,1),',','') unit_price,cost_price",false);	
		}else{
			$this->db->select("*");
		}

		$this->db->from("items");
		if($item_id)
			$this->db->where("item_id",$item_id);
		$result=$this->db->get();
		if($item_id)
			return $result->row();
		return $result->result();

	}

	function add_iva($id_cotizacion=false,$total=false)
	{
		//34.72
		$iva=($total*0.16);
		$total_venta=$total+$iva;
		$this->db->where("id_cotizacion",$id_cotizacion);
		$this->db->update("phppos_cotizacion",array("total_venta"=>$total_venta,"total_iva"=>$iva,"iva"=>1));
		return $this->db->affected_rows();
	}

	function del_iva($id_cotizacion=false,$total=false)
	{
		$this->db->select("total_iva,total_venta");
		$this->db->from("phppos_cotizacion");
		$this->db->where("id_cotizacion",$id_cotizacion);
		$result=$this->db->get();
		$total_iva=$result->row()->total_iva;
		$total_venta=$result->row()->total_venta;

		$total_venta=$total_venta-$total_iva;

		$this->db->where("id_cotizacion",$id_cotizacion);
		$this->db->update("phppos_cotizacion",array("total_venta"=>$total_venta,"iva"=>0,"total_iva"=>0));
		return $this->db->affected_rows();
	}


	function clientes()
	{
		$this->db->select("phppos_people.*, CONCAT(first_name,' ',last_name) nombre",false);
		$this->db->from("phppos_customers");
		$this->db->join("phppos_people","phppos_people.person_id=phppos_customers.person_id");
		$this->db->where("deleted",0);
		$result=$this->db->get();
		return $result->result();
	}

	function get_productos($id_cotizacion=false)
	{
		$this->db->select("phppos_cotizacion.*,phppos_sales_items_cotizacion.*, FORMAT(phppos_items.unit_price,2) precio, phppos_items.name name,FORMAT(phppos_sales_items_cotizacion.quantity_purchased,2) quantity_purchased",false);
		$this->db->from("phppos_cotizacion");
		$this->db->join("phppos_sales_items_cotizacion","phppos_cotizacion.id_cotizacion=phppos_sales_items_cotizacion.id_cotizacion");
		$this->db->join("phppos_items","phppos_sales_items_cotizacion.item_id=phppos_items.item_id");
		if($id_cotizacion)
			$this->db->where("phppos_cotizacion.id_cotizacion",$id_cotizacion);
		if($customer_id)
			$this->db->where("phppos_cotizacion.customer_id",$customer_id);
		$result=$this->db->get();
		
		return $result->result();
	}

	function get_cotizaciones($id_cotizacion=false,$customer_id=false)
	{
		$this->db->select("phppos_cotizacion.*,	CONCAT(phppos_people.first_name,' ',phppos_people.last_name) nombre, phppos_people.email ",false);
		$this->db->from("phppos_cotizacion");
		$this->db->join("phppos_people","phppos_cotizacion.customer_id=phppos_people.person_id","left");
		if($id_cotizacion)
			$this->db->where("phppos_cotizacion.id_cotizacion",$id_cotizacion);
		if($customer_id)
			$this->db->where("phppos_cotizacion.customer_id",$customer_id);
		$this->db->where("deleted",0);
		$result=$this->db->get();
		if($id_cotizacion)
			return $result->row();
		return $result->result();
	}

	function guardar($productos,$person_id,$total_venta,$comentarios=false,$iva=false)
	{	
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		$fecha=date('Y-m-d');
		$cotizacion=array("customer_id"=>$person_id,"employee_id"=>$employee_id,"total_venta"=>$total_venta,"comentarios"=>$comentarios,"fecha"=>$fecha,"iva"=>$iva);
		$this->db->insert("phppos_cotizacion",$cotizacion);
		$id_cotizacion=$this->db->insert_id();

		$fecha2=date('Y-m-d');
		foreach ($productos as $key) {
			$total_venta=$total_venta+($key['subtotal']);
			$producto=array("id_cotizacion"=>$id_cotizacion,"item_id"=>$key['item_id'],"description"=>$comentarios,"quantity_purchased"=>$key['cantidad'],"item_cost_price"=>$key['cost_price'],"item_unit_price"=>$key['precio'],"fecha"=>$fecha2,"comentarios"=>$key['comentario'],"total"=>$key['subtotal'],"alto"=>$key['alto'],"ancho"=>$key['ancho'],"metros_cuadrados"=>$key['metros_cuadrados']);
			
			$this->db->insert("phppos_sales_items_cotizacion",$producto);
		}

		return $this->db->insert_id();

	}

	function guardar_venta($id_cotizacion,$tipo_pago,$total_final,$resto,$abono,$cliente)
	{
		$this->db->select("phppos_cotizacion.*",false);
		$this->db->from("phppos_cotizacion");
		$this->db->where("phppos_cotizacion.id_cotizacion",$id_cotizacion);
		$resultcot=$this->db->get();
		$cotizacion=$resultcot->row();

		$payment_type=$tipo_pago.": $".$abono."<br />";   //Efectivo: $80.00<br />
		$customer_id=$cotizacion->customer_id;
		$employee_id=$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		$comment=$cotizacion->comentarios;
		$fecha=date("Y-m-d");
		$total_venta=$total_final;
		//$total_venta=$cotizacion->total_venta;
		$location_id=1;

		//Obtener cliente 
		$this->db->flush_cache();
		$this->db->select("phppos_people.*,CONCAT(phppos_people.first_name,' ',phppos_people.last_name) nombre_completo",false);
		$this->db->from("phppos_people");
		$this->db->where("phppos_people.person_id",$customer_id);
		$row=$this->db->get();
		$cliente=$row->row()->nombre_completo;
		

		$this->db->flush_cache();
		$venta_datos=array("customer_id"=>$customer_id,"employee_id"=>$employee_id,"comment"=>$comment,"fecha"=>$fecha,"payment_type"=>$payment_type, "total_venta"=>$total_venta,"location_id"=>$location_id);
		$this->db->insert("phppos_sales",$venta_datos);
		$sale_id=$this->db->insert_id();

		$this->db->select("*");
		$this->db->from("phppos_sales_items_cotizacion");
		$this->db->where("id_cotizacion",$id_cotizacion);
		$result=$this->db->get();
		$resultprod=$result->result();

		foreach ($resultprod as $value) {
			$data=[];
			$data=array("sale_id"=>$sale_id,"item_id"=>$value->item_id,"description"=>$value->description,"line"=>1,"quantity_purchased"=>$value->quantity_purchased,"item_cost_price"=>$value->item_cost_price,"item_unit_price"=>$value->item_unit_price,"fecha"=>date("Y-m-d"),"description"=>$value->description);
			$this->db->insert("phppos_sales_items",$data);
		}

	

		$resto=$total_final-$abono;
		$this->db->insert("phppos_abonos",array("sale_id"=>$sale_id,"abono"=>$abono,"resto"=>$resto,"forma_pago"=>$tipo_pago,"fecha"=>date("Y-m-d"),"cliente"=>$cliente,"total"=>$total_final));
		$id_abono=$this->db->insert_id();


		$this->db->where("id_cotizacion",$id_cotizacion);
		$this->db->update("phppos_cotizacion",array("sale_id"=>$sale_id));
		return $this->db->affected_rows();
	}
}