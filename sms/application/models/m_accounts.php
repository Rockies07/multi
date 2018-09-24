
<?php
Class m_Accounts extends CI_Model
{
	function login($username, $password, $account_type, $account_db)
	{
		$this -> db -> select($account_db,' password');
		$this -> db -> from($account_type);
		$this -> db -> where($account_db, $username);
		$this -> db -> where('password', $password);
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	function getintake($uid)
	{
		switch(strlen($uid))
		{
			case 2: $account_db = "users_mas";
					$account_type = "mas_id";
					break;
			case 4: $account_db = "users_agg";
					$account_type = "agg_id";
					break;
			case 6: $account_db = "users_agt";
					$account_type = "agt_id";
					break;
		}

		$sql = "SELECT intake_big, intake_small,intake_tax,placeout_com FROM $account_db WHERE $account_type = ?"; 
		$query = $this->db->query($sql, array($uid)); 

		foreach ($query->result_array() as $row)
		{
		   return $row;
		}	
	}

	function getinfo($uid)
	{
		switch(strlen($uid))
		{
			case 2: $account_db = "users_mas";
					$account_type = "mas_id";
					break;
			case 4: $account_db = "users_agg";
					$account_type = "agg_id";
					break;
			case 6: $account_db = "users_agt";
					$account_type = "agt_id";
					break;
			case 8: $account_db = "users_meb";
					$account_type = "meb_id";
					break;
		}

		$sql = "SELECT * FROM $account_db WHERE $account_type = ?"; 
		$query = $this->db->query($sql, array($uid)); 
		foreach ($query->result_array() as $row)
		{
		   return $row;
		}	
	}

	function secure_getinfo($uid,$ownuid)
	{
		switch(strlen($uid))
		{
			case 2: $account_db = "users_mas";
					$account_type = "mas_id";
					break;
			case 4: $account_db = "users_agg";
					$account_type = "agg_id";
					break;
			case 6: $account_db = "users_agt";
					$account_type = "agt_id";
					break;
			case 8: $account_db = "users_meb";
					$account_type = "meb_id";
					break;
		}
		switch(strlen($ownuid))
		{
			case 2: $account_type2 = "mas_id";
					break;
			case 4: $account_type2 = "agg_id";
					break;
			case 6: $account_type2 = "agt_id";
					break;
		}

		$sql = "SELECT * FROM $account_db WHERE $account_type = ? and $account_type2 = ?"; 
		$query = $this->db->query($sql, array($uid, $ownuid)); 
		foreach ($query->result_array() as $row)
		{
		   return $row;
		}	
	}

	function getfixpage($uid)
	{
		$sql = "SELECT distinct(pageref) FROM transactions_fix WHERE meb_id = ?"; 
		$query = $this->db->query($sql, array($uid)); 
		
		$data[''] = '-- Add New Page --';

		foreach ($query->result_array() as $row)
		{
		   $data[$row['pageref']] = $row['pageref'];
		}
		return $data;
	}

	function getfixpagedata($uid,$pageref)
	{
		$sql = "SELECT number,cmd,amt_big,amt_small,numinpage FROM transactions_fix WHERE meb_id = ? and pageref = ? order by numinpage asc"; 
		$query = $this->db->query($sql, array($uid,$pageref)); 
		
		foreach ($query->result_array() as $row)
		{
		   $data[] = array('number' => $row['number'],
						'cmd' => $row['cmd'],
						'amt_big' => $row['amt_big'],
						'amt_small' => $row['amt_small'],
						'numinpage' => $row['numinpage'],
						);
		}
		return $data;
	}

	function delfixpagedata($uid,$pageref)
	{
		$sql = "DELETE FROM transactions_fix WHERE meb_id = ? and pageref = ?"; 
		$query = $this->db->query($sql, array($uid,$pageref)); 
	}

	function getbetrecords($fromdate,$todate,$uid)
	{
		switch(strlen($uid))
		{
			case 2: $account_type = "mas_id";
					break;
			case 4: $account_type = "agg_id";
					break;
			case 6: $account_type = "agt_id";
					break;
			case 8: $account_type = "meb_id";
					break;
		}

		$sql = "SELECT * FROM bet_records WHERE $account_type = ? and drawdate >= ? and drawdate <= ? order by meb_id,drawdate,entrytime asc"; 
		$query = $this->db->query($sql, array($uid, $fromdate, $todate)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$results[$x] = $row;
				$x = $x + 1;
			}
			return $results;
		}
	}

	function getpagedetails($ref,$drawdate)
	{
		$sql = "SELECT * FROM page_details WHERE ref = ? and drawdate = ? order by numinpage asc"; 
		$query = $this->db->query($sql, array($ref, $drawdate)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$results[$x] = $row;
			$x = $x + 1;
		}
		return $results;
	}

	function getupload_records($uid)
	{
		$sql = "SELECT * FROM ara_upload WHERE uploaded_by = ?"; 
		$query = $this->db->query($sql, array($uid)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$results[$x] = $row;
				$x = $x + 1;
			}
			return $results;
		}
	}

	function delupload_records($fileref,$uid)
	{
		$sql = "DELETE FROM ara_upload WHERE uploaded_by = ? and fileref = ?"; 
		$query = $this->db->query($sql, array($uid,$fileref)); 
		$sql = "DELETE FROM ara_data WHERE fileref = ?"; 
		$query = $this->db->query($sql, array($fileref)); 
	}


	function getmyplaceouttotal($fromdate,$todate,$uid)
	{
		switch(strlen($uid))
		{
			case 2: $sql = "SELECT 
							sum((((amt_big + amt_ibig) * 1.6) + ((amt_small + amt_ismall) * 0.7))  * (mas_com / 100) ) as com_amount,
							sum(((amt_big + amt_ibig) * 1.6) + ((amt_small + amt_ismall) * 0.7)) as po_total_amount,
							sum(amt_big) as amt_big,
							sum(amt_small) as amt_small,
							sum(amt_ibig) as amt_ibig,
							sum(amt_ismall) as amt_ismall,
							sum(strike) as strike,
							sum(sms_charges) as sms_charges
							FROM bet_records
							where 
							mas_id = ?
							and 
							drawdate >= ? 
							and 
							drawdate <= ?
							";
							break;
			case 4: $sql = "SELECT 
							sum((((amt_big + amt_ibig) * 1.6) + ((amt_small + amt_ismall) * 0.7))  * (agg_com / 100) ) as com_amount,
							sum(((amt_big + amt_ibig) * 1.6) + ((amt_small + amt_ismall) * 0.7)) as po_total_amount,
							sum(amt_big) as amt_big,
							sum(amt_small) as amt_small,
							sum(amt_ibig) as amt_ibig,
							sum(amt_ismall) as amt_ismall,
							sum(strike) as strike,
							sum(sms_charges) as sms_charges
							FROM bet_records 
							where 
							agg_id = ?
							and 
							drawdate >= ? 
							and 
							drawdate <= ?
							";
							break;
			case 6: $sql = "SELECT 
							sum((((amt_big + amt_ibig) * 1.6) + ((amt_small + amt_ismall) * 0.7))  * (agt_com / 100) ) as com_amount,
							sum(((amt_big + amt_ibig) * 1.6) + ((amt_small + amt_ismall) * 0.7)) as po_total_amount,
							sum(amt_big) as amt_big,
							sum(amt_small) as amt_small,
							sum(amt_ibig) as amt_ibig,
							sum(amt_ismall) as amt_ismall,
							sum(strike) as strike,
							sum(sms_charges) as sms_charges
							FROM bet_records 
							where 
							agt_id = ?
							and 
							drawdate >= ? 
							and 
							drawdate <= ?
							";
							break;
			case 8: $sql = "SELECT 
							sum((((amt_big + amt_ibig) * 1.6) + ((amt_small + amt_ismall) * 0.7))  * (meb_com / 100) ) as com_amount,
							sum(((amt_big + amt_ibig) * 1.6) + ((amt_small + amt_ismall) * 0.7)) as po_total_amount,
							sum(amt_big) as amt_big,
							sum(amt_small) as amt_small,
							sum(amt_ibig) as amt_ibig,
							sum(amt_ismall) as amt_ismall,
							sum(strike) as strike,
							sum(sms_charges) as sms_charges
							FROM bet_records 
							where 
							meb_id = ?
							and 
							drawdate >= ? 
							and 
							drawdate <= ?
							";
							break;
		}

		$query = $this->db->query($sql, array($uid, $fromdate, $todate)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
			   return $row;
			}	
		}
	}

	function getdownintaketotal($fromdate,$todate,$uid)
	{
		switch(strlen($uid))
		{
			case 2: $sql = "SELECT 
							SUM((((transactions.agt_intake_big + transactions.agg_intake_big)* 1.6) + ((transactions.agt_intake_small + transactions.agg_intake_small)* 0.7))  * (transactions.agg_intake_tax / 100) ) AS tax_amount,

							SUM((((transactions.agt_intake_big + transactions.agg_intake_big)* 1.6) + ((transactions.agt_intake_small + transactions.agg_intake_small)* 0.7))  * (bet_records.agg_com / 100) ) AS intake_disc_amount,

							SUM(((transactions.agt_intake_big + transactions.agg_intake_big)* 1.6) + ((transactions.agt_intake_small + transactions.agg_intake_small)* 0.7)) AS intake_amount,

							SUM(transactions.agt_intake_big + transactions.agg_intake_big) AS intake_big,

							SUM(transactions.agt_intake_small + transactions.agg_intake_small) AS intake_small

							FROM `transactions` 
							left join bet_records on transactions.ref = bet_records.ref and transactions.drawdate = bet_records.drawdate
							WHERE 
							transactions.mas_id = ?
							AND
							transactions.drawdate >= ? 
							AND 
							transactions.drawdate <= ?
							";
					break;
			case 4: $sql = "SELECT 
							sum(((transactions.agt_intake_big * 1.6) + (transactions.agt_intake_small * 0.7))  * (transactions.agt_intake_tax / 100)) as tax_amount,
							sum(((transactions.agt_intake_big * 1.6) + (transactions.agt_intake_small * 0.7))  * (bet_records.agt_com / 100)) as intake_disc_amount,
							sum((transactions.agt_intake_big * 1.6) + (transactions.agt_intake_small * 0.7)) as intake_amount,
							sum(transactions.agt_intake_big) as intake_big,
							sum(transactions.agt_intake_small) as intake_small
							FROM `transactions` 
							left join bet_records on transactions.ref = bet_records.ref and transactions.drawdate = bet_records.drawdate
							where 
							transactions.agg_id = ?
							and 
							transactions.drawdate >= ? 
							and 
							transactions.drawdate <= ?
							";
					break;
			case 6: return false;
					break;
			case 8: return false;
					break;
		}
		$query = $this->db->query($sql, array($uid, $fromdate, $todate)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
			   return $row;
			}	
		}
	}

	function getmyintaketotal($fromdate,$todate,$uid)
	{
		switch(strlen($uid))
		{
			case 2: $sql = "SELECT 
							sum((((transactions.mas_intake_big + transactions.agg_intake_big + transactions.agt_intake_big) * 1.6) + ((transactions.mas_intake_small + transactions.agg_intake_small + transactions.agt_intake_small) * 0.7))  * (transactions.mas_intake_tax / 100) ) as all_tax_amount,

							sum((((transactions.mas_intake_big + transactions.agg_intake_big + transactions.agt_intake_big) * 1.6) + ((transactions.mas_intake_small + transactions.agg_intake_small + transactions.agt_intake_small) * 0.7))  * (bet_records.mas_com / 100) ) as all_intake_disc_amount,

							sum(((transactions.mas_intake_big * 1.6) + (transactions.mas_intake_small * 0.7))  * (transactions.mas_intake_tax / 100) ) as tax_amount,

							sum(((transactions.mas_intake_big * 1.6) + (transactions.mas_intake_small * 0.7))  * (bet_records.mas_com / 100) ) as intake_disc_amount,

							sum((transactions.mas_intake_big * 1.6) + (transactions.mas_intake_small * 0.7)) as intake_amount,

							sum(((transactions.mas_intake_big + transactions.agg_intake_big + transactions.agt_intake_big)* 1.6) + ((transactions.mas_intake_small + transactions.agg_intake_small + transactions.agt_intake_small) * 0.7)) as all_intake_amount,
							
							sum(transactions.mas_intake_big) as intake_big,

							sum(transactions.mas_intake_small) as intake_small

							FROM `transactions` 
							left join bet_records on transactions.ref = bet_records.ref and transactions.drawdate = bet_records.drawdate
							where 
							transactions.mas_id = ?
							and 
							transactions.drawdate >= ? 
							and 
							transactions.drawdate <= ?
							";
					break;
			case 4: $sql = "SELECT 
							sum(((transactions.agg_intake_big * 1.6) + (transactions.agg_intake_small * 0.7))  * (transactions.agg_intake_tax / 100) ) as tax_amount,
							sum(((transactions.agg_intake_big * 1.6) + (transactions.agg_intake_small * 0.7))  * (bet_records.agg_com / 100) ) as intake_disc_amount,
							sum((((transactions.agg_intake_big + transactions.agt_intake_big) * 1.6) + ((transactions.agg_intake_small + transactions.agt_intake_small)  * 0.7))  * (transactions.agg_intake_tax / 100) ) as all_tax_amount,
							sum((((transactions.agg_intake_big + transactions.agt_intake_big) * 1.6) + ((transactions.agg_intake_small + transactions.agt_intake_small)  * 0.7))  * (bet_records.agg_com / 100) ) as all_intake_disc_amount,
							sum((transactions.agg_intake_big * 1.6) + (transactions.agg_intake_small * 0.7)) as intake_amount,
							sum(((transactions.agg_intake_big + transactions.agt_intake_big) * 1.6) + ((transactions.agg_intake_small + transactions.agt_intake_small) * 0.7)) as all_intake_amount,
							sum(transactions.agg_intake_big) as intake_big,

							sum(transactions.agg_intake_small) as intake_small,

							sum(transactions.agg_intake_big + transactions.agt_intake_big) as all_intake_big,

							sum(transactions.agg_intake_small + transactions.agt_intake_small) as all_intake_small

							FROM `transactions` 
							left join bet_records on transactions.ref = bet_records.ref and transactions.drawdate = bet_records.drawdate
							where 
							transactions.agg_id = ?
							and 
							transactions.drawdate >= ? 
							and 
							transactions.drawdate <= ?
							";
					break;
			case 6: $sql = "SELECT 
							sum(((transactions.agt_intake_big * 1.6) + (transactions.agt_intake_small * 0.7))  * (transactions.agt_intake_tax / 100) ) as tax_amount,
							sum(((transactions.agt_intake_big * 1.6) + (transactions.agt_intake_small * 0.7))  * (bet_records.agt_com / 100) ) as intake_disc_amount,
							sum((transactions.agt_intake_big * 1.6) + (transactions.agt_intake_small * 0.7)) as intake_amount,
							sum(transactions.agt_intake_big) as intake_big,
							sum(transactions.agt_intake_small) as intake_small
							FROM `transactions` 
							left join bet_records on transactions.ref = bet_records.ref and transactions.drawdate = bet_records.drawdate
							where  
							transactions.agt_id = ?
							and 
							transactions.drawdate >= ? 
							and 
							transactions.drawdate <= ?
							";
					break;
			case 8: $account_type = "meb_id";
					break;
		}
		$query = $this->db->query($sql, array($uid, $fromdate, $todate)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
			   return $row;
			}	
		}
	}

	function get_page_ref($ref)
	{

		$sql = "SELECT pageref FROM bet_records WHERE ref = ? "; 
		$query = $this->db->query($sql, array($ref)); 

		foreach ($query->result_array() as $row)
		{
		   return $row['pageref'];
		}	
	}


	function getbetrecords_ref($ref,$drawdate)
	{

		$sql = "SELECT * FROM bet_records WHERE ref = ? and drawdate = ? "; 
		$query = $this->db->query($sql, array($ref, $drawdate)); 

		foreach ($query->result_array() as $row)
		{
		   return $row;
		}	
	}

	function getbetrecords_table($ref,$drawdate)
	{

		$sql = "SELECT ceil(count(*)/80) as count FROM page_details WHERE ref = ? and drawdate = ? "; 
		$query = $this->db->query($sql, array($ref, $drawdate)); 

		foreach ($query->result_array() as $row)
		{
		   return $row['count'];
		}	
	}

	function get_downline_with_trans($uid,$fromdate,$todate)
	{
		switch(strlen($uid))
		{
			case 2: $downline_type = "agg_id";
					$downline_table = "users_agg";
					$account_type = "mas_id";
					break;
			case 4: $downline_type = "agt_id";
					$downline_table = "users_agt";
					$account_type = "agg_id";
					break;
			case 6: $downline_type = "meb_id";
					$downline_table = "users_meb";
					$account_type = "agt_id";
					break;
		}

		$sql = "SELECT distinct(transactions.$downline_type) as $downline_type, $downline_table.name as name 
				FROM transactions
				left join $downline_table on transactions.$downline_type = $downline_table.$downline_type
				WHERE drawdate >= ? and drawdate <= ? and transactions.$account_type = ? group by $downline_type asc";

		$query = $this->db->query($sql, array($fromdate, $todate, $uid)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$results[$x] = $row;
			$x = $x + 1;
		}
		return $results;
	}

	function getdownline($uid)
	{
		switch(strlen($uid))
		{
			case 2: $downline_table = "users_agg";
					$downline_type = "agg_id";
					$account_type = "mas_id";
					break;
			case 4: $downline_table = "users_agt";
					$downline_type = "agt_id";
					$account_type = "agg_id";
					break;
			case 6: $downline_table = "users_meb";
					$downline_type = "meb_id";
					$account_type = "agt_id";
					break;
		}

		$sql = "SELECT * FROM $downline_table WHERE $account_type = ? order by $downline_type asc"; 
		$query = $this->db->query($sql, array($uid)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$results[$x] = $row;
			$x = $x + 1;
		}
		return $results;
	}

	function getdownlinetype($uid)
	{
		switch(strlen($uid))
		{
			case 2: $downline_type = "agg_id";
					break;
			case 4: $downline_type = "agt_id";
					break;
			case 6: $downline_type = "meb_id";
					break;
		}

		return $downline_type;
	}

	function changepass($uid, $password)
	{
		switch(strlen($uid))
		{
			case 2: $account_db = "users_mas";
					$account_type = "mas_id";
					break;
			case 4: $account_db = "users_agg";
					$account_type = "agg_id";
					break;
			case 6: $account_db = "users_agt";
					$account_type = "agt_id";
					break;
			case 8: $account_db = "users_meb";
					$account_type = "meb_id";
					break;
		}

		$sql = "update $account_db set password = ? WHERE $account_type = ?"; 

		$query = $this->db->query($sql, array($password,$uid));

	}

	function getdownlinedata($uid)
	{

		switch(strlen($uid))
		{
			case 2: $account_db = "users_agg";
					$account_type = "mas_id";
					$downline_type = "agg_id";
					break;
			case 4: $account_db = "users_agt";
					$account_type = "agg_id";
					$downline_type = "agt_id";
					break;
			case 6: $account_db = "users_meb";
					$account_type = "agt_id";
					$downline_type = "meb_id";
					break;
		}

		$this->db->select($downline_type);
		$this->db->select('name');
		$this->db->where($account_type, $uid); 
		$this->db->where("status", 'active');
		$this->db->not_like($downline_type, '--');
		$this->db->order_by($downline_type, "asc"); 				
		$query = $this->db->get($account_db);
		
		$data = array();
		$data['#'] = '-- Select Downline --';
		foreach ($query->result_array() as $row)
		{
		   $data[$row[$downline_type]] = $row[$downline_type]." ( ".$row['name']." )";
		}
		return $data;
	}

	function getuplinedata_type($uid,$downline_type)
	{

		switch(strlen($uid))
		{
			case 2: $account_type = "mas_id";
					break;
			case 4: $account_type = "agg_id";
					break;
			case 6: $account_type = "agt_id";
					break;
		}
		switch($downline_type)
		{
			case 'agg_id':	$account_db = "users_agg";
							break;
			case 'agt_id':	$account_db = "users_agt";
							break;
			case 'meb_id':	$account_db = "users_meb";
							break;
		}

		$this->db->select($downline_type);
		$this->db->select('name');
		$this->db->where($account_type, $uid); 
		$this->db->where("status", 'active');
		$this->db->not_like($downline_type, '--');
		$this->db->order_by($downline_type, "asc"); 		
		$query = $this->db->get($account_db);
		
		$data = array();
		$data['#'] = '-- Select Downline --';
		foreach ($query->result_array() as $row)
		{
		   $data[$row[$downline_type]] = $row[$downline_type]." ( ".$row['name']." )";
		}
		return $data;
	}

	function getmebdata($uid)
	{

		switch(strlen($uid))
		{
			case 4: $account_type = "agg_id";
					break;
			case 6: $account_type = "agt_id";
					break;
		}

		$this->db->select('meb_id, name');
		$this->db->where($account_type, $uid); 
		$this->db->where("status", 'active'); 
		$this->db->not_like('meb_id','--');
		$this->db->order_by('meb_id', "asc"); 		
		$query = $this->db->get('users_meb');
		
		$data = array();
		//$data['#'] = '--- Select Member ---';

		foreach ($query->result_array() as $row)
		{
		   $data[$row['meb_id']] = $row['meb_id']." ( ".$row['name']." )";
		}
		return $data;
	}

	function get_allusers($uid,$table,$ownuid,$usertype)
	{
		switch(strlen($uid))
		{
			case 2: $account_type = "mas_id";
					break;
			case 4: $account_type = "agg_id";
					break;
			case 6: $account_type = "agt_id";
					break;
		}
		switch(strlen($ownuid))
		{
			case 2: $account_type2 = "mas_id";
					break;
			case 4: $account_type2 = "agg_id";
					break;
			case 6: $account_type2 = "agt_id";
					break;
		}

		$sql = "SELECT * FROM $table WHERE $account_type = ? and $account_type2 = ? and $usertype not like '%--%'"; 
		$query = $this->db->query($sql, array($uid,$ownuid)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$results[$x] = $row;
			$x = $x + 1;
		}
		return $results;
	}

	function count_users($uid,$table)
	{
		switch(strlen($uid))
		{
			case 2: $account_type = "mas_id";
					break;
			case 4: $account_type = "agg_id";
					break;
			case 6: $account_type = "agt_id";
					break;
			case 8: $account_type = "meb_id";
					break;
		}

		switch($table)
		{
			case 'users_mas':	$account_type2 = "mas_id";
								break;
			case 'users_agg':	$account_type2 = "agg_id";
								break;
			case 'users_agt':	$account_type2 = "agt_id";
								break;
			case 'users_meb':	$account_type2 = "meb_id";
								break;
		}

		$sql = "SELECT count(*) as count FROM $table WHERE $account_type = ? and $account_type2 not like '%--%'"; 
		$query = $this->db->query($sql, array($uid)); 
		foreach ($query->result_array() as $row)
		{
			$results = $row['count'];
		}
		return $results;
	}

	function add_downline($data,$table)
	{
		$this->db->insert_batch($table, $data);
	}

	function add_aradownline($man_id,$mas_id,$agg_id)
	{
		if(strlen($agg_id) == 0)
		{
			return FALSE;
		}
		switch($agg_id)
		{
			case '--':	$meb_data = array(
							'man_id' => $man_id,
							'meb_id' => $mas_id.$agg_id.'----',
							'mas_id' => $mas_id,
							'agg_id' => $mas_id.$agg_id,
							'agt_id' => $mas_id.$agg_id.'--',
							'password' => '----',
							'name' => 'ARA Load Acc',
							'placeout_com' => '9',
							'status' => 'active',
							'credit' => '0',
							'balance' => '0', 
							'handphone1' => '0', 
							'handphone2' => '0', 
							'refresh' => 'y', 
						);
						$agt_data = array(
							'man_id' => $man_id,
							'mas_id' => $mas_id,
							'agg_id' => $mas_id.$agg_id,
							'agt_id' => $mas_id.$agg_id.'--',
							'password' => '----',
							'name' => 'ARA Load Acc',
							'placeout_com' => '9',
							'intake_tax' => '0',
							'intake_big' => '0',
							'intake_small' => '0',
							'share_co' => '0',
							'share_mas' => '0',
							'share_agg' => '0',
							'status' => 'active',
							'credit' => '0',
							'balance' => '0', 
						);
						$agg_data = array(
							'man_id' => $man_id,
							'mas_id' => $mas_id,
							'agg_id' => $mas_id.$agg_id,
							'password' => '----',
							'name' => 'ARA Load Acc',
							'placeout_com' => '9',
							'intake_tax' => '0',
							'intake_big' => '0',
							'intake_small' => '0',
							'share_co' => '0',
							'share_po' => '0',
							'share_mas' => '0',
							'status' => 'active',
						);
						
						$this->db->insert('users_agg', $agg_data); 
						$this->db->insert('users_agt', $agt_data); 
						$this->db->insert('users_meb', $meb_data); 

						return TRUE;
						break;

			default:	$meb_data = array(
							'man_id' => $man_id,
							'meb_id' => $mas_id.$agg_id.'----',
							'mas_id' => $mas_id,
							'agg_id' => $mas_id.$agg_id,
							'agt_id' => $mas_id.$agg_id.'--',
							'password' => '----',
							'name' => 'ARA Load Acc',
							'placeout_com' => '9',
							'status' => 'active',
							'credit' => '0',
							'balance' => '0', 
							'handphone1' => '0', 
							'handphone2' => '0', 
							'refresh' => 'y', 
						);
						$agt_data = array(
							'man_id' => $man_id,
							'mas_id' => $mas_id,
							'agg_id' => $mas_id.$agg_id,
							'agt_id' => $mas_id.$agg_id.'--',
							'password' => '----',
							'name' => 'ARA Load Acc',
							'placeout_com' => '9',
							'intake_tax' => '0',
							'intake_big' => '0',
							'intake_small' => '0',
							'share_co' => '0',
							'share_mas' => '0',
							'share_agg' => '0',
							'status' => 'active',
							'credit' => '0',
							'balance' => '0',
						);
						$this->db->insert('users_agt', $agt_data); 
						$this->db->insert('users_meb', $meb_data); 
						return TRUE;
						break;
		}
	}

	function update_downline($data,$table,$ownuid)
	{
		switch(strlen($ownuid))
		{
			case 2: $account_type = "mas_id";
					break;
			case 4: $account_type = "agg_id";
					break;
			case 6: $account_type = "agt_id";
					break;
			case 8: $account_type = "meb_id";
					break;
		}

		$this->db->where($account_type, $ownuid);
		$this->db->update($table, $data); 
	}


	function update_deduct_balance($amt, $uid)
	{
		switch(strlen($uid))
		{
			case 2: $account_db = "users_mas";
					$account_type = "mas_id";
					break;
			case 4: $account_db = "users_agg";
					$account_type = "agg_id";
					break;
			case 6: $account_db = "users_agt";
					$account_type = "agt_id";
					break;
			case 8: $account_db = "users_meb";
					$account_type = "meb_id";
					break;
		}

		$this->db->set('balance', 'balance - '.$amt, FALSE);
		$this->db->where($account_type, $uid);
		$this->db->update($account_db); 
	}

	function update_add_balance($amt, $uid)
	{
		switch(strlen($uid))
		{
			case 2: $account_db = "users_mas";
					$account_type = "mas_id";
					break;
			case 4: $account_db = "users_agg";
					$account_type = "agg_id";
					break;
			case 6: $account_db = "users_agt";
					$account_type = "agt_id";
					break;
			case 8: $account_db = "users_meb";
					$account_type = "meb_id";
					break;
		}

		$this->db->set('balance', 'balance + '.$amt, FALSE);
		$this->db->where($account_type, $uid);
		$this->db->update($account_db); 
	}

	function getdownline_strike($fromdate,$todate,$uid)
	{
		switch(strlen($uid))
		{
			case 2: $sql = "SELECT agg_id FROM `strike_users` where mas_id = ? and drawdate >= ? and drawdate <= ? group by agg_id"; 
					break;
			case 4: $sql = "SELECT agt_id FROM `strike_users` where agg_id = ? and drawdate >= ? and drawdate <= ? group by agt_id"; 
					break;
			case 6: $sql = "SELECT meb_id FROM `strike_users` where agt_id = ? and drawdate >= ? and drawdate <= ? group by meb_id"; 
					break;
		}

		$query = $this->db->query($sql, array($uid,$fromdate,$todate)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$results[$x] = $row;
			$x = $x + 1;
		}
		return $results;
	}

	function get_strike_report($fromdate,$todate,$uid)
	{
		switch(strlen($uid))
		{
			case 2: $sql = "SELECT *
							FROM `strike_users` 
							where mas_id = ?
							and 
							drawdate >= ? 
							and 
							drawdate <= ?
							order by meb_id,drawdate
							";
					break;
			case 4: $sql = "SELECT *
							FROM `strike_users` 
							where agg_id = ?
							and 
							drawdate >= ? 
							and 
							drawdate <= ?
							order by meb_id,drawdate
							";
					break;
			case 6: $sql = "SELECT *
							FROM `strike_users` 
							where agt_id = ?
							and 
							drawdate >= ? 
							and 
							drawdate <= ?
							order by meb_id,drawdate
							";
					break;
			case 8: $sql = "SELECT *
							FROM `strike_users` 
							where meb_id = ?
							and 
							drawdate >= ? 
							and 
							drawdate <= ?
							order by meb_id,drawdate
							";
					break;

		}
		$query = $this->db->query($sql, array($uid, $fromdate, $todate)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$result[$x] = $row;
			$x = $x + 1;
		}	
		return $result;
	}
	
	function update_member_balance($amt, $uid)
	{
		$this->db->set('balance', 'balance - '.$amt, FALSE);
		$this->db->where('meb_id', $uid);
		$this->db->update('users_meb'); 
	}

	function get_intake_own($uid,$fromdate,$todate)
	{
		switch(strlen($uid))
		{
			case 2: $account_type = "mas_id";
					$intake_big_type = "mas_intake_big";
					$intake_small_type = "mas_intake_small";
					break;
			case 4: $account_type = "agg_id";
					$intake_big_type = "agg_intake_big";
					$intake_small_type = "agg_intake_small";
					break;
			case 6: $account_type = "agt_id";
					$intake_big_type = "agt_intake_big";
					$intake_small_type = "agt_intake_small";
					break;
			case 8: $account_type = "meb_id";
					break;
		}

		$sql = "SELECT 
				drawdate,
				number,
				sum(amt_big) as amt_big,
				sum(amt_small) as amt_small,
				sum($intake_big_type) as intake_big,
				sum($intake_small_type) as intake_small
				FROM `transactions` 
				where $account_type = ? and drawdate >= ? and drawdate <= ?
				and ($intake_big_type != 0 or $intake_small_type !=0)
				group by drawdate,number
				order by drawdate,number asc";

		$query = $this->db->query($sql, array($uid, $fromdate, $todate)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$results[$x] = $row;
				$x = $x + 1;
			}
			return $results;
		}
	}
	function close_all_downline($uid,$table)
	{
		switch(strlen($uid))
		{
			case 2: $account_type = "mas_id";
					break;
			case 4: $account_type = "agg_id";
					break;
			case 6: $account_type = "agt_id";
					break;
			case 8: $account_type = "meb_id";
					break;
		}

		$this->db->set('status', 'closed');
		$this->db->where($account_type, $uid);
		$this->db->update($table); 
	}	
}
?>