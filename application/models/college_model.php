<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class college_model extends CI_Model
{
	public function create($name,$address)
	{
		$data  = array(
			'name' => $name,
			'address' => $address
		);
		$query=$this->db->insert( 'college', $data );
		$id=$this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewcollege()
	{
		$query="SELECT `id`, `name` FROM `college`";
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'college' )->row();
		return $query;
	}
	
	public function edit($id,$name,$address)
	{
		$data  = array(
			'name' => $name,
			'address' => $address
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'college', $data );
		return 1;
	}
	function deletecollege($id)
	{
		$query=$this->db->query("DELETE FROM `college` WHERE `id`='$id'");
	}
    
    public function getcollegedropdown()
	{
		$query=$this->db->query("SELECT * FROM `college`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
}
	
?>