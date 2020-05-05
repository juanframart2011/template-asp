<?php 





if (!defined('BASEPATH'))

                exit('No direct script access allowed');



class Pedidos extends CI_Model

{

 public function __construct()

    {

      parent::__construct();

      $this->load->database();

      

    }

                  public function abono()

                   {

                    $data = array(

                    'sale_id' => $this->input->post('sale_id'),

                    'item_id' => $this->input->post('item_id'),

                    'abono' => $this->input->post('total'),

                    'resto' => $this->input->post('resto'),

                    'forma_pago' => $this->input->post('tipo') ,

                    'total'=>$this->input->post('total_final'),

                    'fecha' => date("Y-m-d"),

                    'cliente' =>$this->input->post('cliente'),

                    'precio' =>$this->input->post('preci'),

                   

                  //  'item_cost_price' => $this->input->post('precio2')

                     );



                     // $this->db->where('sale_id',$data['sale_id']);

               $this->db->insert('phppos_abonos', $data);

              

            }

            public function abonos()

                   {

                    $data = array(

                    'sale_id' => $this->input->post('sale_id'),

                  

                    'abono' => $this->input->post('total'),

                    'resto' => $this->input->post('resto'),

            

                    'fecha' => date("Y-m-d"),

                    'cliente' =>$this->input->post('cliente'),

                   

                  //  'item_cost_price' => $this->input->post('precio2')

                     );



                     // $this->db->where('sale_id',$data['sale_id']);



               $this->db->insert('phppos_abonos2', $data);

            }



                 public function abonoi()

                   {

                    $data = array(



                    'sale_id' => $this->input->post('sale_id'),

                    

                    'resto' => $this->input->post('resto'),



                    'cliente' => $this->input->post('cliente'),

                    'payment_type3' => $this->input->post('tipo') ,

                    'total' => $this->input->post('total')

                  //  'item_cost_price' => $this->input->post('precio2')

                     );



                      $this->db->where('sale_id',$data['sale_id']);

              return $this->db->update('phppos_sales_items', $data);

                   }  

                   public function chats()

                   {

                      $hoy = date("Y-m-d");

                      $this->db->where('fecha',$hoy);

                            $this->db->order_by('hora DESC');

                     return $this->db->get('phppos_chat');

                   }

                   public function chat()

                   {

                     $data = array(

                      'usuario' => $this->input->post('usuario'),

                      'mensaje' => $this->input->post('mensaje'),

                      'fecha' => date("Y-m-d")   

                      

                      );

                   return  $this->db->insert('phppos_chat',$data);

                   }

                   public function pedidos()

                {

        

                $this->db->select('*');

        $this->db->from('phppos_abonos');

     //   $this->db->join('phppos_items', 'phppos_items.item_id = phppos_abonos.item_id');

        

        $this->db->join('phppos_sales', 'phppos_sales.sale_id = phppos_abonos.sale_id');

       // $this->db->join('phppos_sales_payments', 'phppos_sales_payments.sale_id = phppos_abonos.sale_id');

          

      //  $hoy = date("Y-m-d");     



           $this->db->where('phppos_abonos.entregado <>','checked')->where('phppos_abonos.cliente <>',' ');

      

          $this->db->order_by('phppos_abonos.sale_id DESC');

        $query = $this->db->get();

        return $query;

                }  

           

                public function abonar()

                {





                 $data = array(

         'sale_id' => $this->input->post('sale_id'),

         'abono' => $this->input->post('total'),

         'resto' => $this->input->post('resto'),

         

       );

                 

      $this->db->where('sale_id',$data['sale_id']);

       $this->db->update('phppos_abonos', array('abono' => $data['abono'], 'resto' => $data['resto']));



                }

                public function abonarin()

                {





                 $data = array(

         'sale_id' => $this->input->post('sale_id'),

         'abono' => $this->input->post('costo'),

         'resto' => $this->input->post('resto'),

         'fecha' => date("Y-m-d"),

         'cliente' => $this->input->post('cliente')

          

       //  'id_pedido' => $this->input->post('id_pedido'),

          

         

       //  'item_cost_price' => $this->input->post('costo')

          

         

      );

                 

   

      return $this->db->insert('phppos_abonos2', $data);



                }

                    public function abonar2()

                {



/*

                 $data = array(

         'sale_id' => $this->input->post('sale_id'),

          'payment_type' => $this->input->post('tipop'),

         

       //  'item_cost_price' => $this->input->post('costo')

          

         

      );

                 

      $this->db->where('sale_id',$data['sale_id']);

      return $this->db->update('phppos_sales', $data);

*/

                }

                  public function status()

                {





                 $data = array(

         'sale_id' => $this->input->post('sale_id'),

          'entregado' => $this->input->post('entregado'),

         

       //  'item_cost_price' => $this->input->post('costo')

          

         

      );

                  var_dump($data['sale_id']);

      $this->db->where('sale_id',$data['sale_id']);

      return $this->db->update('phppos_abonos', array('entregado' => $data['entregado']));



                }

                     public function abonar3()

