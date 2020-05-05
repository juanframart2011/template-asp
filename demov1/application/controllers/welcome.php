<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once ("secure_area.php");
class Welcome extends Secure_area {
	  function __construct()
    {
    	   parent::__construct();
    	 $this->load->helper('form');
		 $this->load->library('form_validation');
		 $this->load->model('pedidos');
    		
    }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view("partial/header");
		$data['pedidos'] = $this->Pedidos_model->pedidos();
		
	    $this->load->view('pedidos',$data); 
		   //$this->load->view('create');
	}
	  public function create()
   {
      $this->Pedidos_model->insertar();

        
      echo 'insertado correctmanete';
   }

   public function add()
   {
   	  $this->load->view("partial/header");  
      $this->load->view('create');
 
   }

   public function comentar()
   {
      $this->Pedidos_model->comentar();
   }

	   public function abono()
   {
      $this->pedidos->abono();
      $this->pedidos->abonoi();
       $this->pedidos->abonos();
        
      echo 'insertado correctmanete';
   }
   public function abonar()
   {
   	 $this->pedidos->abonar();
     $this->pedidos->abonarin();
   
   		$this->pedidos->abonar2();
   		$this->pedidos->abonar3();
   }
   
   public function reportes($id = null)
   {
    $data['segmento'] = $id;
     if (!$data['segmento']) {
                 
               
                $this->load->view("partial/header");
    $data['pedidos'] = $this->pedidos->reportes();
    $data2['pedidos'] = $this->pedidos->total();
    $this->load->view('reportes',$data);
   $this->load->view('total',$data2);
                } else {
                  
                  $this->load->view("partial/header");
     $data['pedidos'] = $this->pedidos->reporte($data['segmento']);
    $data2['pedidos'] = $this->pedidos->totale($data['segmento']);
    $this->load->view('reportes',$data);
   $this->load->view('totali',$data2);
                }

    
   }
    public function tarjeta()
   {
      $this->pedidos->regalo();
   }
   function buscar(){
        $this->load->view("partial/header");
     $date1 = $this->input->post('fecha1');   // 02-06-2015
     $date2 = $this->input->post('fecha2');   // 19-06-2015

     $data['pedidos']  = $this->pedidos->buscar($date1,$date2);
     $this->load->view('reportes',$data);
      $this->load->view('total',$data);
    
  }
  
  public function status()
  {
    $this->pedidos->status();
  }
  public function enviar(){
      $from = (htmlentities($this->input->post('email')));
    $nombre =(htmlentities($this->input->post('nombre')));
    $mensaje =(htmlentities($this->input->post('comentario')));
    $celular =(htmlentities($this->input->post('celular')));

  
    $this->load->library('email');
    $this->email->to('gruposyfors@gmail.com');


    $this->email->cc('gruposyfors@gmail.com');
    $this->email->from($from ,$nombre);
    //$this->email->bcc('them@their-example.com');

    $this->email->subject('Contacto desde Syprint | numero de telefono del cliete: '.$celular);
    $this->email->message($mensaje);

    $this->email->send();
   }    
}
