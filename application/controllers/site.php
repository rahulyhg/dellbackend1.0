<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller 
{
	public function __construct( )
	{
		parent::__construct();
		
		$this->is_logged_in();
	}
	function is_logged_in( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
			redirect( base_url() . 'index.php/login', 'refresh' );
		} //$is_logged_in !== 'true' || !isset( $is_logged_in )
	}
	function checkaccess($access)
	{
		$accesslevel=$this->session->userdata('accesslevel');
		if(!in_array($accesslevel,$access))
			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
        if($accesslevel==2)
        {
            $data[ 'facebook' ] = $this->session->userdata("facebook")=="";
            $data[ 'twitter' ] = $this->session->userdata("twitter")=="";
            if(!$data['twitter'] && !$data[ 'facebook' ])
            {
            }
            else
            {
                if($this->uri->segment(2)=="index")
                {
                }
                else
                {
                    redirect('/site/index/', 'refresh');
                }
            }
        }
	}
	public function index()
	{
		$access = array("1","2");
		$this->checkaccess($access);
        if($this->session->userdata("accesslevel")==1)
        {
            $data[ 'page' ] = 'dashboard';
            $data['base_url'] = site_url("site/viewleaderboardjson");
            $data['totalcompassadors'] = $this->user_model->gettotalcompassadors();
            $data['admindash'] = $this->userpost_model->getadmindash();
            $data['title']='Admin Dashboard';
            $this->load->view('template',$data);
        }
        elseif($this->session->userdata("accesslevel")==2)
        {
		$data[ 'title' ] = 'Welcome';
        $data[ 'facebook' ] = $this->session->userdata("facebook")=="";
        $data[ 'twitter' ] = $this->session->userdata("twitter")=="";
            if(!$data['twitter'] && !$data[ 'facebook' ])
            {
                $data[ 'page' ] = 'normaluserdashboard';
                
                $data['base_url'] = site_url("site/viewleaderboardjson");
//                $data['totalcompassadors'] = $this->user_model->gettotalcompassadors();
                $data['studentdash'] = $this->userpost_model->getstudentdash();
                $data['title']='Student Dashboard';
                $data["quickposts"]=$this->post_model->viewquickpost();
                
                $this->load->view( 'template', $data );	
            }
            else
            {
                $data[ 'page' ] = 'checkfacebooktwitter';
                $data[ 'nomenu' ] = 'true';
                $this->load->view( 'template', $data );	
            }
        }
		
            
	}
	public function createuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data[ 'sex' ] =$this->user_model->getsexdropdown();
		$data[ 'college' ] =$this->college_model->getcollegedropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
//        $data['category']=$this->category_model->getcategorydropdown();
		$data[ 'page' ] = 'createuser';
		$data[ 'title' ] = 'Create User';
		$this->load->view( 'template', $data );	
	}
	function createusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
//		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('contact','contact','trim');
		$this->form_validation->set_rules('facebookid','facebookid','trim');
		$this->form_validation->set_rules('twitterid','twitterid','trim');
		$this->form_validation->set_rules('instagramid','instagramid','trim');
		$this->form_validation->set_rules('dob','dob','trim');
		$this->form_validation->set_rules('sex','sex','trim');
		$this->form_validation->set_rules('college','college','trim');
		$this->form_validation->set_rules('city','city','trim');
