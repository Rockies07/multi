<?php
class Repayment_model extends CI_Model
{
	private $table_name='transaction_loan_r';
	private $primary_key='id';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_data_list()
	{
		$this->db->select('repayment.id,repayment.name,repayment.description,repayment.business_id,business.name as business_name,repayment.client_id,client.name as client_name,repayment.deadline,repayment.contract_value');
		$this->db->from($this->table_name);
		$this->db->where('repayment.id !=','1');
		$this->db->join('business', 'business.id = repayment.business_id');
		$this->db->join('client', 'client.id = repayment.client_id');
		$this->db->order_by('name', 'ASC');
		return $this->db->get()->result_array();
	}
	
	function get_by_id($id)
	{
		$this->db->where($this->primary_key,$id);
		$query=$this->db->get($this->table_name);
		return $query->result();
	}

	function get_by_loan_id($id)
	{
		$this->db->select('transaction_loan_r.id,transaction_loan_r.repayment_date,transaction_loan_r.loan_id,transaction_loan_r.principal,transaction_loan_r.other_fee,transaction_loan_r.account_id,transaction_loan_r.remark, account.name as account_name, account.account_no as account_no,transaction_loan_r.status,transaction_loan_r.receipt');
		$this->db->from($this->table_name);
		$this->db->where('transaction_loan_r.loan_id',$id);
		$this->db->join('account', 'account.id = transaction_loan_r.account_id','left');
		$this->db->order_by('status', 'DESC');
		$this->db->order_by('repayment_date', 'ASC');

		$query=$this->db->get();
		return $query->result_array();
	}
	
	function insert($value)
	{
		$this->db->insert($this->table_name, $value);
		return $this->db->insert_id();
	}
	
	function update($id,$value)
	{
		$this->db->where($this->primary_key, $id);
		$this->db->update($this->table_name, $value);
	}
	
	function delete($id)
	{
		$this->db->where($this->primary_key, $id);
		$this->db->delete($this->table_name);
	}
	
	function get_repayment_count()
	{
		$query = $this->db->count_all_results($this->table_name);
		return $query;
	}
	
	function is_exist($field,$value)
	{
		$this->db->where($field,$value);
		$query=$this->db->get($this->table_name);
		return ($query->num_rows()>0)?$query->row():FALSE;
	}
	
	function get_repayment_by_value($field,$value)
	{
		if($field=="nts")
		{
			$this->db->where('nts',$value);
		}
		else
		{
			$this->db->where('name',$value);
		}
		
		$query=$this->db->get($this->table_name);
		return ($query->num_rows()>0)?$query->row():FALSE;
	}
	
	function get_repayment_list_by_value($value, $field){
		//$this->db->select('bird');
		
		if($field=="nts")
		{
			$this->db->like('nts', $value);
			$this->db->order_by('nts', 'ASC');
		}
		else 
		{
			$this->db->like('name', $value);
			$this->db->order_by('name', 'ASC');
		}
		$query = $this->db->get($this->table_name);
		if($query->num_rows > 0)
		{
	      	foreach ($query->result_array() as $row){
	      		if($field=="nts")
	      		{
	      			$row_set[] = htmlentities(stripslashes($row['nts']));
	      		}
	      		else
	      		{
	      			$row_set[] = htmlentities(stripslashes($row['name']));
	      		}
		      }
	      	echo json_encode($row_set); //format the array into json data
	      	exit();
	    }
	}
}


/* End of file Repayment_model.php */
/* Location: ./application/model/Repayment_model.php */