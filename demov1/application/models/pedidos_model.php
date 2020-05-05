<?php 



if (!defined('BASEPATH'))

                exit('No direct script access allowed');



class Pedidos_model extends CI_Model

{

     function __construct()

                {

                                parent::__construct();

                                $this->load->database();

                                

                                

                }

  public function terminar($id_sales_items=false, $sale_id=false,$item_id=false)
  {
    //$this->db->where("id_sales_items",$id_sales_items);
    $this->db->where("sale_id",$sale_id);
    $this->db->where("item_id",$item_id);
    $this->db->update("phppos_sales_items",array("hecho"=>1,"imagen"=>""));
    return $this->db->affected_rows();

  }

  public function descripcion($id_sales_items=false,$sale_id=false,$item_id=false,$descripcion=false)
  {
    
    $this->db->where("id_sales_items",$id_sales_items);
    $this->db->where("sale_id",$sale_id);
    $this->db->where("item_id",$item_id);
    $this->db->update("phppos_sales_items",array("description"=>$descripcion));
     
    return $this->db->affected_rows();
  }

  public function eliminar_item($sale_id=false,$item_id=false)
  {
    $data=array("sale_id"=>$sale_id,"item_id"=>$item_id);
    //$this->db->where("sale_id",$sale_id);
    //$this->db->where("item_id",$item_id);
    $this->db->delete("phppos_sales_items",$data);
    return $this->db->affected_rows();

  }

  public function regresa_a_produccion($id_sales_items=false,$sale_id=false,$item_id=false)
  {
    $this->db->where("id_sales_items",$id_sales_items);
    $this->db->where("sale_id",$sale_id);
    $this->db->where("item_id",$item_id);
    $this->db->update("phppos_sales_items",array("hecho"=>0));
    return $this->db->affected_rows();

  }

      public function pedidos()

                {

        

                $this->db->select('phppos_items.*,phppos_abonos.*,phppos_sales.*,phppos_sales_items.id_sales_items,phppos_sales_items.item_id,phppos_sales_items.id_pedido,phppos_sales_items.check,phppos_sales_items.hecho,phppos_sales_items.estado,  phppos_sales_items.description descripcion,phppos_sales_items.imagen imagen, FORMAT(phppos_sales_items.quantity_purchased,1) cantidad',false);

        $this->db->from('phppos_sales_items');

      //  $this->db->join('phppos_sales_items', 'phppos_sales_items.sale_id = phppos_sales_items.sale_id');

        $this->db->join('phppos_items', 'phppos_items.item_id = phppos_sales_items.item_id');

        $this->db->join('phppos_sales', 'phppos_sales.sale_id = phppos_sales_items.sale_id');

        $this->db->join('phppos_abonos','phppos_sales_items.sale_id=phppos_abonos.sale_id');


        $hoy = date("Y-m-d");     



       $this->db->where('phppos_sales_items.hecho <','1')->where('phppos_sales_items.cliente <>','<div');

       //->where('estado <>',"realizado")

      
        //$this->db->group_by("phppos_sales.sale_id");
        $this->db->group_by("phppos_sales_items.sale_id");
          $this->db->order_by('phppos_sales_items.sale_id DESC');
          $this->db->limit(20);
        $query = $this->db->get();

        return $query;

                }  

  public function pedidos_eliminados()

                {

        

                $this->db->select('phppos_items.*,phppos_abonos.*,phppos_sales.*,phppos_sales_items.id_sales_items,phppos_sales_items.item_id,phppos_sales_items.id_pedido,phppos_sales_items.check,phppos_sales_items.hecho,phppos_sales_items.estado,  phppos_sales_items.description descripcion,phppos_sales_items.imagen imagen, FORMAT(phppos_sales_items.quantity_purchased,1) cantidad',false);

        $this->db->from('phppos_sales_items');

      //  $this->db->join('phppos_sales_items', 'phppos_sales_items.sale_id = phppos_sales_items.sale_id');

        $this->db->join('phppos_items', 'phppos_items.item_id = phppos_sales_items.item_id');

        $this->db->join('phppos_sales', 'phppos_sales.sale_id = phppos_sales_items.sale_id');

        $this->db->join('phppos_abonos','phppos_sales_items.sale_id=phppos_abonos.sale_id');


        $hoy = date("Y-m-d");     



       $this->db->where('phppos_sales_items.hecho >',0,false);

       //->where('estado <>',"realizado")

      
          $this->db->group_by("phppos_sales_items.sale_id");
          $this->db->order_by('phppos_sales_items.sale_id DESC');
          $this->db->limit(20);
        $query = $this->db->get();

        return $query;

  }  


         public function pedidosn()

                {

                    $this->db->where('checked <>', 'checked');

            return $this->db->get('phppos_pedidos');



                }  

        public function insertar()

