<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class suggestion_model extends CI_Model
{
	public function create($text,$image,$user,$posttype,$link)
	{
		$data  = array(
			'text' => $text,
			'user' => $user,
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
			return  1;
	}
	function viewsuggestion()
	{
		$query="SELECT `id`, `name` FROM `suggestion`";
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'suggestion' )->row();
		return $query;
	}
	
	public function edit($id,$text,$image,$user,$suggestionstatus,$message)
	{
		$data  = array(
			'text' => $text,
			'user' => $user,
			'suggestionstatus' => $suggestionstatus,
			'adminmessage' => $message,
			'image' => $image
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'suggestion', $data );
		return 1;
	}
	function deletesuggestion($id)
	{
		$query=$this->db->query("DELETE FROM `suggestion` WHERE `id`='$id'");
	}
    function approvesuggestion($id)
	{
		$query=$this->db->query("UPDATE `suggestion` SET `suggestionstatus` = 'Publish' , `adminmessage`='Good Post' WHERE `id`='$id'");
	}
    
	public function getsuggestionimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `suggestion` WHERE `id`='$id'")->row();
		return $query;
	}
    
    public function getsuggestiondropdown()
	{
		$query=$this->db->query("SELECT * FROM `suggestion`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->text;
		}
		
		return $return;
	}
	public function getsuggestionstatusdropdown()
	{
		$status= array(
			 "Pending" => "Pending",
			 "Publish" => "Publish",
			 "Unpublish" => "Unpublish"
			);
		return $status;
	}
	
}
	
?>