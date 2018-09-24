<?php
class Transaction_model extends CI_Model
{
	private $table_name='bmdatabase_wlplaceout';
	private $primary_key='id';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_by_id($table_name,$id)
	{
		$this->db->where('ref',$id);
		$query=$this->db->get($table_name);
		return ($query->num_rows()>0)?$query->row():FALSE;
	}
	
	function insert($table_name,$value)
	{
		$this->db->insert($table_name, $value);
		return $this->db->insert_id();
	}
	
	function update($table_name,$id,$value)
	{
		$this->db->where('ref', $id);
		$this->db->update($table_name, $value);
	}

	function update_member_total($id,$value)
	{
		$this->db->where('memberid', $id);
		$this->db->update('member_total', $value);
	}

	function update_by_member($table_name,$memberid,$value)
	{
		$this->db->like('memberid', $memberid);
		$this->db->update($table_name, $value);
	}
	
	function delete($table_name,$id)
	{
		$this->db->where('ref', $id);
		$this->db->delete($table_name);
	}

	function get_sum_payment($table_name,$memberid)
	{
		$this->db->select_sum('amount');
	    $this->db->from($table_name);
	    $this->db->where('pm','1');
	    $this->db->like('memberid',$memberid);
	    $query = $this->db->get();
	    return ($query->num_rows()>0)?$query->row():FALSE;
	}
}


/* End of file User_model.php */
/* Location: ./application/model/User_model.php */