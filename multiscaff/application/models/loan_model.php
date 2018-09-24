<?php
class Loan_model extends CI_Model
{
	private $table_name='transaction_loan_m';
	private $primary_key='id';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_data_list()
	{
		$this->db->select('loan.id,loan.name,loan.description,loan.business_id,business.name as business_name,loan.client_id,client.name as client_name,loan.deadline,loan.contract_value');
		$this->db->from($this->table_name);
		$this->db->where('loan.id !=','1');
		$this->db->join('business', 'business.id = loan.business_id');
		$this->db->join('client', 'client.id = loan.client_id');
		$this->db->order_by('name', 'ASC');
		return $this->db->get()->result_array();
	}
	
	function get_by_id($id)
	{
		$this->db->select('transaction_loan_m.id,transaction_loan_m.loan_no,transaction_loan_m.borrower_name,transaction_loan_m.borrower_code,transaction_loan_m.borrower_contact,transaction_loan_m.borrower_address,transaction_loan_m.borrower_hm_contact,transaction_loan_m.date,transaction_loan_m.amount, transaction_loan_m.account_id, account.name as account_name, account.account_no as account_no, transaction_loan_m.remark, transaction_loan_m.term, transaction_loan_m.package, transaction_loan_m.balance, transaction_loan_m.borrower_description');
		$this->db->from($this->table_name);
		$this->db->where('transaction_loan_m.id',$id);
		$this->db->join('account', 'account.id = transaction_loan_m.account_id','left');
		$query=$this->db->get();
		return ($query->num_rows()>0)?$query->row():FALSE;
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
	
	function get_loan_count()
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
	
	function get_loan_by_value($field,$value)
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
	
	function get_loan_list_by_value($value, $field){
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


/* End of file Loan_model.php */
/* Location: ./application/model/Loan_model.php */