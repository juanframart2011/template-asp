<?php

require_once ("secure_area.php");

defined('BASEPATH') OR exit('No direct script access allowed');



class Pedidos extends Secure_area {

   public function __construct()

   {

      parent::__construct();

             $this->load->model('pedidos_model');  

   }

   public function eliminados()

   {

      $this->load->view("partial/header");
      $data['pedidos'] = $this->pedidos_model->pedidos_eliminados();
      $this->load->view('pedidos_eliminados',$data); 


   

   }

   public function index()

   {

      $this->load->view("partial/header");

         $data['pedidos'] = $this->pedidos_model->pedidos();

      $this->load->view('pedidos',$data); 


   

   }

   public function terminar()

   {
      $id_sales_items=$this->input->post("id_sales_items");
      $sale_id=$this->input->post("sale_id");
      $item_id=$this->input->post("item_id");

      $this->pedidos_model->terminar($id_sales_items,$sale_id,$item_id);

   }

   public function descripcion()

   {
      $id_sales_items=$this->input->post("id_sales_items");
      $sale_id=$this->input->post("sale_id");
      $item_id=$this->input->post("item_id");
      $descripcion=$this->input->post("descripcion");

   
      $this->pedidos_model->descripcion($id_sales_items,$sale_id,$item_id,$descripcion);

   }


   public function regresa_a_produccion()

   {

      $id_sales_items=$this->input->post("id_sales_items");
      $sale_id=$this->input->post("sale_id");
      $item_id=$this->input->post("item_id");

      $this->pedidos_model->regresa_a_produccion($id_sales_items,$sale_id,$item_id);

   }

   

     public function create()

   {

      $this->pedidos_model->insertar();



        

      echo 'insertado correctmanete';

   }

   public function poner_lista()

   {

      $datos=$this->pedidos_model->poner_lista();



        
      echo $datos;
      //echo 'insertado correctmanete';

   }

    public function eliminar()

   {

      $this->pedidos_model->eliminar();



        

      echo 'insertado correctmanete';

   }





   public function add()

   {

        $this->load->view("partial/header");  

      $this->load->view('create');

 

   }



   public function comentar()

   {
      $sale_id=$this->input->post('sale_id');

       

      $id_pedido=$this->input->post('id_pedido');

      $comentario=$this->input->post("comentario");
      $result=$this->pedidos_model->comentar($sale_id,$id_pedido,$comentario);
      echo $result;
   }

   public function imagen()

   {

      $this->pedidos_model->imagen();

   }

   public function delete()
   {
      $sale_id=$this->input->post("sale_id");
      $item_id=$this->input->post("item_id");

      $result=$this->pedidos_model->eliminar_item($sale_id,$item_id);
      echo $result;

   }




        







}



/* End of file pedidos.php */

/* Location: ./application/controllers/pedidos.php */





    