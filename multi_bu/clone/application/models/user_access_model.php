<?php
class User_access_model extends CI_Model
{
	private $table_name='clone_user';
	private $primary_key='id';
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function get_login($username)
	{
		$this->db->where('username',$username);
		$this->db->limit(1);
		$query=$this->db->get($this->table_name);
		return ($query->num_rows()>0)?$query->row():FALSE;
	}
	
	function get_user()
	{
		$query=$this->db->get($this->table_name);
		return $query->result_array();
	}
	
	function get_by_id($id)
	{
		$this->db->where($this->primary_key,$id);
		return $this->db->get($this->table_name)->row();
	}
	
	function insert($user)
	{
		$this->db->insert($this->table_name, $user);
		return $this->db->insert_id();
	}
	
	function update($id,$user)
	{
		$this->db->where($this->primary_key, $id);
		$this->db->update($this->table_name, $user);
	}
	
	function delete($id)
	{
		$this->db->where($this->primary_key, $id);
		$this->db->delete($this->table_name);
	}
}


/* End of file user_access_model.php */
/* Location: ./application/model/user_access_model.php */