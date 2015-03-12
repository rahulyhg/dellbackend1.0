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
    
    function viewleaderboardjson()
	{
		
        
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
       
        $elements[8]=new stdClass();
        $elements[8]->field="`user`.`image`";
        $elements[8]->sort="1";
        $elements[8]->header="Image";
        $elements[8]->alias="image";
        
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
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` LEFT OUTER JOIN `userpost` ON `user`.`id`=`userpost`.`user` LEFT OUTER JOIN `college` ON `college`.`id`=`user`.`college` ","WHERE `user`.`accesslevel`=2","GROUP BY `user`.`id` ","","");
        
		$this->load->view("json",$data);
	} 
    
    
    function changepasswordsubmit()
	{
		$data = json_decode(file_get_contents('php://input'), true);
        $password=$data['password'];
        $confirmpassword=$data['confirmpassword'];
        $currentpassword=$data['currentpassword'];
        
       
		if($this->json_model->changeuserpassword($password,$confirmpassword,$currentpassword)==0)
        $data['message']=false;
        else
        $data['message']=true;
		$this->load->view('json',$data);
	}
    
    function editprofilebefore()
    {
     
		$data['message']=$this->json_model->beforeedit();	
		$this->load->view('json',$data);
    }
    
    function editprofilesubmit()
	{
		
		
		$data = json_decode(file_get_contents('php://input'), true);

        $name=$data['name'];
        $contact=$data['contact'];
        $city=$data['city'];
        $dob=$data['dob'];
        
        
        if($dob != "")
        {
            $dob = date("Y-m-d",strtotime($dob));
        }

        if($this->json_model->edituserprofile($name,$contact,$city,$dob)==0)
        $data['message']=false;
        else
        $data['message']=true;
        $this->load->view('json',$data);
	}
    
    function getfacebookposts()
	{
      
        $data["message"]=new stdClass();
        $data["message"]->posts=$this->json_model->getpostsofuserfb();
        $data["message"]->stats=$this->json_model->getfacebookstats();
        $this->load->view('json',$data);
    }
    
    function gettwitterposts()
	{
      
        $data["message"]=new stdClass();
        $data["message"]->posts=$this->json_model->getpostsofuserfb();
        $data["message"]->stats=$this->json_model->getfacebookstats();
        $this->load->view('json',$data);
    }
    
    function getfacebooknextpost()
    {
        $lastid=$this->input->get_post("id");
        if($lastid=="")
        {
            $lastid=0;
        }
        if($direction=="")
        {
            $direction=0;
        }
        if($social=="")
        {
            $social=1;
        }
        $data["message"]=$this->json_model->getnextpost($lastid,1,1);
        $this->load->view('json',$data);
    }
    function getfacebookprevpost()
    {
        $lastid=$this->input->get_post("id");
        if($lastid=="")
        {
            $lastid=0;
        }
        if($direction=="")
        {
            $direction=0;
        }
        if($social=="")
        {
            $social=1;
        }
        $data["message"]=$this->json_model->getnextpost($lastid,0,1);
        $this->load->view('json',$data);
    }
    
    function gettwitternextpost()
    {
        $lastid=$this->input->get_post("id");
        if($lastid=="")
        {
            $lastid=0;
        }
        if($direction=="")
        {
            $direction=0;
        }
        if($social=="")
        {
            $social=1;
        }
        $data["message"]=$this->json_model->getnextpost($lastid,1,2);
        $this->load->view('json',$data);
    }
    function gettwitterprevpost()
    {
        $lastid=$this->input->get_post("id");
        if($lastid=="")
        {
            $lastid=0;
        }
        if($direction=="")
        {
            $direction=0;
        }
        if($social=="")
        {
            $social=1;
        }
        $data["message"]=$this->json_model->getnextpost($lastid,0,2);
        $this->load->view('json',$data);
    }
    
    function getuserpostcount()
    {
        $post=$this->input->get_post("post");
        $data["message"]=$this->json_model->getuserpostcount($post);
        $this->load->view('json',$data);
    }
    
    public function posttweet()
    {
        $twitter = $this->hybridauthlib->authenticate("Twitter");
        
        $post=$this->input->get('id');
        $compost=$this->json_model->getpostdetails($post);
        $message=$compost->text;
        $twitterid = $twitter->getUserProfile();
        $twitterid = $twitterid->identifier;
        
        $userid=$this->session->userdata('id');
        $querytwitter=$this->db->query("SELECT `twitterid` FROM `user` WHERE `id`='$userid'")->row();
        $twitternid=$querytwitter->twitterid;
        if($twitterid==$twitternid) {
        $data["message"]=$twitter->api()->post("statuses/update.json?status=$message");
        if(isset($data["message"]->id_str))
        {
            $this->userpost_model->addpostid($data["message"]->id_str,$post);
            $data['alertsuccess']="Tweeted Successfully.";
            redirect('http://dellcampassador.com/success.html', 'location', 301);
        }
        else
        {
			$data['alerterror'] = "Tweet Error";
            $data['redirect']="site/viewtwitterpost";
		    $this->load->view("redirect",$data);
        }
        }
        else
        {
                $data['alerterror'] = "Please login with your own Twitter Profile.";
                $data['redirect']="site/viewtwitterpost";
                $this->load->view("redirect",$data);
        }
//        $this->load->view("json",$data);
    }
    
    public function postfb()
    {
        $post=$this->input->get('id');
        $compost=$this->json_model->getpostdetails($post);
        $message=$compost->text;
        $image=$compost->image;
        $link=$compost->link;
        
        $facebook = $this->hybridauthlib->authenticate("Facebook");
        
        
        $facebookid = $facebook->getUserProfile();
        $facebookid = $facebookid->identifier;
        
        $userid=$this->session->userdata('id');
        $queryfacebook=$this->db->query("SELECT `facebookid` FROM `user` WHERE `id`='$userid'")->row();
        $facebooknid=$queryfacebook->facebookid;
        
        if($facebookid==$facebooknid)
        {
            
        if($image=="")
        {
            $data["message"]=$facebook->api()->api("v2.2/me/feed", "post", array(
                "message" => "$message",
                "link"=>"$link"
            ));
            
            if(isset($data["message"]['id']))
            {
			$data['alertsuccess']="Posted Successfully.";
            $this->userpost_model->addpostid($data["message"]['id'],$post);
            redirect('http://dellcampassador.com/success.html', 'location', 301);
            }
            else
            {
                $data['alerterror'] = "Post Error";
                $data['redirect']="site/viewfacebookpost";
                $this->load->view("redirect",$data);
            }
        }
        else
        {
            $data["message"]=$facebook->api()->api("v2.2/me/feed", "post", array(
                "message" => "$message",
                "picture"=> "$image",
                "link"=>"$link"
            ));
            
//            print_r($data['message']["id"]);
            
            if(isset($data["message"]["id"]))
            {
			$data['alertsuccess']="Posted Successfully.";
            $this->userpost_model->addpostid($data["message"]["id"],$post);
            $data['redirect']="site/viewfacebookpost";
            $this->load->view("redirect",$data);
            }
            else
            {
                $data['alerterror'] = "Post Error";
                $data['redirect']="site/viewfacebookpost";
                $this->load->view("redirect",$data);
            }
        }
        
        
        }
        else
        {
            
                $data['alerterror'] = "Please login with your own Facebook Profile.";
                $data['redirect']="site/viewfacebookpost";
                //echo $data['alerterror'];
                $this->load->view("redirect",$data);
        }

        
    }
    
    public function loginhauth($provider)
	{
		//log_message('debug', "controllers.HAuth.login($provider) called");

		try
		{
			//log_message('debug', 'controllers.HAuth.login: loading HybridAuthLib');
			//$this->load->library('HybridAuthLib');

			if ($this->hybridauthlib->providerEnabled($provider))
			{
				//log_message('debug', "controllers.HAuth.login: service $provider enabled, trying to authenticate.");
				$service = $this->hybridauthlib->authenticate($provider);

				if ($service->isUserConnected())
				{
					//log_message('debug', 'controller.HAuth.login: user authenticated.');

					$user_profile = $service->getUserProfile();

					//log_message('info', 'controllers.HAuth.login: user profile:'.PHP_EOL.print_r($user_profile, TRUE));
                    $userid=$this->session->userdata("id");
					$data["message"]=$user_profile;
					
                    if ($this->uri->segment(3) == 'Facebook')
                    {
                        $name=$user_profile->firstName.' '.$user_profile->lastName;
                        $dob=$user_profile->birthYear.'-'.$user_profile->birthMonth.'-'.$user_profile->birthDay;
                        $newid=$user_profile->identifier;
                        $checkfacebook=$this->db->query("SELECT count(*) as `count1` FROM `user` WHERE `facebookid`='$newid'")->row();
                        if($checkfacebook->count1=='0')
                        {
                            $this->db->query("UPDATE `user` SET `facebookid`='$user_profile->identifier',`name`='$name',`sex`='$user_profile->gender',`dob`='$dob',`image`='$user_profile->photoURL' WHERE `id`='$userid'");

                            $data = $this->session->all_userdata();
                            $data['alertsuccess']="Successfully loggedin with Facebook Account.";
                            $data['facebook'] = $user_profile->identifier;
                            $this->session->set_userdata($data);
                        }
                        else
                        {
                            $data['alerterror']="An another user has already logged in to Facebook acount using same login.";
                            $service->logout(); 
                        }
                    }
                    if ($this->uri->segment(3) == 'Twitter')
                    {
                        $newid=$user_profile->identifier;
                        $checktwitter=$this->db->query("SELECT count(*) as `count1` FROM `user` WHERE `twitterid`='$newid'")->row();
                        if($checktwitter->count1=='0')
                        {
                            $this->db->query("UPDATE `user` SET `twitterid`='$user_profile->identifier' WHERE `id`='$userid'");
                            $data = $this->session->all_userdata();
                            $data['alertsuccess']="Successfully loggedin with Twitter Account.";
                            $data['twitter'] = $user_profile->identifier;
                            $this->session->set_userdata($data); 
                            
                        }
                        else
                        {
                            $data['alerterror']="An another user has already logged in to Twitter acount using same login.";
                            $service->logout(); 
                        }
                    }
                    
                    redirect('http://dellcampassador.com/success.html', 'location', 301);
				}
				else // Cannot authenticate user
				{
					show_error('Cannot authenticate user');
				}
			}
			else // This service is not enabled.
			{
				//log_message('error', 'controllers.HAuth.login: This provider is not enabled ('.$provider.')');
				show_404($_SERVER['REQUEST_URI']);
			}
		}
		catch(Exception $e)
		{
			$error = 'Unexpected error';
			switch($e->getCode())
			{
				case 0 : $error = 'Unspecified error.'; break;
				case 1 : $error = 'Hybriauth configuration error.'; break;
				case 2 : $error = 'Provider not properly configured.'; break;
				case 3 : $error = 'Unknown or disabled provider.'; break;
				case 4 : $error = 'Missing provider application credentials.'; break;
				case 5 : //log_message('debug', 'controllers.HAuth.login: Authentification failed. The user has canceled the authentication or the provider refused the connection.');
				         //redirect();
				         if (isset($service))
				         {
				         	//log_message('debug', 'controllers.HAuth.login: logging out from service.');
				         	$service->logout();
				         }
				         show_error('User has cancelled the authentication or the provider refused the connection.');
				         break;
				case 6 : $error = 'User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.';
				         break;
				case 7 : $error = 'User not connected to the provider.';
				         break;
			}

			if (isset($service))
			{
				$service->logout();
			}

			//log_message('error', 'controllers.HAuth.login: '.$error);
			show_error('Error authenticating user.');
		}
	}
    
    function viewsuggestionjson()
	{
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
        $suggestionstatus=$this->input->get_post("status");
        $suggestionstatus2="";
        if($suggestionstatus!="")
        {
            $suggestionstatus2=" AND `suggestion`.`suggestionstatus`='$suggestionstatus'";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `suggestion`","WHERE `suggestion`.`user`='$userid' $suggestionstatus2");
        
		$this->load->view("json",$data);
	} 
    
    
    
    
    
    
    public function postsugtweet()
    {
        $twitter = $this->hybridauthlib->authenticate("Twitter");
        
        $post=$this->input->get('id');
        $compost=$this->json_model->getpostsugdetails($post);
        $message=$compost->text;
        $twitterid = $twitter->getUserProfile();
        $twitterid = $twitterid->identifier;
        
        $userid=$this->session->userdata('id');
        $querytwitter=$this->db->query("SELECT `twitterid` FROM `user` WHERE `id`='$userid'")->row();
        $twitternid=$querytwitter->twitterid;
        if($twitterid==$twitternid) {
        $data["message"]=$twitter->api()->post("statuses/update.json?status=$message");
        if(isset($data["message"]->id_str))
        {
            $this->userpost_model->addpostid($data["message"]->id_str,$post);
            $data['alertsuccess']="Tweeted Successfully.";
            redirect('http://dellcampassador.com/success.html', 'location', 301);
        }
        else
        {
			$data['alerterror'] = "Tweet Error";
            $data['redirect']="site/viewtwitterpost";
		    $this->load->view("redirect",$data);
        }
        }
        else
        {
                $data['alerterror'] = "Please login with your own Twitter Profile.";
                $data['redirect']="site/viewtwitterpost";
                $this->load->view("redirect",$data);
        }
//        $this->load->view("json",$data);
    }
    
    public function postsugfb()
    {
        $post=$this->input->get('id');
        $compost=$this->json_model->getpostsugdetails($post);
        $message=$compost->text;
        $image=$compost->image;
        $link=$compost->link;
        
        $facebook = $this->hybridauthlib->authenticate("Facebook");
        
        
        $facebookid = $facebook->getUserProfile();
        $facebookid = $facebookid->identifier;
        
        $userid=$this->session->userdata('id');
        $queryfacebook=$this->db->query("SELECT `facebookid` FROM `user` WHERE `id`='$userid'")->row();
        $facebooknid=$queryfacebook->facebookid;
        
        if($facebookid==$facebooknid)
        {
            
        if($image=="")
        {
            $data["message"]=$facebook->api()->api("v2.2/me/feed", "post", array(
                "message" => "$message",
                "link"=>"$link"
            ));
            
            if(isset($data["message"]['id']))
            {
			$data['alertsuccess']="Posted Successfully.";
            $this->userpost_model->addpostid($data["message"]['id'],$post);
            redirect('http://dellcampassador.com/success.html', 'location', 301);
            }
            else
            {
                $data['alerterror'] = "Post Error";
                $data['redirect']="site/viewfacebookpost";
                $this->load->view("redirect",$data);
            }
        }
        else
        {
            $data["message"]=$facebook->api()->api("v2.2/me/feed", "post", array(
                "message" => "$message",
                "picture"=> "$image",
                "link"=>"$link"
            ));
            
//            print_r($data['message']["id"]);
            
            if(isset($data["message"]["id"]))
            {
			$data['alertsuccess']="Posted Successfully.";
            $this->userpost_model->addpostid($data["message"]["id"],$post);
            $data['redirect']="site/viewfacebookpost";
            $this->load->view("redirect",$data);
            }
            else
            {
                $data['alerterror'] = "Post Error";
                $data['redirect']="site/viewfacebookpost";
                $this->load->view("redirect",$data);
            }
        }
        
        
        }
        else
        {
            
                $data['alerterror'] = "Please login with your own Facebook Profile.";
                $data['redirect']="site/viewfacebookpost";
                //echo $data['alerterror'];
                $this->load->view("redirect",$data);
        }

        
    }
    
    
    
    public function createsuggestion() {
        
        $data = json_decode(file_get_contents('php://input'), true);

        $name=$data['text'];
        $contact=$data['image'];
        $city=$data['posttype'];
        $dob=$data['link'];
        
        if($this->json_model->createsugpost($text,$image,$posttype,$link)==0)
        $data['message']="false";
		else
		$data['message']="true";

		$this->load->view("json",$data);
    }
    
    
    
    
}
//EndOfFile
?>