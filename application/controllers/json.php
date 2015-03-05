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
		$data['message']=$this->json_model->login($email,$password);
		$this->load->view('json',$data);
	}
    
    public function authenticate() 
	{
		$data['message']=$this->json_model->authenticate();
		$this->load->view('json',$data);
	}
    
    public function logout( )
	{
		$this->session->sess_destroy();
        $data['message']="true";
        $this->load->view('json',$data);
	}
    
    public function usersdetail() 
    {
         $data['message']=$this->json_model->getstudentdash();
         $this->load->view('json',$data);
    }
    function viewleaderboard()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$data['page']='viewleaderboard';
        $data['base_url'] = site_url("site/viewleaderboardjson");
        
		$data['title']='View leaderboard';
		$this->load->view('template',$data);
	} 
    function viewleaderboardjson()
	{
		$access = array("1","2");
		$this->checkaccess($access);
        
//        SELECT IFNULL(SUM(`userpost`.`share`+`userpost`.`likes`+`userpost`.`comment`+`userpost`.`retweet`+`userpost`.`favourites`),0) as `score`, `user`.`name`,`user`.`id`,`user`.`email`,IFNULL(SUM(`userpost`.`share`+`userpost`.`likes`+`userpost`.`comment`),0) as `facebook`,IFNULL(SUM(`userpost`.`retweet`+`userpost`.`favourites`),0) as `twitter` FROM `user` LEFT OUTER JOIN `userpost` ON `user`.`id`=`userpost`.`user` GROUP BY `user`.`id`
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`user`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`user`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`user`.`email`";
        $elements[2]->sort="1";
        $elements[2]->header="Email";
        $elements[2]->alias="email";
        
        $elements[3]=new stdClass();
        $elements[3]->field="IFNULL(SUM(`userpost`.`share`+`userpost`.`likes`+`userpost`.`comment`+`userpost`.`retweet`+`userpost`.`favourites`),0)";
        $elements[3]->sort="1";
        $elements[3]->header="Score";
        $elements[3]->alias="score";
        
        $elements[4]=new stdClass();
        $elements[4]->field="IFNULL(SUM(`userpost`.`share`+`userpost`.`likes`+`userpost`.`comment`),0)";
        $elements[4]->sort="1";
        $elements[4]->header="Facebook";
        $elements[4]->alias="facebook";
        
        $elements[5]=new stdClass();
        $elements[5]->field="IFNULL(SUM(`userpost`.`retweet`+`userpost`.`favourites`),0)";
        $elements[5]->sort="1";
        $elements[5]->header="Twitter";
        $elements[5]->alias="twitter";
       
        $elements[6]=new stdClass();
        $elements[6]->field="`user`.`rank`";
        $elements[6]->sort="1";
        $elements[6]->header="Rank";
        $elements[6]->alias="rank";
       
        
        $elements[7]=new stdClass();
        $elements[7]->field="`college`.`name`";
        $elements[7]->sort="1";
        $elements[7]->header="College";
        $elements[7]->alias="college";
       
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="rank";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` LEFT OUTER JOIN `userpost` ON `user`.`id`=`userpost`.`user` LEFT OUTER JOIN `college` ON `college`.`id`=`user`.`college` ","WHERE `user`.`accesslevel`=2","GROUP BY `user`.`id`","","");
        
		$this->load->view("json",$data);
	} 
}
//EndOfFile
?>