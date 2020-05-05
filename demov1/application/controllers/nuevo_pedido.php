<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Nuevo_pedido extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('pedidos_model');
	}
	public function index()
	{
		$this->load->view('header');
		$data['pedidos'] = $this->pedidos_model->pedidosn();
		$this->load->view('npedido',$data);
	}
	     function nuevo() 
         {
        

        $this->load->library('form_validation');
        $mi_archivo = 'mi_archivo';
        $config['upload_path'] = "uploads/";
        $config['file_name'] = $_FILES['mi_archivo']['name'];
        $config['allowed_types'] = '*';
        $config['max_size'] = "500000";
        $config['max_width'] = "20000";
        $config['max_height'] = "20000";
        $this->load->library('upload', $config);
        $this->upload->initialize($config);      
        if($config["file_name"]==null){

            echo 'Selecione imagen';

            

        }

        if (!$this->upload->do_upload($mi_archivo)) {

            //*** ocurrio un error

            $data['uploadError'] = $this->upload->display_errors();

            echo $this->upload->display_errors();
            echo "ERROR";
            return;

        }


        $data['uploadSuccess'] = $this->upload->data();

        $imagen2= $_FILES['mi_archivo']['name'];
        $imagen = str_replace(" ", "_",$imagen2);

    

        //$id_publicacion=$this->input->post("id_publicacion");

        $producto=$this->input->post("producto");
        $comentario=$this->input->post("comentario");
        $fecha=$this->input->post("fecha");
 

        


        $datos['data']=$this->pedidos_model->nuevo_pedido($producto,$comentario,$fecha,$imagen);


    //    header('Location: http://www.vitanui.com.mx/index.php/home/blog');

       redirect('nuevo_pedido/index');
        

    }
    public function ocultar()
    {
          
       
    $this->pedidos_model->ocultar();  
    }
    public function taller()
    {
          
       
    $this->pedidos_model->taller();  
    }
    public function isla()
    {
          
       
    $this->pedidos_model->isla();  
    }   
    public function entregado()
    {
          
       
    $this->pedidos_model->entregado();  
    }       

}

/* End of file nuevo_pedido.php */
/* Location: ./application/controllers/nuevo_pedido.php */

 ?>