<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Json extends CI_Controller 
{

    
    	public function exportexcelreport()
	{
		$this->userpost_model->exportexcelreport();
            
	}	
	
    
}
//EndOfFile
?>