<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Post_model extends CI_Model
{
	public function create($text,$image,$posttype,$link)
	{
		$data  = array(
			'text' => $text,
			'posttype' => $posttype,
			'link' => $link,
			'image' => $image
		);
		$query=$this->db->insert( 'post', $data );
		$id=$this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewpost()
	{
		$query="SELECT `id`, `name` FROM `post`";
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'post' )->row();
		return $query;
	}
	
	public function edit($id,$text,$image,$posttype,$link)
	{
		$data  = array(
			'text' => $text,
			'posttype' => $posttype,
			'link' => $link,
			'image' => $image
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'post', $data );
		return 1;
	}
	function deletepost($id)
	{
		$query=$this->db->query("DELETE FROM `post` WHERE `id`='$id'");
	}
    
	public function getpostimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `post` WHERE `id`='$id'")->row();
		return $query;
	}
    
    public function getpostdropdown()
	{
		$query=$this->db->query("SELECT * FROM `post`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->text;
		}
		
		return $return;
	}
    public function getposttypedropdown()
	{
		$query=$this->db->query("SELECT * FROM `posttype`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
    public function viewquickpost()
    {
        $data=$this->db->query("SELECT  `post`.`id`  AS `id` ,  `post`.`text`  AS `text` ,  `post`.`image`  AS `image` ,`posttype`.`name` as `posttypename`,  `post`.`posttype`  AS `posttype` ,  `userpost`.`returnpostid`  AS `returnpostid`,  `post`.`link` AS `link` FROM `post` LEFT OUTER JOIN `posttype` ON `posttype`.`id`=`post`.`posttype` LEFT OUTER JOIN `userpost` ON `userpost`.`post`=`post`.`id`  GROUP BY `post`.`id`    ORDER BY  `id` ASC,  1  LIMIT 0,10")->result();
        return $data;
    }
    
}
	
?>