                {



/*

                 $data = array(

         'sale_id' => $this->input->post('sale_id'),

          'payment_amount' => $this->input->post('total'),

         

       //  'item_cost_price' => $this->input->post('costo')

          

         

      );

                 

      $this->db->where('sale_id',$data['sale_id']);

      return $this->db->update('phppos_sales_payments', $data);*/



                }

                public function reportes()

                {

              $this->db->select('*');

        $this->db->from('phppos_abonos2');

     //   $this->db->select('sale_id,(select  sum(total)) as total_pago');

        

     //   $this->db->join('phppos_items', 'phppos_items.item_id = phppos_sales_items.item_id');

        

       // $this->db->join('phppos_sales', 'phppos_sales.sale_id = phppos_sales_items.sale_id');

      //  $this->db->join('phppos_sales_payments', 'phppos_sales_payments.sale_id = phppos_sales_items.sale_id');

          

      //  $hoy = date("Y-m-d");     



          $this->db->where('phppos_abonos2.cliente <>',' ');

      

          $this->db->order_by('phppos_abonos2.sale_id DESC');

        $query = $this->db->get();

        return $query;

        

    

                }  

                public function reporte($id)

                {

              $this->db->select('*');

        $this->db->from('phppos_abonos2');

     //   $this->db->select('sale_id,(select  sum(total)) as total_pago');

        

     //   $this->db->join('phppos_items', 'phppos_items.item_id = phppos_sales_items.item_id');

        

       // $this->db->join('phppos_sales', 'phppos_sales.sale_id = phppos_sales_items.sale_id');

      //  $this->db->join('phppos_sales_payments', 'phppos_sales_payments.sale_id = phppos_sales_items.sale_id');

          

      //  $hoy = date("Y-m-d");     



        $this->db->where('phppos_abonos2.sale_id ',$id);



      

          $this->db->order_by('phppos_abonos2.sale_id DESC');

        $query = $this->db->get();

        if ($query->num_rows() > 0)

                                                return $query;

                                else

                                                return false;

        

        

    

                }  

                  public function total()

                {

              $this->db->select('sum(abono) as total_pago',false);

        $this->db->from('phppos_abonos2');

     //   $this->db->select('sale_id,(select  sum(total)) as total_pago');

        

     //   $this->db->join('phppos_items', 'phppos_items.item_id = phppos_abonos2.item_id');

        

       // $this->db->join('phppos_sales', 'phppos_sales.sale_id = phppos_abonos2.sale_id');

      //  $this->db->join('phppos_sales_payments', 'phppos_sales_payments.sale_id = phppos_abonos2.sale_id');

          

      //  $hoy = date("Y-m-d");     



          $this->db->where('phppos_abonos2.cliente <>',' ');

      

                  $this->db->select('sum(abono) as total_pago,sum(resto) as total_resto',false);

        $query = $this->db->get();

        return $query;

        

    

                }  

                 public function totale($id)

                {

              $this->db->select('sum(abono) as total_pago',false);

       $this->db->from('phppos_abonos2');

       $this->db->where('phppos_abonos2.sale_id ',$id);

       $this->db->select('sum(abono) as total_pago',false);

        $query = $this->db->get();

        return $query;

        

    

                }  

                 public function regalo()

                {

                  $data = array('value' => $this->input->post('regalo'),

                  'customer_id' => $this->input->post('id_cliente'));

                  $customer_id = $data['customer_id'];

                     

                     $query = $this->db->get_where('phppos_giftcards', array('customer_id' => $data['customer_id']

                                ));

                              if (sizeof($query->result()) >= 1) {



                

                              

                        

                              

                                $valor = $data['value'];

                                //$value = $valor + $valuedb; 

                                $value = $this->db->set('value',"value + $valor",false);

                                $this->db->where('customer_id', $customer_id);

                                $this->db->update('phppos_giftcards');                           

                              /*  $this->db->set('value', "value+1", FALSE);

                              $this->db->where('customer_id',$customer_id);

                              $this->db->update('phppos_giftcards', $data);

*/





                              }else{

                                   $this->db->insert('phppos_giftcards', $data);

                    

                              }

                  

                }

                public function buscar($date1,$date2)

                {

                  

                  if (!($date1) && !($date1) ) {

                       

                         $this->db->select('*');

                 

                  $this->db->from('phppos_abonos2');

                  $this->db->group_by('phppos_abonos2.sale_id DESC');

                   $this->db->select('sum(abono) as total_pago,sum(resto) as total_resto',false);



                    $query = $this->db->get();

                  return $query;

                  }else{





                  $this->db->where('fecha BETWEEN "'.$date1. '" and "'.$date2.'"')->where('phppos_abonos2.cliente <>',' ');

                  $this->db->select('*');

                 

                  $this->db->from('phppos_abonos2');

                  $this->db->group_by('phppos_abonos2.sale_id DESC');

                   $this->db->select('sum(abono) as total_pago,sum(resto) as total_resto',false);

                    $query = $this->db->get();

                  return $query;

                  }



             

             

          



                 

                }

                 

                

}

 ?>