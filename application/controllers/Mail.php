<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('email');
	}

	public function sendMail(){

		$from = 'Tamara Espinoza';
		$to = $this->input->post('to');
		$subject = $this->input->post('subject');
		$message = $this->input->post('message');

		//configuracion para gmail
		$configGmail = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => 465,
			'smtp_user' => 'indicadores.calidadcbo@gmail.com',
			'smtp_pass' => 'indicadores',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		); 

		//cargamos la configuración para enviar con gmail
		$this->email->initialize($configGmail);
 
		$this->email->from($from);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();
		//con esto podemos ver el resultado
		var_dump($this->email->print_debugger());
	}
}