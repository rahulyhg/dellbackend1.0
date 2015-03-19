<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Json_model extends CI_Model
{
	 function login($email,$password) 
    {
        $password=md5($password);
        $query=$this->db->query("SELECT `id` FROM `user` WHERE `email`='$email' AND `password`= '$password' AND `accesslevel`='2'");
        if($query->num_rows > 0)
        {
            $user=$query->row();
            $user=$user->id;
            

            $newdata = array(
                'email'     => $email,
                'password' => $password,
                'logged_in' => true,
                'id'=> $user
            );

            $this->session->set_userdata($newdata);
            //print_r($newdata);
            return $this->session->all_userdata();;
        }
        else
        return false;


    }
    function getallinfoofuser($id)
	{
		$user = $this->session->userdata('accesslevel');
		$query="SELECT DISTINCT `user`.`id` as `id`,`user`.`firstname` as `firstname`,`user`.`lastname` as `lastname`,`accesslevel`.`name` as `accesslevel`	,`user`.`email` as `email`,`user`.`contact` as `contact`,`user`.`status` as `status`,`user`.`accesslevel` as `access`,`user`.`rank` as `rank`
		FROM `user`
	   INNER JOIN `accesslevel` ON `user`.`accesslevel`=`accesslevel`.`id` 
       WHERE `user`.`id`='$id'";
		$query=$this->db->query($query)->row();
		return $query;
	}
    
    public function getstudentdash( )
	{
        $userid=$this->session->userdata("id");
		$query=$this->db->query("SELECT IFNULL(SUM(`userpost`.`share`+`userpost`.`likes`+`userpost`.`comment`+`userpost`.`retweet`+`userpost`.`favourites`),0) as `score`, `user`.`name`,`user`.`id`,`user`.`email`,`user`.`sex`,`user`.`city`,`user`.`dob`,IFNULL(SUM(`userpost`.`share`+`userpost`.`likes`+`userpost`.`comment`),0) as `facebook`,IFNULL(SUM(`userpost`.`retweet`+`userpost`.`favourites`),0) as `twitter`,IFNULL(SUM(`userpost`.`retweet`),0) as `totalretweet`,IFNULL(SUM(`userpost`.`favourites`),0) AS `totalfavourites`,IFNULL(SUM(`userpost`.`share`),0) AS `totalshare`,IFNULL(SUM(`userpost`.`likes` ),0) AS `totallikes`,IFNULL(SUM(`userpost`.`comment`),0) AS `totalcomment`,`user`.`rank` as `rank`,`user`.`image` as `image` FROM `user` LEFT OUTER JOIN `userpost` ON `user`.`id`=`userpost`.`user` WHERE `user`.`id`='$userid'")->row();
        $totalcountpost=$this->db->query("SELECT count(`id`) as `count1` FROM `post`")->row();
        $postdonebyuser=$this->db->query("SELECT COUNT(*) as `count2` FROM (SELECT DISTINCT `post` FROM `userpost` WHERE `userpost`.`user`='$userid') as `tab1`")->row();
        $query->totalpost=floatval($totalcountpost->count1);
        $query->actiondone=floatval($postdonebyuser->count2);
        $query->remaining=floatval($totalcountpost->count1)-floatval($postdonebyuser->count2);
		return $query;
	}
    
    
    function authenticate() {
        $is_logged_in = $this->session->userdata('logged_in');
//        print_r($is_logged_in);
        if ( $is_logged_in != 'true' || !isset( $is_logged_in ) ) {
            return false;
        } //$is_logged_in !== 'true' || !isset( $is_logged_in )
        else {
            $userid = $this->session->userdata( 'id' );
         return $this->session->all_userdata();
        }
    }
    
    public function getpostsofuserfb(  )
	{
        $id=$this->session->userdata("id");
		$query=$this->db->query("SELECT `userpost`.`id`,`userpost`.`post`, `userpost`.`likes`, `userpost`.`comment`, `userpost`.`favourites`, `userpost`.`retweet`, `userpost`.`returnpostid`, `userpost`.`posttype`,`posttype`.`name` AS `posttypename`, `userpost`.`user`,`userpost`.`share`, `userpost`.`timestamp`,`user`.`name` AS `username`,`post`.`text` AS `posttext`
        FROM `userpost`
        LEFT OUTER JOIN `user` ON `user`.`id`=`userpost`.`user`
        LEFT OUTER JOIN `post` ON `post`.`id`=`userpost`.`post`
        LEFT OUTER JOIN `posttype` ON `posttype`.`id`=`userpost`.`posttype`
        WHERE `userpost`.`user`='$id' AND `userpost`.`posttype`='1' AND `userpost`.`timestamp`<> '1970-01-01 17:00:00' AND `userpost`.`timestamp`<> '0000-00-00 00:00:00'")->result();
		return $query;
	}
    public function getpostsofusertwitter(  )
	{
        $id=$this->session->userdata("id");
		$query=$this->db->query("SELECT `userpost`.`id`,`userpost`.`post`, `userpost`.`likes`, `userpost`.`comment`, `userpost`.`favourites`, `userpost`.`retweet`, `userpost`.`returnpostid`, `userpost`.`posttype`,`posttype`.`name` AS `posttypename`, `userpost`.`user`,`userpost`.`share`, `userpost`.`timestamp`,`user`.`name` AS `username`,`post`.`text` AS `posttext`
        FROM `userpost`
        LEFT OUTER JOIN `user` ON `user`.`id`=`userpost`.`user`
        LEFT OUTER JOIN `post` ON `post`.`id`=`userpost`.`post`
        LEFT OUTER JOIN `posttype` ON `posttype`.`id`=`userpost`.`posttype`
        WHERE `userpost`.`user`='$id' AND `userpost`.`posttype`='2' AND `userpost`.`timestamp`<> '1970-01-01 17:00:00' AND `userpost`.`timestamp`<> '0000-00-00 00:00:00'")->result();
		return $query;
	}
    public function edituserprofile($name,$contact,$city,$dob)
	{
        $id=$this->session->userdata("id");
		$data  = array(
			'name' => $name,
			'contact'=> $contact,
            'dob'=> $dob,
            'city'=> $city,
		);

		$this->db->where( 'id', $id );
		$query=$this->db->update( 'user', $data );
        
		return 1;
	}
    
    public function changeuserpassword($password,$confirmpassword,$currentpassword)
    {
        $id=$this->session->userdata("id");
        if($password===$confirmpassword)
        {
            $data  = array(
                'password'=> md5($password)
            );

            $this->db->where( 'id', $id );
            $this->db->where( 'password', md5($currentpassword) );
            $query=$this->db->update( 'user', $data );
			return $this->db->affected_rows();
        }
        else
        {
            return 0;
        }
    }
    
    public function getfacebookstats()
	{
        $userid=$this->session->userdata("id");
        $totalcountpost=$this->db->query("SELECT count(`id`) as `count1` FROM `post` WHERE `posttype`='1'")->row();
        $postdonebyuser=$this->db->query("SELECT COUNT(*) as `count2` FROM (SELECT DISTINCT `post` FROM `userpost` WHERE `userpost`.`user`='$userid' AND `userpost`.`posttype`='1') as `tab1`")->row();
        $reach=$this->db->query("SELECT IFNULL(SUM(`userpost`.`share`+`userpost`.`likes`+`userpost`.`comment`),0) as `reach` FROM `userpost` WHERE `userpost`.`user`='$userid'  GROUP BY `userpost`.`user`")->row();
        $query=new stdClass();
        $query->totalpost=floatval($totalcountpost->count1);
        $query->actiondone=floatval($postdonebyuser->count2);
        $query->remaining=floatval($totalcountpost->count1)-floatval($postdonebyuser->count2);
        $query->reach=floatval($reach->reach);
		return $query;
	}
    
    public function gettwitterstats()
	{
        $userid=$this->session->userdata("id");
        $totalcountpost=$this->db->query("SELECT count(`id`) as `count1` FROM `post` WHERE `posttype`='2'")->row();
        $postdonebyuser=$this->db->query("SELECT COUNT(*) as `count2` FROM (SELECT DISTINCT `post` FROM `userpost` WHERE `userpost`.`user`='$userid' AND `userpost`.`posttype`='2') as `tab1`")->row();
        $reach=$this->db->query("SELECT IFNULL(SUM(`userpost`.`retweet`+`userpost`.`favourites`),0) as `reach` FROM `userpost` WHERE `userpost`.`user`='$userid' GROUP BY `userpost`.`user`" )->row();
        $query=new stdClass();
        $query->totalpost=floatval($totalcountpost->count1);
        $query->actiondone=floatval($postdonebyuser->count2);
        $query->remaining=floatval($totalcountpost->count1)-floatval($postdonebyuser->count2);
		return $query;
	}
	
	public function allsuggestion()
	{
		$userid=$this->session->userdata("id");
		$pending=$this->db->query("SELECT `suggestionstatus`,count(`id`) as `count`  FROM `suggestion` WHERE `suggestionstatus`='Pending' AND `user` = $userid")->row();
		$publish=$this->db->query("SELECT `suggestionstatus`,count(`id`) as `count`  FROM `suggestion` WHERE `suggestionstatus`='Publish' AND `user` = $userid")->row();
		$rejected=$this->db->query("SELECT `suggestionstatus`,count(`id`) as `count`  FROM `suggestion` WHERE `suggestionstatus`='Rejected' AND `user` = $userid")->row();
		$suggested=$this->db->query("SELECT `suggestionstatus`,count(`id`) as `count`  FROM `suggestion` WHERE `user` = '$userid'")->row();
		$query=new stdClass();
		$query->pendingp=$pending;
		$query->publishp=$publish;
		$query->rejectedp=$rejected;
		$query->suggestedp=$suggested;
		return $query;
	}
    
    public function beforeedit(  )
	{
        $id=$this->session->userdata("id");
		$query=$this->db->query( "SELECT `college`.`name` as `collegename`,`user`.* FROM `user` INNER JOIN `college` ON `college`.`id` =`user`.`college` WHERE `user`.`id`='$id'" )->row();
		return $query;
	}
    public function getnextpost($lastid=0,$direction=1,$social=1)
    {

        if($direction==1)
        {
            $sign=">";
            $orderby="ASC";
        }
        else
        {
            $sign="<";
            $orderby="DESC";
        }
        
        $query=$this->db->query("SELECT  `post`.`id`  AS `id` ,  `post`.`text`  AS `text` ,  `post`.`image`  AS `image` ,  `post`.`posttype`  AS `posttype` ,  `post`.`timestamp`  AS `timestamp` ,  `posttype`.`name`  AS `posttypename` ,  `userpost`.`returnpostid`  AS `returnpostid` ,  `post`.`link`  AS `link`  FROM `post` LEFT OUTER JOIN `posttype` ON `posttype`.`id`=`post`.`posttype` LEFT OUTER JOIN `userpost` ON `userpost`.`post`=`post`.`id`  WHERE `post`.`posttype`='$social' AND `post`.`id` $sign '$lastid' GROUP BY `post`.`id` ORDER BY  `post`.`timestamp` $orderby LIMIT 0,1");
        $roweffected=$query->num_rows();
        if($roweffected!=1)
        {
             $result=$this->db->query("SELECT  `post`.`id`  AS `id` ,  `post`.`text`  AS `text` ,  `post`.`image`  AS `image` ,  `post`.`posttype`  AS `posttype` ,  `post`.`timestamp`  AS `timestamp` ,  `posttype`.`name`  AS `posttypename` ,  `userpost`.`returnpostid`  AS `returnpostid` ,  `post`.`link`  AS `link`  FROM `post` LEFT OUTER JOIN `posttype` ON `posttype`.`id`=`post`.`posttype` LEFT OUTER JOIN `userpost` ON `userpost`.`post`=`post`.`id`  WHERE `post`.`posttype`='$social' GROUP BY `post`.`id` ORDER BY  `post`.`timestamp` $orderby LIMIT 0,1")->row();
        }
        else
        {
            $result=$query->row();
        }
        return $result;
        
    }   
    
    public function getuserpostcount($post)
	{
        $id=$this->session->userdata("id");
		$query=$this->db->query( "SELECT count(*) as `count` FROM `userpost` WHERE `user`='$id' AND `post`='$post'" )->row();
		return $query;
	}
    
    public function getpostdetails($post)
	{
        $query=$this->db->query( "SELECT * FROM `post` WHERE `id`='$post'" )->row();
		return $query;
	}
    
    public function getpostsugdetails($post)
	{
        $query=$this->db->query( "SELECT * FROM `suggestion` WHERE `id`='$post'" )->row();
		return $query;
	}
    
    public function createsugpost($text,$image,$posttype,$link)
	{
        $userid=$this->session->userdata("id");
		$data  = array(
			'text' => $text,
			'user' => $userid,
			'suggestionstatus' => 'Pending',
			'posttype' => $posttype,
			'link' => $link,
			'image' => $image
		);
		$query=$this->db->insert( 'suggestion', $data );
		$id=$this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  $id;
	}
    
    
    
}
	
?>