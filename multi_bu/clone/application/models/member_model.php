<?php
class Member_model extends CI_Model
{
	private $table_name='memberid';
	private $primary_key='id';
	
	function __construct()
	{
		parent::__construct();
	}

	function get_data_list()
	{	
		$this->db->order_by('memberid');
		$query=$this->db->get($this->table_name);
		return $query->result_array();
	}

	function get_member_report()
	{	
		$this->db->select('memberid.memberid, memberid.membername, memberid.membercontact1, memberid.bankaccount, memberid.remarks, memberid.sms, memberid.membercontact2, memberid.ranking, memberid.status, memberid.managerid, member_total.total, member_total.outstanding, member_total.amountdue, member_log.logindate,ranking.name as ranking_name');
		$this->db->from($this->table_name);
		$this->db->join('member_total', 'member_total.memberid = memberid.memberid', left);
		$this->db->join('member_log', 'member_log.memberid = memberid.memberid', left);
		$this->db->join('ranking', 'ranking.no = memberid.ranking', left);
		$this->db->where('clone_show', '1');
		$this->db->order_by('memberid');
		$query=$this->db->get();
		return $query->result_array();
	}

	function get_member_report_detail($memberid)
	{	
		$query=$this->db->query(
			"(SELECT ref,bmdate,entriesby,memberid,amount,type,cpyaccount,pm,clr,remark,'payment' as method FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT')
			UNION 
			(SELECT ref,bmdate,entriesby,memberid,amount,type,cpyaccount,pm,clr,remark,'payment' as method FROM bmdatabase_payment where memberid in (SELECT subid from submembers where memberid='$memberid')) 
			UNION
			(SELECT ref,bmdate,entriesby,memberid,amount,type,subbmcode,pm,clr,remark,'placeout' as method FROM bmdatabase_wlplaceout where memberid = '$memberid' $hide_me) 
			UNION 
			(SELECT ref,bmdate,entriesby,memberid,amount,type,subbmcode,pm,clr,remark,'placeout' as method FROM bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid' order by bmdate desc) and NOT type = 'INT') 
			ORDER BY (case when memberid = '$memberid' then 0 else 1 end), memberid asc, bmdate desc, ref desc"
		);
		return $query->result_array();
	}

	function get_member_report_total($memberid)
	{	
		$query=$this->db->query(
			"SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='0')) as outstanding, (SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='1')) 
 			 FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='1') as pmdue FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='0'"
		);
		return ($query->num_rows()>0)?$query->row():FALSE;
	}

	function get_page_total($memberid)
	{
		$outstanding_total=$this->db->query(
			"SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='0') + (select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid') and pm='0') + (select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid='$memberid') and pm='0')) as outstanding FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='0'");
		$outstanding_total_detail = ($outstanding_total->num_rows()>0)?$outstanding_total->row():FALSE;
		$total_outstanding=$outstanding_total_detail->outstanding;

		$due_total=$this->db->query(
			"SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='1')+(SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid') and pm='1')+(SELECT ifnull(SUM(amount),0) FROM bmdatabase_payment where memberid in (select subid from submembers where memberid='$memberid') and pm='1')) as pmdue FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='1'");
		$due_total_detail = ($due_total->num_rows()>0)?$due_total->row():FALSE;
		$total_due=$due_total_detail->pmdue;

		$data['total_outstanding']=$total_outstanding;
		$data['total_due']=$total_due;
		$data['grand_total']=$total_outstanding+$total_due;

		return $data;
	}

	function get_member_list()
	{	
		$this->db->order_by('memberid');
		$query=$this->db->get($this->table_name);
		return $query->result_array();
	}
	
	function get_by_id($id)
	{
		$this->db->where('memberid',$id);
		$query=$this->db->get($this->table_name);
		return ($query->num_rows()>0)?$query->row():FALSE;
	}
	
	function insert($value)
	{
		$this->db->insert($this->table_name, $value);
		return $this->db->insert_id();
	}

	function insert_batch($value)
	{
		$this->db->insert_batch($this->table_name, $value);
	}
	
	function update($id,$value)
	{
		$this->db->where('memberid', $id);
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


/* End of file User_model.php */
/* Location: ./application/model/User_model.php */