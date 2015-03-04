<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cron extends CI_Controller 
{
    function socialupdate() 
    {
        $this->load->library("facebookoauth");
        $this->load->library('twitteroauth');
    $userpostquery=$this->db->query("SELECT `id`,`returnpostid`,`posttype` FROM `userpost`")->result();
    foreach($userpostquery as $userpost)
    {
        $returnpostid=$userpost->returnpostid;
        $posttype=$userpost->posttype;
        $id=$userpost->id;
        if($posttype==1)
        {

            $facebookdet=$this->facebookoauth->get_post($returnpostid);
            
            $this->userpost_model->addfacebookcrondata($id,$facebookdet->date,$facebookdet->likes,$facebookdet->shares,$facebookdet->comments);
        }
        else if($posttype==2)
        {
            
		// Loading twitter configuration.
		    $this->config->load('twitter');
            $this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('access_token'),  $this->session->userdata('access_token_secret'));
            $data["message"] = $this->twitteroauth->get('statuses/show.json?id='.$returnpostid);

if(isset($data["message"]->created_at))
            {
                $created_at=$data["message"]->created_at;

$created_at=strtotime($created_at);
$created_at=date("Y-m-d H:i:s",$created_at);
//print_r($created_at);

            }
            else
            {
                $created_at=0;
            }


            if(isset($data["message"]->retweet_count))
            {
                $retweet=$data["message"]->retweet_count;
            }
            else
            {
                $retweet=0;
            }
            if(isset($data["message"]->favorite_count))
            {
                $favourites=$data["message"]->favorite_count;
            }
            else
            {
                $favourites=0;
            }
            $this->userpost_model->addtwittercrondata($id,$created_at,$retweet,$favourites);
        }
    }
        
        $this->user_model->assignranks();
        
	
	}
    
function socialupdate2() 
    {
        $this->load->library("facebookoauth");
        $this->load->library('twitteroauth');
    $userpostquery=$this->db->query("SELECT `id`,`returnpostid`,`posttype` FROM `userpost` WHERE `posttype`='1' ")->result();
    foreach($userpostquery as $userpost)
    {
        $returnpostid=$userpost->returnpostid;
        $posttype=$userpost->posttype;
        $id=$userpost->id;
        if($posttype==1)
        {

            $facebookdet=$this->facebookoauth->get_post($returnpostid);
            
            $this->userpost_model->addfacebookcrondata($id,$facebookdet->date,$facebookdet->likes,$facebookdet->shares,$facebookdet->comments);
        }
        else if($posttype==2)
        {
            
		// Loading twitter configuration.
		    $this->config->load('twitter');
            $this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('access_token'),  $this->session->userdata('access_token_secret'));
            $data["message"] = $this->twitteroauth->get('statuses/show.json?id='.$returnpostid);

if(isset($data["message"]->created_at))
            {
                $created_at=$data["message"]->created_at;

$created_at=strtotime($created_at);
$created_at=date("Y-m-d H:i:s",$created_at);
//print_r($created_at);

            }
            else
            {
                $created_at=0;
            }


            if(isset($data["message"]->retweet_count))
            {
                $retweet=$data["message"]->retweet_count;
            }
            else
            {
                $retweet=0;
            }
            if(isset($data["message"]->favorite_count))
            {
                $favourites=$data["message"]->favorite_count;
            }
            else
            {
                $favourites=0;
            }
            $this->userpost_model->addtwittercrondata($id,$created_at,$retweet,$favourites);
        }
    }
        
        $this->user_model->assignranks();
        
	
	}
function checkfb() {
$facebook = $this->hybridauthlib->getAdapter("Facebook");
$data=$facebook->api()->api("v2.2/776428585783323_781365958622919", "GET");
print_r($data);
}


}
//EndOfFile
?>