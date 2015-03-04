<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Json extends CI_Controller 
{

    
    	public function exportexcelreport()
	{
		$this->userpost_model->exportexcelreport();
            
	}	
	
    public function login() 
	{
        $data = json_decode(file_get_contents('php://input'), true);
		$email=$data['email'];
		$password=$data['password'];
		$data['message']=$this->user_model->login($email,$password);
		$this->load->view('json',$data);
	}
    
    public function authenticate() 
	{
		$data['message']=$this->user_model->authenticate();
		$this->load->view('json',$data);
	}
    
    public function logout( )
	{
		$this->session->sess_destroy();
        $data['message']="true";
        $this->load->view('json',$data);
	}
    
}
//EndOfFile
?>