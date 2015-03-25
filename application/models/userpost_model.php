<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Userpost_model extends CI_Model
{
	//topic
	public function create($user,$likes,$share,$post,$comment,$favourites,$retweet)
	{
        $posttype=$this->db->query("SELECT * FROM `post` WHERE `id`='$post'")->row();
        $posttype=$posttype->posttype;
		$data  = array(
			'user' => $user,
			'likes' => $likes,
			'post' => $post,
			'comment' => $comment,
			'favourites' => $favourites,
			'retweet' => $retweet,
			'posttype' => $posttype,
			'share' => $share
		);
		$query=$this->db->insert( 'userpost', $data );
		
		return  1;
	}
	function viewuserpostbyuser($id)
	{
		$query="SELECT `userpost`.`id`,`userpost`.`post`, `userpost`.`likes`, `userpost`.`comment`, `userpost`.`favourites`, `userpost`.`retweet`, `userpost`.`returnpostid`, `userpost`.`posttype`,`posttype`.`name` AS `posttypename`, `userpost`.`user`,`userpost`.`share`, `userpost`.`timestamp`,`user`.`name` AS `username`,`post`.`text` AS `posttext`
        FROM `userpost`
        LEFT OUTER JOIN `user` ON `user`.`id`=`userpost`.`user`
        LEFT OUTER JOIN `post` ON `post`.`id`=`userpost`.`post`
        LEFT OUTER JOIN `posttype` ON `posttype`.`id`=`userpost`.`posttype`
        WHERE `userpost`.`user`='$id' AND `userpost`.`timestamp`<> '1970-01-01 05:30:00' AND `userpost`.`timestamp`<> '0000-00-00 00:00:00'";
        $result=$this->db->query($query)->result();
        
        return $result;
        
//		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'userpost' )->row();
		return $query;
	}
    
	public function getuserpostbyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `userpost` WHERE `id`='$id'")->row();
		return $query;
	}
	
	public function edit( $id,$user,$post,$likes,$share,$comment,$favourites,$retweet)
	{
        $posttype=$this->db->query("SELECT * FROM `post` WHERE `id`='$post'")->row();
        $posttype=$posttype->posttype;
		$data = array(
			'user' => $user,
			'likes' => $likes,
			'post' => $post,
			'comment' => $comment,
			'favourites' => $favourites,
			'retweet' => $retweet,
			'posttype' => $posttype,
			'share' => $share
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'userpost', $data );
		
		return 1;
	}
	public function addpostid($returnpostid,$post)
	{
        $query=$this->db->query("SELECT * FROM `post` WHERE `id`='$post'")->row();
        $posttype=$query->posttype;
        $userid=$this->session->userdata('id');
            $data = array(
			'user' => $userid,
			'post' => $post,
			'returnpostid' => $returnpostid,
			'posttype' => $posttype
		      );
            $userpost=$this->db->insert( 'userpost', $data );
       
		return 1;
	}
	function deleteuserpost($id)
	{
		$query=$this->db->query("DELETE FROM `userpost` WHERE `id`='$id'");
		
	}
    
     public function getpropertydropdown()
	{
		$query=$this->db->query("SELECT * FROM `property`  ORDER BY `id` ASC")->result();
		$return=array();
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
	public function addfacebookcrondata($id,$date,$likes,$shares,$comments)
	{
		$data = array(
'timestamp' => $date,
			'likes' => $likes,
			'comment' => $comments,
			'share' => $shares
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'userpost', $data );
		
		return 1;
	}
	public function addtwittercrondata($id,$date,$retweet,$favourites)
	{
		$data = array(
'timestamp' => $date,
			'favourites' => $favourites,
			'retweet' => $retweet
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'userpost', $data );
		
		return 1;
	}
    
	public function getpostsofuser( $id )
	{
		$query=$this->db->query("SELECT `userpost`.`id`,`userpost`.`post`, `userpost`.`likes`, `userpost`.`comment`, `userpost`.`favourites`, `userpost`.`retweet`, `userpost`.`returnpostid`, `userpost`.`posttype`,`posttype`.`name` AS `posttypename`, `userpost`.`user`,`userpost`.`share`, `userpost`.`timestamp`,`user`.`name` AS `username`,`post`.`text` AS `posttext`
        FROM `userpost`
        LEFT OUTER JOIN `user` ON `user`.`id`=`userpost`.`user`
        LEFT OUTER JOIN `post` ON `post`.`id`=`userpost`.`post`
        LEFT OUTER JOIN `posttype` ON `posttype`.`id`=`userpost`.`posttype`
        WHERE `userpost`.`user`='$id'")->result();
		return $query;
	}
    public function getadmindash( )
	{
		$query=$this->db->query("SELECT IFNULL(SUM(`userpost`.`share`+`userpost`.`likes`+`userpost`.`comment`+`userpost`.`retweet`+`userpost`.`favourites`),0) as `score`, `user`.`name`,`user`.`id`,`user`.`email`,IFNULL(SUM(`userpost`.`share`+`userpost`.`likes`+`userpost`.`comment`),0) as `facebook`,IFNULL(SUM(`userpost`.`retweet`+`userpost`.`favourites`),0) as `twitter`,IFNULL(SUM(`userpost`.`retweet`),0) as `totalretweet`,IFNULL(SUM(`userpost`.`favourites`),0) AS `totalfavourites`,IFNULL(SUM(`userpost`.`share`),0) AS `totalshare`,IFNULL(SUM(`userpost`.`likes` ),0) AS `totallikes`,IFNULL(SUM(`userpost`.`comment`),0) AS `totalcomment` FROM `user` LEFT OUTER JOIN `userpost` ON `user`.`id`=`userpost`.`user`")->row();
		return $query;
	}
    public function getstudentdash( )
	{
        $userid=$this->session->userdata("id");
		$query=$this->db->query("SELECT IFNULL(SUM(`userpost`.`share`+`userpost`.`likes`+`userpost`.`comment`+`userpost`.`retweet`+`userpost`.`favourites`),0) as `score`, `user`.`name`,`user`.`id`,`user`.`email`,IFNULL(SUM(`userpost`.`share`+`userpost`.`likes`+`userpost`.`comment`),0) as `facebook`,IFNULL(SUM(`userpost`.`retweet`+`userpost`.`favourites`),0) as `twitter`,IFNULL(SUM(`userpost`.`retweet`),0) as `totalretweet`,IFNULL(SUM(`userpost`.`favourites`),0) AS `totalfavourites`,IFNULL(SUM(`userpost`.`share`),0) AS `totalshare`,IFNULL(SUM(`userpost`.`likes` ),0) AS `totallikes`,IFNULL(SUM(`userpost`.`comment`),0) AS `totalcomment`,`user`.`rank` as `rank` FROM `user` LEFT OUTER JOIN `userpost` ON `user`.`id`=`userpost`.`user` WHERE `user`.`id`='$userid'")->row();
        $totalcountpost=$this->db->query("SELECT count(`id`) as `count1` FROM `post`")->row();
        $postdonebyuser=$this->db->query("SELECT COUNT(*) as `count2` FROM (SELECT DISTINCT `post` FROM `userpost` WHERE `userpost`.`user`='$userid') as `tab1`")->row();
        
        $query->remaining=floatval($totalcountpost->count1)-floatval($postdonebyuser->count2);
		return $query;
	}

    function exportexcelreport()
	{
		$this->load->dbutil();
		$query=$this->db->query("SELECT `user`.`name` AS `User Name`,`posttype`.`name` AS `Post Type`,`userpost`.`likes` AS `Likes`, `userpost`.`comment` AS `Comments`,`userpost`.`share` AS `Shares`,`userpost`.`retweet` AS `Retweets`, `userpost`.`favourites` AS `Favourites`,  `userpost`.`timestamp` AS `Timestamp`,`post`.`text` AS `Post Text`
        FROM `userpost`
        INNER JOIN `user` ON `user`.`id`=`userpost`.`user`
        LEFT OUTER JOIN `post` ON `post`.`id`=`userpost`.`post`
        LEFT OUTER JOIN `posttype` ON `posttype`.`id`=`userpost`.`posttype` WHERE `userpost`.`timestamp`<>'0000-00-00 00:00:00'
");

       $content= $this->dbutil->csv_from_result($query);
        $timestamp=new DateTime();
        $timestamp=$timestamp->format('Y-m-d_H.i.s');
        //$data = 'Some file data';

        if ( ! write_file("./uploads/campassadorreport_$timestamp.csv", $content))
        {
             echo 'Unable to write the file';
        }
        else
        {
            redirect(base_url("uploads/campassadorreport_$timestamp.csv"), 'refresh');
             echo 'File written!';
        }
//        file_put_contents("gs://toykraftdealer/retailerfilefromdashboard_$timestamp.csv", $content);
//		redirect("http://admin.toy-kraft.com/servepublic?name=retailerfilefromdashboard_$timestamp.csv", 'refresh');
	}
}
?>