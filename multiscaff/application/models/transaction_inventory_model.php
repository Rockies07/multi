<?php
class Transaction_inventory_model extends CI_Model
{
	private $table_name='transaction_inventory';
	private $primary_key='id';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_data_list($date_from="",$date_to="",$project="",$site="")
	{
		$this->db->select('transaction_inventory.id,transaction_inventory.date,transaction_inventory.project_id,project.name as project_name,transaction_inventory.site_id,site.name as site_name,transaction_inventory.amount, account.name as account_name,account.account_no as account_no,transaction_inventory.account_id as account_id,transaction_inventory.ledger_id,ledger.ledger as ledger,transaction_inventory.payer_payee,transaction_inventory.cheque,transaction_inventory.gst,transaction_inventory.type,transaction_inventory.description');
		$this->db->from($this->table_name);
		$this->db->join('account', 'account.id = transaction_inventory.account_id');
		$this->db->join('ledger', 'ledger.id = transaction_inventory.ledger_id');
		$this->db->join('project', 'project.id = transaction_inventory.project_id');
		$this->db->join('site', 'site.id = transaction_inventory.site_id');
		
		if($date_from=="")
		{
			$date_from=date("Y-m-d");
		}
		else
		{
			$date_arr=explode("/",$date_from);
			$date_from=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		}
		
		if($date_to=="")
		{
			$date_to=date("Y-m-d");
		}
		else
		{
			$date_arr=explode("/",$date_to);
			$date_to=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		}
		
		$this->db->where('transaction_inventory.date >=',$date_from);
		$this->db->where('transaction_inventory.date <=',$date_to);
		
		if($project!="")
		{
			$this->db->where('transaction_inventory.project_id',$project);
		}
		
		if(($site!="")&&($site!=0))
		{
			$this->db->where('transaction_inventory.site_id',$site);
		}
		return $this->db->get()->result_array();
	}

	function get_account_summary($date_from="",$date_to="",$project="",$site="")
	{
		if($date_from=="")
		{
			$date_from=date("Y-m-d");
		}
		else
		{
			$date_arr=explode("/",$date_from);
			$date_from=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		}
		
		if($date_to=="")
		{
			$date_to=date("Y-m-d");
		}
		else
		{
			$date_arr=explode("/",$date_to);
			$date_to=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
		}
		
		$date_filter="and tj.date between '$date_from' and '$date_to'";
		
		if($project!="")
		{
			$date_filter=$date_filter." and tj.project_id='$project'";
		}
		
		if(($site!="")&&($site!=0))
		{
			$date_filter=$date_filter." and tj.site_id='$site'";
		}

		$query=$this->db->query("select a.name as account_name, a.account_no as account_no, (select sum(amount) from transaction_inventory where account_id=a.id and type='Deposit') as amount_deposit, (select sum(amount) from transaction_inventory where account_id=a.id and type='Inventory Requisition') as amount_expenses, a.type as type from transaction_inventory tj, account a where tj.account_id=a.id $date_filter group by tj.account_id, tj.type");

		return $query->result_array();
	}
	
	function get_by_id($id)
	{
		$this->db->where($this->primary_key,$id);
		$query=$this->db->get($this->table_name);
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
	
	function is_exist($field,$value)
	{
		$this->db->where($field,$value);
		$query=$this->db->get($this->table_name);
		return ($query->num_rows()>0)?$query->row():FALSE;
	}
}


/* End of file Transaction_employee_model.php */
/* Location: ./application/model/Transaction_employee_model.php */