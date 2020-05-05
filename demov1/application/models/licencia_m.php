<?php
class licencia_m extends CI_Model
{
	/*
	Determines if a given item_id is an item
	*/
	function obtener($sale_id,$tipo_pago,$total_final,$resto,$abono,$cliente)
	{

		$fecha=date('Y-m-d');
		$data=array("sale_id"=>$sale_id,"forma_pago"=>$tipo_pago,"fecha"=>$fecha,"total"=>$total_final,"resto"=>$resto,"abono"=>$abono,"cliente"=>$cliente);		
		$this->db->insert("phppos_abonos",$data);

		$this->db->where("sale_id",$sale_id);
		$this->db->update("phppos_sales",array("total_venta"=>$total_final));

		return $this->db->insert_id();
	
	}

	function obtener_licencia()
	{
		date_default_timezone_set("America/Monterrey");

		$fecha=date('Y-m-d');
	
		$this->db->select("*,DATEDIFF(fecha_final,CURDATE()) dias, date_format(fecha_final,'%e %M %Y') final, day(fecha_final) dia, year(fecha_final) ano,
			CASE WHEN MONTH(fecha_final) = 1 THEN 'Enero'
			WHEN MONTH(fecha_final) = 2 THEN 'febrero'
			WHEN MONTH(fecha_final) = 3 THEN 'Marzo'
			WHEN MONTH(fecha_final) = 4 THEN 'Abril'
			WHEN MONTH(fecha_final) = 5 THEN 'Mayo'
			WHEN MONTH(fecha_final) = 6 THEN 'Junio'
			WHEN MONTH(fecha_final) = 7 THEN 'Julio'
			WHEN MONTH(fecha_final) = 8 THEN 'Agosto'
			WHEN MONTH(fecha_final) = 9 THEN 'Septiembre'
			WHEN MONTH(fecha_final) = 10 THEN 'Octubre'
			WHEN MONTH(fecha_final) = 11 THEN 'Noviembre'
			WHEN MONTH(fecha_final) = 12 THEN 'Diciembre'
			ELSE 'esto no es un mes' END AS mes",false);
		$this->db->from("phppos_licencia");
		$this->db->where("'$fecha'>=fecha_inicio",null,false);
		$this->db->where("'$fecha'<=fecha_final",null,false);
		$result=$this->db->get();
		return $result->row();
	
	}
}