//		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data[ 'sex' ] =$this->user_model->getsexdropdown();
            $data[ 'college' ] =$this->college_model->getcollegedropdown();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
    //        $data['category']=$this->category_model->getcategorydropdown();
            $data[ 'page' ] = 'createuser';
            $data[ 'title' ] = 'Create User';
            $this->load->view( 'template', $data );		
		}
		else
		{
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $password=$this->input->post('password');
            $accesslevel=$this->input->post('accesslevel');
//            $status=$this->input->post('status');
            $contact=$this->input->post('contact');
            $facebookid=$this->input->post('facebookid');
            $twitterid=$this->input->post('twitterid');
            $instagramid=$this->input->post('instagramid');
            $dob=$this->input->post('dob');
            $sex=$this->input->post('sex');
            $college=$this->input->post('college');
            $city=$this->input->post('city');
            
			if($dob != "")
			{
				$dob = date("Y-m-d",strtotime($dob));
			}
            
			if($this->user_model->create($name,$email,$password,$accesslevel,$contact,$facebookid,$twitterid,$instagramid,$dob,$sex,$college,$city)==0)
			$data['alerterror']="New user could not be created.";
			else
			$data['alertsuccess']="User created Successfully.";
			$data['redirect']="site/viewusers";
			$this->load->view("redirect",$data);
		}
	}
    function viewusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewusers';
        $data['base_url'] = site_url("site/viewusersjson");
        
		$data['title']='View Users';
		$this->load->view('template',$data);
	} 
    function viewusersjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
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
        $elements[3]->field="`user`.`contact`";
        $elements[3]->sort="1";
        $elements[3]->header="Contact";
        $elements[3]->alias="contact";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`user`.`timestamp`";
        $elements[4]->sort="1";
        $elements[4]->header="Timestamp";
        $elements[4]->alias="timestamp";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`user`.`dob`";
        $elements[5]->sort="1";
        $elements[5]->header="Dob";
        $elements[5]->alias="dob";
       
        $elements[6]=new stdClass();
        $elements[6]->field="`accesslevel`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="Access level";
        $elements[6]->alias="accesslevelname";
       
        $elements[7]=new stdClass();
        $elements[7]->field="`user`.`facebookid`";
        $elements[7]->sort="1";
        $elements[7]->header="Facebookid";
        $elements[7]->alias="facebookid";
       
        $elements[8]=new stdClass();
        $elements[8]->field="`user`.`twitterid`";
        $elements[8]->sort="1";
        $elements[8]->header="twitterid";
        $elements[8]->alias="twitterid";
       
        $elements[9]=new stdClass();
        $elements[9]->field="`user`.`instagramid`";
        $elements[9]->sort="1";
        $elements[9]->header="instagramid";
        $elements[9]->alias="instagramid";
       
        
        $elements[10]=new stdClass();
        $elements[10]->field="`user`.`city`";
        $elements[10]->sort="1";
        $elements[10]->header="city";
        $elements[10]->alias="city";
       
        
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
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` LEFT OUTER JOIN `accesslevel` ON `accesslevel`.`id`=`user`.`accesslevel` ","WHERE `user`.`accesslevel`=1");
        
		$this->load->view("json",$data);
	} 
    
    function viewnormalusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewnormaluser';
        $data['base_url'] = site_url("site/viewnormalusersjson");
        
		$data['title']='View Students';
		$this->load->view('template',$data);
	} 
    function viewnormalusersjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
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
        $elements[3]->field="`user`.`contact`";
        $elements[3]->sort="1";
        $elements[3]->header="Contact";
        $elements[3]->alias="contact";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`user`.`timestamp`";
        $elements[4]->sort="1";
        $elements[4]->header="Timestamp";
        $elements[4]->alias="timestamp";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`user`.`dob`";
        $elements[5]->sort="1";
        $elements[5]->header="Dob";
        $elements[5]->alias="dob";
       
        $elements[6]=new stdClass();
        $elements[6]->field="`accesslevel`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="Access level";
        $elements[6]->alias="accesslevelname";
       
        $elements[7]=new stdClass();
        $elements[7]->field="`user`.`facebookid`";
        $elements[7]->sort="1";
        $elements[7]->header="Facebookid";
        $elements[7]->alias="facebookid";
       
        $elements[8]=new stdClass();
        $elements[8]->field="`user`.`twitterid`";
        $elements[8]->sort="1";
        $elements[8]->header="twitterid";
        $elements[8]->alias="twitterid";
       
        $elements[9]=new stdClass();
        $elements[9]->field="`user`.`instagramid`";
        $elements[9]->sort="1";
        $elements[9]->header="instagramid";
        $elements[9]->alias="instagramid";
       
        
        $elements[10]=new stdClass();
        $elements[10]->field="`user`.`city`";
        $elements[10]->sort="1";
        $elements[10]->header="city";
        $elements[10]->alias="city";
       
        
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
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` LEFT OUTER JOIN `accesslevel` ON `accesslevel`.`id`=`user`.`accesslevel` ","WHERE `user`.`accesslevel`='2'");
        
		$this->load->view("json",$data);
	} 
    public function createnormaluser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data[ 'sex' ] =$this->user_model->getsexdropdown();
		$data[ 'college' ] =$this->college_model->getcollegedropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
//        $data['category']=$this->category_model->getcategorydropdown();
		$data[ 'page' ] = 'createnormaluser';
		$data[ 'title' ] = 'Create Student';
		$this->load->view( 'template', $data );	
	}
	function createnormalusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
//		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
//		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('contact','contact','trim');
		$this->form_validation->set_rules('facebookid','facebookid','trim');
		$this->form_validation->set_rules('twitterid','twitterid','trim');
		$this->form_validation->set_rules('instagramid','instagramid','trim');
		$this->form_validation->set_rules('dob','dob','trim');
		$this->form_validation->set_rules('sex','sex','trim');
		$this->form_validation->set_rules('college','college','trim');
		$this->form_validation->set_rules('city','city','trim');
//		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data[ 'sex' ] =$this->user_model->getsexdropdown();
            $data[ 'college' ] =$this->college_model->getcollegedropdown();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
    //        $data['category']=$this->category_model->getcategorydropdown();
            $data[ 'page' ] = 'createuser';
            $data[ 'title' ] = 'Create User';
            $this->load->view( 'template', $data );		
		}
		else
		{
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $password=$this->input->post('password');
            $accesslevel=2;
//            $accesslevel=$this->input->post('accesslevel');
//            $status=$this->input->post('status');
            $contact=$this->input->post('contact');
            $facebookid=$this->input->post('facebookid');
            $twitterid=$this->input->post('twitterid');
            $instagramid=$this->input->post('instagramid');
            $dob=$this->input->post('dob');
            $sex=$this->input->post('sex');
            $college=$this->input->post('college');
            $city=$this->input->post('city');
            
			if($dob != "")
			{
				$dob = date("Y-m-d",strtotime($dob));
			}
            
			if($this->user_model->create($name,$email,$password,$accesslevel,$contact,$facebookid,$twitterid,$instagramid,$dob,$sex,$college,$city)==0)
			$data['alerterror']="New student could not be created.";
			else
			$data['alertsuccess']="Student created Successfully.";
			$data['redirect']="site/viewnormalusers";
			$this->load->view("redirect",$data);
		}
	}
    
	function editadminnormaluser()
	{
		$access = array("1");
		$this->checkaccess($access);
        $userid=$this->input->get('id');
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
        $data[ 'sex' ] =$this->user_model->getsexdropdown();
		$data[ 'college' ] =$this->college_model->getcollegedropdown();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
//		$data['before']=$this->user_model->beforeedit($userid);
		$data['table']=$this->userpost_model->viewuserpostbyuser($userid);
		$data['page']='editadminnormaluser';
		$data['page2']='block/userblock';
		$data['title']='Edit Student';
		$this->load->view('template',$data);
	}
	function editadminnormalusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
