<?php
class facturas_m extends CI_Model
{
	/*
	Determines if a given item_id is an item
	*/
	function obtener_datos_mi_empresa()
	{
		$this->db->from('phppos_datos_facturacion');		
		$query = $this->db->get();
		return $query->result();	
	
	}

	function obtener_razon()
	{
		$this->db->from("phppos_people");
		$this->db->where("phppos_people.person_id",1);
		$result=$this->db->get();
		return $result->row();
	}

	function obtener_correo()
	{
		$this->db->from('phppos_locations');	
		$this->db->where("location_id",1);	
		$query = $this->db->get();
		return $query->row();	
	
	}

	function prueba($fecha=false)
	{
		echo $fecha;
		$this->load->helper('date');
				$date1=date_create($fecha);
				$fecha1=date_format($date1,"Y-m-d H:i:s");

				$date2=date_create($fecha.' 23:59:59');	
				$fecha2=date_format($date2,"Y-m-d H:i:s");

		$this->db->select("*",false);
		$this->db->from("phppos_sales");
		$this->db->where("sale_time <=",$fecha2);
		$this->db->where("sale_time >=",$fecha1);
		//$this->db->where("factura",0);
		$result=$this->db->get();
		return $result->row();

				/*
				$this->db->where("sale_time <=",$fecha2,false);
				$this->db->where("sale_time >=",$fecha1,false);
				
				


				$this->db->update("phppos_sales",array("factura"=>1));
*/
	}

	function buscar_email($rfc=false)
	{
		$this->db->select("*",false);
		$this->db->from("phppos_people");
		$this->db->where("phppos_people.rfc",$rfc);
		$result=$this->db->get();
		return $result->row();
	}

	function buscar_rfc($rfc)
	{
		$this->db->select("rfc",false);
		$this->db->from("phppos_people");
		$this->db->where("person_id!=",1,false);
		$this->db->like("rfc",$rfc);
		//$this->db->like("rfc",'%$rfc%');
		$result=$this->db->get();		
		return $result->result();
				
	}

	function buscar_facturas($rfc=false,$sale_id=false)
	{
		$this->db->select("person_id");
		$this->db->from("phppos_people");
		$this->db->where("rfc",$rfc);
		$result=$this->db->get();
		$person_id=$result->row()->person_id;
		$this->db->flush_cache();


		$this->db->select("phppos_facturas.id_factura, phppos_facturas.person_id,phppos_facturas.sale_id, phppos_people.razon_social, phppos_facturas.fecha_timbrado, REPLACE(phppos_sales.payment_type,'<br />','')as total",false);
		$this->db->from("phppos_facturas");
		$this->db->join("phppos_people","phppos_facturas.person_id=phppos_people.person_id");		
		$this->db->join("phppos_sales","phppos_facturas.sale_id=phppos_sales.sale_id");
		if($rfc)		
			$this->db->where("phppos_facturas.person_id",$person_id);
		if($sale_id)
			$this->db->where("phppos_facturas.sale_id",$sale_id);
		$this->db->order_by("fecha_timbrado","ASC");
		$result=$this->db->get();
		//return $result->result();

		if($result->num_rows()>1){
			return $result->result();
		}else{
			return $result->row();
		}


	}



	function cambiar_rfc_mostrador($rfc)
	{
		$this->db->select("rfc");
		$this->db->from("phppos_people");
		$this->db->where("rfc",$rfc);
		$result=$this->db->get();
		if(!$result->row()->rfc)			
			return false;

		$this->db->update("phppos_people",array("factura_diaria"=>0));
		$this->db->flush_cache();

		$this->db->where("phppos_people.rfc",$rfc);
		$this->db->update("phppos_people",array("factura_diaria"=>1));

		$updated_status = $this->db->affected_rows();

		if($updated_status):
		    return 1;
		else:
		    return null;
		endif;

	}

	function buscar_venta($sale_id)
	{
		$this->db->select("*",false);
		$this->db->from("phppos_facturas");

		$this->db->where("sale_id",$sale_id);
		$result=$this->db->get();
		$total=$result->num_rows();
		
		//$this->db->flush_cache();

		if($total==0 || $total=="0"){
			$this->db->select("*,REPLACE(phppos_sales.payment_type,'<br />','')as total",false);
			$this->db->from("phppos_sales");
			$this->db->join("phppos_people","phppos_sales.customer_id=phppos_people.person_id");
			$this->db->where("phppos_sales.sale_id",$sale_id);
			$result=$this->db->get();
			return $result->row();
		}

		return $total;

		
	}

	function obtener_facturas_mostrador($id_factura)
	{
		if($id_factura){
			$this->db->select("phppos_facturas.*,phppos_people.*",false);
		}else{
			$this->db->select("phppos_facturas.*,phppos_people.*,CONCAT('$',FORMAT(total_factura_mostrador,2))as total_factura_mostrador ",false);
		}
		
		$this->db->from("phppos_facturas");
		$this->db->join("phppos_people","phppos_facturas.person_id=phppos_people.person_id");
		if($id_factura)
			$this->db->where("phppos_facturas.id_factura",$id_factura);
		$this->db->where("phppos_facturas.factura_mostrador",1);
		$this->db->order_by("phppos_facturas.fecha_timbrado","ASC");
		$result=$this->db->get();
		if($id_factura)
			return $result->row();
		return $result->result();
	}