                 {

      $data = array(

         'sale_id' => $this->input->post('sale_id'), //capturo los datos que me envian desde la vista

         'estado' => $this->input->post('estado'),

         'id_pedido' => $this->input->post('id_pedido'),

         'check' => $this->input->post('checked')

         

      );

      $this->db->where('sale_id',$data['sale_id'])->where('item_id',$data['id_pedido']);

      return $this->db->update('phppos_sales_items', $data);

                 }



    public function poner_lista()

                 {

      //echo $this->input->post('sale_id')."<br>";
      $sale_id = str_replace("item", "", $this->input->post('sale_id'));
      //echo "sale".$sale_id;

      $data = array(

         'sale_id' => $sale_id, //capturo los datos que me envian desde la vista

         'estado' => 'norealizado',

         'hecho'=>0,

         'id_pedido' => $this->input->post('id_pedido'),

         'check' => $this->input->post('checked')

      );

      $this->db->where('sale_id',$data['sale_id']);
      $this->db->where('id_pedido',$data['id_pedido']);

      $this->db->update('phppos_sales_items', $data);
      return $this->db->affected_rows(); 

                 }

                 public function eliminar()

                 {

                       

   

      

      $data = array(

         'sale_id' => $this->input->post('sale_id'), //capturo los datos que me envian desde la vista

     

         'id_pedido' => $this->input->post('id_pedido'),

         'hecho' => 1

         

      );

      $this->db->where('sale_id',$data['sale_id'])->where('item_id',$data['id_pedido']);

      return $this->db->update('phppos_sales_items', $data);

                 }           







      public function busqueda_fecha()

                {

         $hasta =   $this->input->post('hasta');

         $desde = $this->input->post('desde');

          if (isset($desde)==false) {

            $desde = $hasta;

          }

          if (isset($hasta)==false) {

                    

                    $hasta = $desde;

          }

     



         $this->db->where('fecha BETWEEN "'.$desde. '" and "'.$hasta.'"');



                $this->db->select('*');

        $this->db->from('phppos_abonos');

        $this->db->join('phppos_items', 'phppos_items.item_id = phppos_abonos.item_id');

        $this->db->join('phppos_sales', 'phppos_sales.sale_id = phppos_abonos.sale_id');

        $hoy = date("Y-m-d");     

         



      

        $this->db->order_by('phppos_abonos.sale_id ASC');

        $query = $this->db->get();

        return $query;

                } 



                public function comentar($sale_id=false,$id_pedido=false, $comentario=false)

                {

                 

      $data = array(
         'sale_id' => $sale_id, //capturo los datos que me envian desde la vista
        'id_pedido' => $id_pedido,
         'comentarios' => $comentario  

      );

      $this->db->where('sale_id',$data['sale_id'])->where('item_id',$data['id_pedido']);

     $this->db->update('phppos_sales_items', $data);
     return $this->db->affected_rows();

                }

                public function nuevo_pedido($producto,$comentario,$fecha,$imagen)

                {

                    if ($imagen == null) {

                      var_dump($imagen);

                      exit();

                      //redirect('nuevo_pedido/index','refresh');

                    }else{



                      $data = array('producto' => $producto,

                              'comentario' => $comentario,

                              'fecha' => $fecha,

                               'foto' => $imagen );



                                  

                    

                               $this->db->insert('phppos_pedidos',$data);

   

                    }



                }

                public function ocultar()

                {

                  $id_pedido = $this->input->post('id_pedido');

                  $check = $this->input->post('checked');

                  $this->db->where('id_pedido', $id_pedido);

                  $this->db->update('phppos_pedidos', array('checked' => $check ));

                }

                public function taller()

                {

                  $id_pedido = $this->input->post('id_pedido');

                  $taller = $this->input->post('taller');

                  $this->db->where('id_pedido', $id_pedido);

                  $this->db->update('phppos_pedidos', array('taller' => $taller ));

                }

                public function isla()

                {

                  $id_pedido = $this->input->post('id_pedido');

                  $isla = $this->input->post('isla');

                  $this->db->where('id_pedido', $id_pedido);

                  $this->db->update('phppos_pedidos', array('isla' => $isla ));

                }

                public function entregado()

                {

                  $id_pedido = $this->input->post('id_pedido');

                  $entregado = $this->input->post('entregado');

                  $this->db->where('id_pedido', $id_pedido);

                  $this->db->update('phppos_pedidos', array('entregado' => $entregado ));

                }

                public function imagen()

                {

                  $sale_id = $this->input->post('id');

                  $item_id = $this->input->post('item_id');

                  $imagen = $this->input->post('img');

                  $display = $this->input->post('displ');

                  $editable = $this->input->post('edita');

                  $this->db->where('sale_id',$sale_id)->where('item_id', $item_id);

            $this->db->update('phppos_sales_items', array('imagen' => $imagen,'display'=>$display));

                }



   }