//		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('contact','contact','trim');
        
		$this->form_validation->set_rules('facebookid','facebookid','trim');
		$this->form_validation->set_rules('twitterid','twitterid','trim');
		$this->form_validation->set_rules('instagramid','instagramid','trim');
		$this->form_validation->set_rules('dob','dob','trim');
		$this->form_validation->set_rules('sex','sex','trim');
		$this->form_validation->set_rules('college','college','trim');
		$this->form_validation->set_rules('city','city','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
            $data[ 'sex' ] =$this->user_model->getsexdropdown();
            $data[ 'college' ] =$this->college_model->getcollegedropdown();
			$data['before']=$this->user_model->beforeedit($this->input->post('id'));
			$data['page']='editadminnormalusersubmit';
//			$data['page2']='block/userblock';
			$data['title']='Edit Student';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $email=$this->input->get_post('email');
            $password=$this->input->get_post('password');
            $accesslevel=2;
//            $accesslevel=$this->input->get_post('accesslevel');
//            $status=$this->input->get_post('status');
            $contact=$this->input->get_post('contact');
            
            $facebookid=$this->input->post('facebookid');
            $twitterid=$this->input->post('twitterid');
            $instagramid=$this->input->post('instagramid');
            $dob=$this->input->post('dob');
            $sex=$this->input->post('sex');
            $college=$this->input->post('college');
            $city=$this->input->post('city');
//            $category=$this->input->get_post('category');
            
            
			if($dob != "")
			{
				$dob = date("Y-m-d",strtotime($dob));
			}
            
			if($this->user_model->edit($id,$name,$email,$password,$accesslevel,$contact,$facebookid,$twitterid,$instagramid,$dob,$sex,$college,$city)==0)
			$data['alerterror']="Student Editing was unsuccesful";
			else
			$data['alertsuccess']="Student edited Successfully.";
			
			$data['redirect']="site/viewnormalusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletenormaluser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
//		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="Student Deleted Successfully";
		$data['redirect']="site/viewnormalusers";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
	
	function edituser()
	{
		$access = array("1");
		$this->checkaccess($access);
        $userid=$this->input->get('id');
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
        $data[ 'sex' ] =$this->user_model->getsexdropdown();
		$data[ 'college' ] =$this->college_model->getcollegedropdown();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
//		$data['before']=$this->user_model->beforeedit($userid);
		$data['table']=$this->userpost_model->viewuserpostbyuser($userid);
        $data['base_url'] = site_url("site/viewuserpostbyuserjson?id=$userid");
		$data['page']='edituser';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('template',$data);
	}
    function viewuserpostbyuserjson()
	{
		$access = array("1","2");
		$this->checkaccess($access);

        $id=$this->input->get('id');
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`userpost`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`userpost`.`post`";
        $elements[1]->sort="1";
        $elements[1]->header="Post";
        $elements[1]->alias="post";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`userpost`.`likes`";
        $elements[2]->sort="1";
        $elements[2]->header="Likes";
        $elements[2]->alias="likes";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`userpost`.`comment`";
        $elements[3]->sort="1";
        $elements[3]->header="Comment";
        $elements[3]->alias="comment";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`userpost`.`favourites`";
        $elements[4]->sort="1";
        $elements[4]->header="Favourites";
        $elements[4]->alias="favourites";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`userpost`.`retweet`";
        $elements[5]->sort="1";
        $elements[5]->header="Retweet";
        $elements[5]->alias="retweet";
        
        $elements[6]=new stdClass();
        $elements[6]->field="`userpost`.`returnpostid`";
        $elements[6]->sort="1";
        $elements[6]->header="Return Post Id";
        $elements[6]->alias="returnpostid";
        
        $elements[7]=new stdClass();
        $elements[7]->field="`userpost`.`posttype`";
        $elements[7]->sort="1";
        $elements[7]->header="Post Type";
        $elements[7]->alias="posttype";
        
        $elements[8]=new stdClass();
        $elements[8]->field="`posttype`.`name`";
        $elements[8]->sort="1";
        $elements[8]->header="Posttype";
        $elements[8]->alias="posttypename";
        
        $elements[9]=new stdClass();
        $elements[9]->field="`userpost`.`share`";
        $elements[9]->sort="1";
        $elements[9]->header="Share";
        $elements[9]->alias="share";
        
        $elements[10]=new stdClass();
        $elements[10]->field="`user`.`name`";
        $elements[10]->sort="1";
        $elements[10]->header="User";
        $elements[10]->alias="username";
        
        $elements[11]=new stdClass();
        $elements[11]->field="`userpost`.`timestamp`";
        $elements[11]->sort="1";
        $elements[11]->header="Timestamp";
        $elements[11]->alias="timestamp";
        
        $elements[12]=new stdClass();
        $elements[12]->field="`userpost`.`user`";
        $elements[12]->sort="1";
        $elements[12]->header="userid";
        $elements[12]->alias="userid";
        
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
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `userpost` LEFT OUTER JOIN `user` ON `user`.`id`=`userpost`.`user` LEFT OUTER JOIN `post` ON `post`.`id`=`userpost`.`post` LEFT OUTER JOIN `posttype` ON `posttype`.`id`=`userpost`.`posttype` ","WHERE `userpost`.`user`='$id'","","","");
        
		$this->load->view("json",$data);
	} 
    
	function editusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
//		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('contact','contact','trim');
        
		$this->form_validation->set_rules('facebookid','facebookid','trim');
		$this->form_validation->set_rules('twitterid','twitterid','trim');
		$this->form_validation->set_rules('instagramid','instagramid','trim');
		$this->form_validation->set_rules('dob','dob','trim');
		$this->form_validation->set_rules('sex','sex','trim');
		$this->form_validation->set_rules('college','college','trim');
		$this->form_validation->set_rules('city','city','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
            $data[ 'sex' ] =$this->user_model->getsexdropdown();
            $data[ 'college' ] =$this->college_model->getcollegedropdown();
			$data['before']=$this->user_model->beforeedit($this->input->post('id'));
			$data['page']='edituser';
//			$data['page2']='block/userblock';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $email=$this->input->get_post('email');
            $password=$this->input->get_post('password');
            $accesslevel=$this->input->get_post('accesslevel');
//            $status=$this->input->get_post('status');
            $contact=$this->input->get_post('contact');
            
            $facebookid=$this->input->post('facebookid');
            $twitterid=$this->input->post('twitterid');
            $instagramid=$this->input->post('instagramid');
            $dob=$this->input->post('dob');
            $sex=$this->input->post('sex');
            $college=$this->input->post('college');
            $city=$this->input->post('city');
//            $category=$this->input->get_post('category');
            
            
			if($dob != "")
			{
				$dob = date("Y-m-d",strtotime($dob));
			}
            
			if($this->user_model->edit($id,$name,$email,$password,$accesslevel,$contact,$facebookid,$twitterid,$instagramid,$dob,$sex,$college,$city)==0)
			$data['alerterror']="User Editing was unsuccesful";
			else
			$data['alertsuccess']="User edited Successfully.";
			
			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
//		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="User Deleted Successfully";
		$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
	function changeuserstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->changestatus($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="Status Changed Successfully";
		$data['redirect']="site/viewusers";
        $data['other']="template=$template";
        $this->load->view("redirect",$data);
	}
    
    
    
    //college
    function viewcollege()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewcollege';
        $data['base_url'] = site_url("site/viewcollegejson");
        
		$data['title']='View college';
		$this->load->view('template',$data);
	} 
    function viewcollegejson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`college`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`college`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`college`.`address`";
        $elements[2]->sort="1";
        $elements[2]->header="Address";
        $elements[2]->alias="address";
        
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
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `college`");
        
		$this->load->view("json",$data);
	} 
    
    public function createcollege()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createcollege';
		$data[ 'title' ] = 'Create college';
		$this->load->view( 'template', $data );	
	}
	function createcollegesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('address','Address','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createcollege';
            $data[ 'title' ] = 'Create college';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            $address=$this->input->post('address');
            
			if($this->college_model->create($name,$address)==0)
			$data['alerterror']="New College could not be created.";
			else
			$data['alertsuccess']="College created Successfully.";
			$data['redirect']="site/viewcollege";
			$this->load->view("redirect",$data);
		}
	}
    
	function editcollege()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='editcollege';
		$data['title']='Edit College';
		$data['before']=$this->college_model->beforeedit($this->input->get('id'));
		$this->load->view('template',$data);
	}
	function editcollegesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('address','address','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='editcollege';
            $data['before']=$this->college_model->beforeedit($this->input->get('id'));
			$data['title']='Edit College';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $address=$this->input->get_post('address');
            
			if($this->college_model->edit($id,$name,$address)==0)
			$data['alerterror']="College Editing was unsuccesful";
			else
			$data['alertsuccess']="College edited Successfully.";
			
			$data['redirect']="site/viewcollege";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletecollege()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->college_model->deletecollege($this->input->get('id'));
		$data['alertsuccess']="College Deleted Successfully";
		$data['redirect']="site/viewcollege";
		$this->load->view("redirect",$data);
	}
    
    
    
    //post
    function viewpost()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewpost';
        $data['base_url'] = site_url("site/viewpostjson");
        
		$data['title']='View post';
		$this->load->view('template',$data);
	} 
    function viewpostjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`post`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`post`.`text`";
        $elements[1]->sort="1";
        $elements[1]->header="Text";
        $elements[1]->alias="text";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`post`.`image`";
        $elements[2]->sort="1";
        $elements[2]->header="Image";
        $elements[2]->alias="image";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`post`.`posttype`";
        $elements[3]->sort="1";
        $elements[3]->header="posttype";
        $elements[3]->alias="posttype";
        
        
        $elements[4]=new stdClass();
        $elements[4]->field="`post`.`timestamp`";
        $elements[4]->sort="1";
        $elements[4]->header="timestamp";
        $elements[4]->alias="timestamp";
        
        
        $elements[5]=new stdClass();
        $elements[5]->field="`posttype`.`name`";
        $elements[5]->sort="1";
        $elements[5]->header="Platform";
        $elements[5]->alias="posttypename";
        
        $elements[6]=new stdClass();
        $elements[6]->field="`post`.`link`";
        $elements[6]->sort="1";
        $elements[6]->header="Link";
        $elements[6]->alias="link";
        
        
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
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `post` LEFT OUTER JOIN `posttype` ON `posttype`.`id`=`post`.`posttype`");
        
		$this->load->view("json",$data);
	} 
    
    public function createpost()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createpost';
        $data['posttype']=$this->post_model->getposttypedropdown();
		$data[ 'title' ] = 'Create post';
		$this->load->view( 'template', $data );	
	}
	function createpostsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('text','text','trim|required');
		$this->form_validation->set_rules('posttype','posttype','trim');
		$this->form_validation->set_rules('link','link','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createpost';
            $data['posttype']=$this->post_model->getposttypedropdown();
            $data[ 'title' ] = 'Create post';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $text=$this->input->post('text');
            $posttype=$this->input->post('posttype');
            $link=$this->input->post('link');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                }  
                else
                {
                    $image=$this->image_lib->dest_image;
                }
                
			}
            
			if($this->post_model->create($text,$image,$posttype,$link)==0)
			$data['alerterror']="New post could not be created.";
			else
			$data['alertsuccess']="post created Successfully.";
			$data['redirect']="site/viewpost";
			$this->load->view("redirect",$data);
		}
	}
    
	function editpost()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='editpost';
		$data['title']='Edit post';
        $data['posttype']=$this->post_model->getposttypedropdown();
		$data['before']=$this->post_model->beforeedit($this->input->get('id'));
		$this->load->view('template',$data);
	}
	function editpostsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('text','text','trim|required');
		$this->form_validation->set_rules('posttype','posttype','trim');
		$this->form_validation->set_rules('link','link','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='editpost';
            $data['posttype']=$this->post_model->getposttypedropdown();
            $data['before']=$this->post_model->beforeedit($this->input->get('id'));
			$data['title']='Edit post';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $text=$this->input->get_post('text');
            $posttype=$this->input->get_post('posttype');
            $link=$this->input->get_post('link');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                }  
                else
                {
                    $image=$this->image_lib->dest_image;
                }
                
			}
            
            if($image=="")
            {
                $image=$this->post_model->getpostimagebyid($id);
                $image=$image->image;
            }
            
			if($this->post_model->edit($id,$text,$image,$posttype,$link)==0)
			$data['alerterror']="post Editing was unsuccesful";
			else
			$data['alertsuccess']="post edited Successfully.";
			
			$data['redirect']="site/viewpost";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletepost()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->post_model->deletepost($this->input->get('id'));
		$data['alertsuccess']="post Deleted Successfully";
		$data['redirect']="site/viewpost";
		$this->load->view("redirect",$data);
	}
    
    
    //userpost
    
    function viewuserpost()
	{
		$access = array("1");
		$this->checkaccess($access);
        $userid=$this->input->get('id');
		$data['before']=$this->user_model->beforeedit($userid);
		$data['table']=$this->userpost_model->viewuserpostbyuser($userid);
		$data['page']='viewuserpost';
		$data['page2']='block/userblock';
        $data['title']='View User Post';
		$this->load->view('templatewith2',$data);
	}
    
    
    
    public function createuserpost()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createuserpost';
		$data[ 'title' ] = 'Create userpost';
        $data['post']=$this->post_model->getpostdropdown();
		$data[ 'userid' ] = $this->input->get('id');
		$this->load->view( 'template', $data );	
	}
    function createuserpostsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('user','user','trim|required');
		$this->form_validation->set_rules('likes','likes','trim');
		$this->form_validation->set_rules('share','share','trim');
		$this->form_validation->set_rules('post','post','trim|required');
		$this->form_validation->set_rules('comment','comment','trim');
		$this->form_validation->set_rules('favourites','favourites','trim');
		$this->form_validation->set_rules('retweet','retweet','trim');

		if($this->form_validation->run() == FALSE)	
		{
            
			$data['alerterror'] = validation_errors();
			$data[ 'page' ] = 'createuserpost';
            $data[ 'title' ] = 'Create userpost';
            $data['post']=$this->post_model->getpostdropdown();
            $data[ 'userid' ] = $this->input->get_post('id');
            $this->load->view( 'template', $data );	
		}
		else
		{
			$user=$this->input->post('user');
			$likes=$this->input->post('likes');
			$share=$this->input->post('share');
			$post=$this->input->post('post');
			$comment=$this->input->post('comment');
			$favourites=$this->input->post('favourites');
			$retweet=$this->input->post('retweet');
           
            
            if($this->userpost_model->create($user,$likes,$share,$post,$comment,$favourites,$retweet)==0)
               $data['alerterror']="New userpost could not be created.";
            else
               $data['alertsuccess']="userpost created Successfully.";
			
			$data['redirect']="site/viewuserpost?id=".$user;
			$this->load->view("redirect2",$data);
		}
	}
    
    function edituserpost()
	{
		$access = array("1");
		$this->checkaccess($access);
        $userid=$this->input->get('id');
        $data['userid']=$userid;
        $userpostid=$this->input->get('userpostid');
		$data['before']=$this->userpost_model->beforeedit($this->input->get('userpostid'));
        $data['post']=$this->post_model->getpostdropdown();
		$data['page']='edituserpost';
		$data['title']='Edit userpost';
		$this->load->view('template',$data);
	}
	function edituserpostsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
        
		$this->form_validation->set_rules('user','user','trim|required');
		$this->form_validation->set_rules('likes','likes','trim');
		$this->form_validation->set_rules('share','share','trim');
		$this->form_validation->set_rules('post','post','trim|required');
		$this->form_validation->set_rules('comment','comment','trim');
		$this->form_validation->set_rules('favourites','favourites','trim');
		$this->form_validation->set_rules('retweet','retweet','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $userid=$this->input->post('user');
            $userpostid=$this->input->post('userpostid');
            $data['userid']=$userid;
			$data['before']=$this->userpost_model->beforeedit($this->input->post('userpostid'));
            $data['post']=$this->post_model->getpostdropdown();
			$data['page']='edituserpost';
			$data['title']='Edit userpost';
			$this->load->view('template',$data);
		}
		else
		{
            
			$id=$this->input->post('userpostid');
            $user=$this->input->post('user');
			$likes=$this->input->post('likes');
			$share=$this->input->post('share');
			$post=$this->input->post('post');
			$comment=$this->input->post('comment');
			$favourites=$this->input->post('favourites');
			$retweet=$this->input->post('retweet');
            
			if($this->userpost_model->edit($id,$user,$post,$likes,$share,$comment,$favourites,$retweet)==0)
			$data['alerterror']="userpost Editing was unsuccesful";
			else
			$data['alertsuccess']="userpost edited Successfully.";
			
			$data['redirect']="site/edituser?id=".$user;
			$this->load->view("redirect2",$data);
			
		}
	}
    
	function deleteuserpost()
	{
		$access = array("1");
		$this->checkaccess($access);
        $userid=$this->input->get('id');
        $userpostid=$this->input->get('userpostid');
		$this->userpost_model->deleteuserpost($this->input->get('userpostid'));
		$data['alertsuccess']="userpost Deleted Successfully";
		$data['redirect']="site/viewuserpost?id=".$userid;
		$this->load->view("redirect2",$data);
	}
    
    
    public function viewnormaluserprofile()
    {
		$access = array("2");
		$this->checkaccess($access);
        $id=$this->session->userdata('id');
        $data['table']=$this->user_model->getnormaluserdata($id);
        $data['posts']=$this->userpost_model->getpostsofuser($id);
//        print_r($data);
        $data['page']='normaluserprofile';
		$data[ 'title' ] = 'Profile';
		$this->load->view( 'template', $data );
    }
    
    
    public function viewfacebookpostold()
    {
		$access = array("2");
		$this->checkaccess($access);
        $id=$this->session->userdata('id');
        $data['before']=$this->user_model->getnormaluserfacebookpost($id);
        $data['page']='viewfacebookpost';
		$data[ 'title' ] = 'Facebook Posts';
		$this->load->view( 'template', $data );
    }
    
    function viewfacebookpost()
	{
		$access = array("2");
		$this->checkaccess($access);
		$data['page']='viewfacebookpost';
        $data['base_url'] = site_url("site/viewfacebookpostjson");
        
		$data['title']='View Facebook Post';
		$this->load->view('template',$data);
	} 
    function viewfacebookpostjson()
	{
		$access = array("2");
		$this->checkaccess($access);
        //SELECT `userpost`.`id`, `userpost`.`user`, `userpost`.`post`, `userpost`.`likes`, `userpost`.`share` ,`post`.`text`,`post`.`posttype`,`post`.`timestamp`,`user`.`name` AS `username`
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`post`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`post`.`text`";
        $elements[1]->sort="1";
        $elements[1]->header="Text";
        $elements[1]->alias="text";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`post`.`image`";
        $elements[2]->sort="1";
        $elements[2]->header="Image";
        $elements[2]->alias="image";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`post`.`posttype`";
        $elements[3]->sort="1";
        $elements[3]->header="posttype";
        $elements[3]->alias="posttype";
        
        
        $elements[4]=new stdClass();
        $elements[4]->field="`post`.`timestamp`";
        $elements[4]->sort="1";
        $elements[4]->header="timestamp";
        $elements[4]->alias="timestamp";
        
        
        $elements[5]=new stdClass();
        $elements[5]->field="`posttype`.`name`";
        $elements[5]->sort="1";
        $elements[5]->header="posttypename";
        $elements[5]->alias="posttypename";
        
        $elements[6]=new stdClass();
        $elements[6]->field="`userpost`.`returnpostid`";
        $elements[6]->sort="1";
        $elements[6]->header="returnpostid";
        $elements[6]->alias="returnpostid";
        
        $elements[7]=new stdClass();
        $elements[7]->field="`post`.`link`";
        $elements[7]->sort="1";
        $elements[7]->header="Link";
        $elements[7]->alias="link";
        
        
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
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `post` LEFT OUTER JOIN `posttype` ON `posttype`.`id`=`post`.`posttype` LEFT OUTER JOIN `userpost` ON `userpost`.`post`=`post`.`id`" ,"WHERE `post`.`posttype`=1","GROUP BY `post`.`id`");
        
		$this->load->view("json",$data);
        
//        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `userpost` LEFT OUTER JOIN `post` ON `post`.`id`=`userpost`.`post` LEFT OUTER JOIN `user` ON `user`.`id`=`userpost`.`user`","WHERE `post`.`posttype`=1");
//        
//		$this->load->view("json",$data);
	} 
    
    
    
    
    function viewtwitterpost()
	{
		$access = array("2");
		$this->checkaccess($access);
		$data['page']='viewtwitterpost';
        $data['base_url'] = site_url("site/viewtwitterpostjson");
        
		$data['title']='View twitter Post';
		$this->load->view('template',$data);
	} 
    function viewtwitterpostjson()
	{
		$access = array("2");
		$this->checkaccess($access);
        //SELECT `userpost`.`id`, `userpost`.`user`, `userpost`.`post`, `userpost`.`likes`, `userpost`.`share` ,`post`.`text`,`post`.`posttype`,`post`.`timestamp`,`user`.`name` AS `username`
        
         $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`post`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`post`.`text`";
        $elements[1]->sort="1";
        $elements[1]->header="Text";
        $elements[1]->alias="text";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`post`.`image`";
        $elements[2]->sort="1";
        $elements[2]->header="Image";
        $elements[2]->alias="image";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`post`.`posttype`";
        $elements[3]->sort="1";
        $elements[3]->header="posttype";
        $elements[3]->alias="posttype";
        
        
        $elements[4]=new stdClass();
        $elements[4]->field="`post`.`timestamp`";
        $elements[4]->sort="1";
        $elements[4]->header="timestamp";
        $elements[4]->alias="timestamp";
        
        
        $elements[4]=new stdClass();
        $elements[4]->field="`posttype`.`name`";
        $elements[4]->sort="1";
        $elements[4]->header="posttypename";
        $elements[4]->alias="posttypename";
        
        
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
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `post` LEFT OUTER JOIN `posttype` ON `posttype`.`id`=`post`.`posttype`","WHERE `post`.`posttype`=2","GROUP BY `post`.`id`");
        
		$this->load->view("json",$data);
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
    
    
	function editnormaluser()
	{
		$access = array("2");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
        $data[ 'sex' ] =$this->user_model->getsexdropdown();
		$data[ 'college' ] =$this->college_model->getcollegedropdown();
		$data['before']=$this->user_model->beforeedit($this->session->userdata('id'));
		$data['page']='editnormaluser';
//		$data['page2']='block/userblock';
		$data['title']='Edit Profile';
		$this->load->view('template',$data);
	}
	function editnormalusersubmit()
	{
		$access = array("2");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
//		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
//		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('contact','contact','trim');
        
		$this->form_validation->set_rules('facebookid','facebookid','trim');
		$this->form_validation->set_rules('twitterid','twitterid','trim');
		$this->form_validation->set_rules('instagramid','instagramid','trim');
		$this->form_validation->set_rules('dob','dob','trim');
		$this->form_validation->set_rules('sex','sex','trim');
		$this->form_validation->set_rules('college','college','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
            $data[ 'sex' ] =$this->user_model->getsexdropdown();
            $data[ 'college' ] =$this->college_model->getcollegedropdown();
            $data['before']=$this->user_model->beforeedit($this->session->userdata('id'));
            $data['page']='editnormaluser';
    //		$data['page2']='block/userblock';
            $data['title']='Edit Profile';
            $this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $email=$this->input->get_post('email');
            $password=$this->input->get_post('password');
//            $accesslevel=$this->input->get_post('accesslevel');
            $accesslevel=2;
//            $status=$this->input->get_post('status');
            $contact=$this->input->get_post('contact');
            
            $facebookid=$this->input->post('facebookid');
            $twitterid=$this->input->post('twitterid');
            $instagramid=$this->input->post('instagramid');
            $dob=$this->input->post('dob');
            $sex=$this->input->post('sex');
            $college=$this->input->post('college');
            $city=$this->input->post('city');
//            $category=$this->input->get_post('category');
            
//            echo $accesslevel;
			if($dob != "")
			{
				$dob = date("Y-m-d",strtotime($dob));
			}
            
			if($this->user_model->edit($id,$name,$email,$password,$accesslevel,$contact,$facebookid,$twitterid,$instagramid,$dob,$sex,$college,$city)==0)
			$data['alerterror']="Profile Editing was unsuccesful";
			else
			$data['alertsuccess']="Profile edited Successfully.";
			
			$data['redirect']="site/viewnormaluserprofile";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function changepassword()
	{
		$access = array("2");
		$this->checkaccess($access);
//		$data[ 'status' ] =$this->user_model->getstatusdropdown();
//		$data['accesslevel']=$this->user_model->getaccesslevels();
//		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
//        $data[ 'sex' ] =$this->user_model->getsexdropdown();
//		$data[ 'college' ] =$this->college_model->getcollegedropdown();
//		$data['before']=$this->user_model->beforeedit($this->session->userdata('id'));
		$data['page']='changepassword';
//		$data['page2']='block/userblock';
		$data['title']='Change Password';
		$this->load->view('template',$data);
	}
    
	function changepasswordsubmit()
	{
		$access = array("2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
    //		$data[ 'status' ] =$this->user_model->getstatusdropdown();
    //		$data['accesslevel']=$this->user_model->getaccesslevels();
    //		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
    //        $data[ 'sex' ] =$this->user_model->getsexdropdown();
    //		$data[ 'college' ] =$this->college_model->getcollegedropdown();
    //		$data['before']=$this->user_model->beforeedit($this->session->userdata('id'));
            $data['page']='changepassword';
    //		$data['page2']='block/userblock';
            $data['title']='Change Password';
            $this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $password=$this->input->get_post('password');
			if($this->user_model->changepassword($id,$password)==0)
			$data['alerterror']="Changed Password unsuccesful";
			else
			$data['alertsuccess']="Change Password Successfully.";
			
			$data['redirect']="site/viewnormaluserprofile";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
     //suggestion
    function viewsuggestion()
	{
		$access = array("2");
		$this->checkaccess($access);
		$data['page']='viewsuggestion';
        $data['base_url'] = site_url("site/viewsuggestionjson");
        
		$data['title']='View suggestion';
		$this->load->view('template',$data);
	} 
    function viewsuggestionjson()
	{
		$access = array("2");
		$this->checkaccess($access);
        $userid=$this->session->userdata('id');
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`suggestion`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`suggestion`.`text`";
        $elements[1]->sort="1";
        $elements[1]->header="Text";
        $elements[1]->alias="text";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`suggestion`.`image`";
        $elements[2]->sort="1";
        $elements[2]->header="Image";
        $elements[2]->alias="image";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`suggestion`.`timestamp`";
        $elements[3]->sort="1";
        $elements[3]->header="timestamp";
        $elements[3]->alias="timestamp";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`suggestion`.`suggestionstatus`";
        $elements[4]->sort="1";
        $elements[4]->header="Status";
        $elements[4]->alias="suggestionstatus";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`suggestion`.`adminmessage`";
        $elements[5]->sort="1";
        $elements[5]->header="Admin Message";
        $elements[5]->alias="adminmessage";
        
        $elements[6]=new stdClass();
        $elements[6]->field="`suggestion`.`posttype`";
        $elements[6]->sort="1";
        $elements[6]->header="Posttype";
        $elements[6]->alias="posttype";
        
        $elements[7]=new stdClass();
        $elements[7]->field="`suggestion`.`link`";
        $elements[7]->sort="1";
        $elements[7]->header="Link";
        $elements[7]->alias="link";
        
        
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
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `suggestion`","WHERE `suggestion`.`user`='$userid'");
        
		$this->load->view("json",$data);
	} 
    
    public function createsuggestion()
	{
		$access = array("2");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createsuggestion';
        $data['posttype']=$this->post_model->getposttypedropdown();
        $data['suggestionstatus']=$this->suggestion_model->getsuggestionstatusdropdown();
		$data[ 'title' ] = 'Create suggestion';
		$this->load->view( 'template', $data );	
	}
	function createsuggestionsubmit()
	{
		$access = array("2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('text','text','trim|required');
		$this->form_validation->set_rules('posttype','posttype','trim');
		$this->form_validation->set_rules('link','link','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createsuggestion';
            $data[ 'title' ] = 'Create suggestion';
            $data['posttype']=$this->post_model->getposttypedropdown();
            $data['suggestionstatus']=$this->suggestion_model->getsuggestionstatusdropdown();
            $this->load->view( 'template', $data );	
		}
		else
		{
            $text=$this->input->post('text');
            $posttype=$this->input->post('posttype');
            $link=$this->input->post('link');
            $userid=$this->session->userdata('id');
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                }  
                else
                {
                    $image=$this->image_lib->dest_image;
                }
                
			}
            
			if($this->suggestion_model->create($text,$image,$userid,$posttype,$link)==0)
			$data['alerterror']="New suggestion could not be created.";
			else
			$data['alertsuccess']="suggestion created Successfully.";
			$data['redirect']="site/viewsuggestion";
			$this->load->view("redirect",$data);
		}
	}
    
	function editsuggestion()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='editsuggestion';
		$data['title']='Edit suggestion';
        $data['suggestionstatus']=$this->suggestion_model->getsuggestionstatusdropdown();
		$data['before']=$this->suggestion_model->beforeedit($this->input->get('id'));
		$this->load->view('template',$data);
	}
	function editsuggestionsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('text','text','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='editsuggestion';
            $data['title']='Edit suggestion';
            $data['suggestionstatus']=$this->suggestion_model->getsuggestionstatusdropdown();
            $data['before']=$this->suggestion_model->beforeedit($this->input->get('id'));
            $this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $text=$this->input->get_post('text');
            $suggestionstatus=$this->input->get_post('suggestionstatus');
            $message=$this->input->get_post('message');
            $user=$this->input->get_post('user');
            $email=$this->user_model->getemailbyuserid($user);
//            if($suggestionstatus=='Publish')
//            {
//                    $this->load->library('email');
//                    $this->email->from('avinashghare572@gmail.com', 'Dell');
//                    $this->email->to($email);
//                    $this->email->subject('Dell Campassador');
//                    $this->email->message('Your Post Is Approved.');
//                    $this->email->send();
//            }
//            elseif($suggestionstatus=='Unpublish')
//            {
//                    $this->load->library('email');
//                    $this->email->from('avinashghare572@gmail.com', 'Dell');
//                    $this->email->to($email);
//                    $this->email->subject('Dell Campassador');
//                    $this->email->message($message);
//                    $this->email->send();
//            }
//            $userid=$this->session->userdata('id');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                }  
                else
                {
                    $image=$this->image_lib->dest_image;
                }
                
			}
            
            if($image=="")
            {
                $image=$this->suggestion_model->getsuggestionimagebyid($id);
                $image=$image->image;
            }
            
			if($this->suggestion_model->edit($id,$text,$image,$user,$suggestionstatus,$message)==0)
			$data['alerterror']="Suggestion Editing was unsuccesful";
			else
			$data['alertsuccess']="Suggestion Edited Successfully.";
			
			$data['redirect']="site/viewadminsuggestion";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletesuggestion()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->suggestion_model->deletesuggestion($this->input->get('id'));
		$data['alertsuccess']="Suggestion Deleted Successfully";
		$data['redirect']="site/viewadminsuggestion";
		$this->load->view("redirect",$data);
	}
    
    function approvesuggestion()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->suggestion_model->approvesuggestion($this->input->get('id'));
		$data['alertsuccess']="Suggestion Approved Successfully";
		$data['redirect']="site/viewadminsuggestion";
		$this->load->view("redirect",$data);
	}
        
    function viewadminsuggestion()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewadminsuggestion';
        $data['base_url'] = site_url("site/viewadminsuggestionjson");
        
		$data['title']='View suggestion';
		$this->load->view('template',$data);
	} 
    function viewadminsuggestionjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`suggestion`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`suggestion`.`text`";
        $elements[1]->sort="1";
        $elements[1]->header="Text";
        $elements[1]->alias="text";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`suggestion`.`image`";
        $elements[2]->sort="1";
        $elements[2]->header="Image";
        $elements[2]->alias="image";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`suggestion`.`timestamp`";
        $elements[3]->sort="1";
        $elements[3]->header="timestamp";
        $elements[3]->alias="timestamp";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`suggestion`.`suggestionstatus`";
        $elements[4]->sort="1";
        $elements[4]->header="Status";
        $elements[4]->alias="suggestionstatus";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`suggestion`.`adminmessage`";
        $elements[5]->sort="1";
        $elements[5]->header="Admin Message";
        $elements[5]->alias="adminmessage";
        
        
        $elements[6]=new stdClass();
        $elements[6]->field="`user`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="User";
        $elements[6]->alias="username";
        
        
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
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `suggestion` LEFT OUTER JOIN `user` ON `user`.`id`=`suggestion`.`user`");
        
		$this->load->view("json",$data);
	} 
    
    
    function uploadusercsv()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'uploadusercsv';
		$data[ 'title' ] = 'Upload user';
		$this->load->view( 'template', $data );
	} 
    
    function uploadusercsvsubmit()
	{
        $access = array("1");
		$this->checkaccess($access);
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);
        $filename="file";
        $file="";
        if (  $this->upload->do_upload($filename))
        {
            $uploaddata = $this->upload->data();
            $file=$uploaddata['file_name'];
            $filepath=$uploaddata['file_path'];
        }
        $fullfilepath=$filepath."".$file;
        $file = $this->csvreader->parse_file($fullfilepath);
        $id1=$this->user_model->createuserbycsv($file);
//        echo $id1;
        if($id1==0)
        $data['alerterror']="New Users could not be Uploaded.";
		else
		$data['alertsuccess']="Users Uploaded Successfully.";
		$data['redirect']="site/viewusers";
		$this->load->view("redirect",$data);
    }
    
    	public function exportexcelreport()
	{
		$this->userpost_model->exportexcelreport();
            
	}
}
?>