	function total_venta_mostrador($fecha=false)
	{



		/*
$this->db->select_sum('column_name')
         ->from('table_name')
         ->where("DATE_FORMAT(column_name,'%Y-%m') <","YYYY-MM")
         ->get();
*/
	$this->db->select("FORMAT(sum( phppos_sales_items.item_unit_price * phppos_sales_items.quantity_purchased ),2) as total",false);
	$this->db->from("phppos_sales_items");
	$this->db->join("phppos_sales","phppos_sales.sale_id = phppos_sales_items.sale_id");	
	$this->db->where("DATE_FORMAT(phppos_sales.sale_time,'%Y-%m-%d')=",$fecha);
	$this->db->where("phppos_sales.deleted",0);
	$this->db->where("phppos_sales.suspended",0);
	$this->db->where("phppos_sales.factura",0);
	$result=$this->db->get();
	
	if($result->num_rows()>1){
			return $result->result();
		}else{
			return $result->row();
		}

	}

	function obtener_datos_empresa($person_id=false)
	{
		$this->db->from("phppos_people");
		if($person_id){
			$this->db->where("person_id",$person_id);
		}else{
			$this->db->where("factura_diaria",1);
		}
		$result=$this->db->get();
		
		return $result->result();
	}

	function obtener_productos($sale_id)
	{
		$this->db->select("phppos_items.item_id, phppos_items.name, phppos_items.unity, phppos_sales_items.quantity_purchased,  phppos_sales_items.item_unit_price as unit_price, (phppos_sales_items.quantity_purchased* phppos_sales_items.item_unit_price)-( phppos_sales_items.item_unit_price*0.16) as importe, ( phppos_sales_items.item_unit_price*0.16) as iva ");
		$this->db->from("phppos_items");
		$this->db->join("phppos_sales_items","phppos_items.item_id=phppos_sales_items.item_id");
		$this->db->join("phppos_sales","phppos_sales_items.sale_id=phppos_sales.sale_id");		
		$this->db->where("phppos_sales.sale_id",$sale_id);
		$result=$this->db->get();
		return $result->result();
	}

	function logo()
	{
		$this->db->select("file_id,file_name,file_data",false);
		$this->db->from("phppos_app_files");
		$this->db->where("file_id",1);
		$result=$this->db->get();
		return $result->row();
	}

	function guardar_factura($fecha_venta,$sale_id,$person_id,$factura_mostrador,$total_factura_mostrador,$condiciones_pago,$metodo_pago,$tc,$forma_pago,$numero_cuenta,$descuento,$motivo_descuento,$tipo_impuesto_traslado,$tasa_impuesto_traslado,$importe_impuesto_traslado,$tipo_inmpuesto_retencion,$importe_impuesto_retencion,  $cadena_original,$sello_digital_cfd,$sello_sat,$sello_cfd,$uuid,$num_certificado_sat,$num_certificado_emisor,$fecha_timbrado)
	{
		$this->load->helper('date');
		$data=array("sale_id"=>$sale_id,"factura_mostrador"=>$factura_mostrador,"total_factura_mostrador"=>$total_factura_mostrador,"person_id"=>$person_id, "condiciones_pago"=>$condiciones_pago,"metodo_pago"=>$metodo_pago,"tc"=>$tc,"forma_pago"=>$forma_pago,"numero_cuenta"=>$numero_cuenta,"descuento"=>$descuento,"motivo_descuento"=>$motivo_descuento,"tipo_impuesto_traslado"=>$tipo_impuesto_traslado,"tasa_impuesto_traslado"=>$tasa_impuesto_traslado,"importe_impuesto_traslado"=>$importe_impuesto_traslado,"tipo_impuesto_retencion"=>$tipo_impuesto_retencion,"importe_impuesto_retencion"=>$importe_impuesto_retencion, "cadena_original"=>$cadena_original,"sello_digital_cfd"=>$sello_digital_cfd,"sello_sat"=>$sello_sat,"sello_cfd"=>$sello_cfd,"uuid"=>$uuid,"num_certificado_sat"=>$num_certificado_sat,"num_certificado_emisor"=>$num_certificado_emisor,"fecha_timbrado"=>$fecha_timbrado);
		$this->db->insert("phppos_facturas",$data);
			if($this->db->insert_id()==0){

			    return	$this->db->_error_message();
			}

			$id=$this->db->insert_id();

			if($factura_mostrador){
				
				

				$date1=date_create($fecha_venta);
				$fecha1=date_format($date1,"Y-m-d H:i:s");

				$date2=date_create($fecha_venta.' 23:59:59');	
				$fecha2=date_format($date2,"Y-m-d H:i:s");

				$this->db->where("sale_time <=",$fecha2);
				$this->db->where("sale_time >=",$fecha1);
				
				$this->db->where("factura",0);
				$data=array("factura"=>1);

				$this->db->update("phppos_sales",$data);
			}else{
				$data=array("factura"=>1);
				$this->db->where("sale_id",$sale_id);
				$this->db->update("phppos_sales",$data);
			}

/*
			if($id!=0 || $id!=null || $id!=""){
				
			}else{
				

			}
			
*/		
		return $fecha2;
		
	}

	function url()
	{
		$key="key";
		$this->db->select("*",false);
		$this->db->from("phppos_app_config");
		$this->db->where('key',"url");
		$result=$this->db->get();
		return $result->row()->value;
	}

	function obtener_factura($sale_id=null)
	{
		$this->db->select("*",false);
		$this->db->from("phppos_facturas");
		$this->db->where("sale_id",$sale_id);
		$this->db->order_by("fecha_timbrado",ASC);
		$result=$this->db->get();
		return $result->result();
	}
}
