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

    
}
	
?>