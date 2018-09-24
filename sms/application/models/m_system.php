
<?php
Class m_System extends CI_Model
{
	function settings_server()
	{
		$this->db->select('closetime,sitename,bigprice,smallprice,placeout_comm,exp');
		$query = $this->db->get('settings');

		foreach ($query->result_array() as $row)
		{
		   return $row;
		}	

	}
	
	function getdraw($drawdate)
	{
		$sql = "SELECT drawdate FROM drawdate WHERE drawdate >= ? limit 3"; 
		$query = $this->db->query($sql, array($drawdate)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$nextday[$x] = $row['drawdate'];
			$x = $x + 1;
		}
		return $nextday;
	}

	function getpastdraw($limit)
	{

		$this->db->distinct();
		$this->db->select('drawdate');
		$this->db->order_by("drawdate", "desc"); 
		$this->db->limit($limit);
		$query = $this->db->get('results');
		
		$drawdate = array();

		foreach ($query->result_array() as $row)
		{
			$td = $row['drawdate'];
			$arr = explode ("-", $td);
			$stamp = mktime(0,0,0,$arr[1],$arr[2],$arr[0]);
			$t = date('D',$stamp);
			if (strcmp($t, 'Wed') == 0 ){$day = 'Wed';}
			if (strcmp($t, 'Sat') == 0 ){$day = 'Sat';}
			if (strcmp($t, 'Sun') == 0 ){$day = 'Sun';}

		   $drawdate[$row['drawdate']] = $row['drawdate']." (".$day.")";
		}
		return $drawdate;
	}

	function gettransdraw($limit)
	{

		$this->db->distinct();
		$this->db->select('drawdate');
		$this->db->order_by("drawdate", "desc"); 
		$this->db->limit($limit);
		$query = $this->db->get('transactions');
		
		$drawdate = array();

		foreach ($query->result_array() as $row)
		{
			$td = $row['drawdate'];
			$arr = explode ("-", $td);
			$stamp = mktime(0,0,0,$arr[1],$arr[2],$arr[0]);
			$t = date('D',$stamp);
			if (strcmp($t, 'Wed') == 0 ){$day = 'Wed';}
			if (strcmp($t, 'Sat') == 0 ){$day = 'Sat';}
			if (strcmp($t, 'Sun') == 0 ){$day = 'Sun';}

		   $drawdate[$row['drawdate']] = $row['drawdate']." (".$day.")";
		}
		return $drawdate;
	}

	function loadara($file,$fileref)
	{
		$sql = "LOAD DATA INFILE ? INTO TABLE ara_data (data) SET fileref = ?"; 
		$query = $this->db->query($sql, array($file,$fileref)); 
	}

	function ara_records($data)
	{
		$this->db->insert('ara_upload', $data); 
	}

	function randomref() 
	{
		$code=md5(uniqid(microtime()) . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
		$number = substr($code,0,20);
		return $number;
	}

	function getcombo($number)
	{

		$this->db->select('drawnum,combocount,comblist');
		$this->db->like('comblist', $number); 
		$query = $this->db->get('combo');

		foreach ($query->result_array() as $row)
		{
		   return $row;
		}	
	}

	function getwild($number)
	{

		$sql = "SELECT number FROM wildcard WHERE number REGEXP ?"; 
		$query = $this->db->query($sql, array($number)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$result[$x] = $row['number'];
			$x = $x + 1;
		}	
		return $result;
	}

	function getara($fileref)
	{

		$sql = "SELECT data FROM ara_data WHERE fileref = ?"; 
		$query = $this->db->query($sql, array($fileref)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$result[$x] = $row;
			$x = $x + 1;
		}	
		return $result;
	}

	function getara_page($fileref)
	{

		$sql = "SELECT substring(`data`,21,4) as pageref FROM ara_data WHERE fileref = ? limit 1"; 
		$query = $this->db->query($sql, array($fileref)); 
		foreach ($query->result_array() as $row)
		{
			$result = $row['pageref'];
		}	
		return $result;
	}

	function runintake($uid, $number, $drawdate)
	{
		switch(strlen($uid))
		{
			case 2:	$account_type = "mas_id";
					$inbig = "mas_intake_big";
					$insmall = "mas_intake_small";
					break;
			case 4: $account_type = "agg_id";
					$inbig = "agg_intake_big";
					$insmall = "agg_intake_small";
					break;
			case 6: $account_type = "agt_id";
					$inbig = "agt_intake_big";
					$insmall = "agt_intake_small";
					break;
			default: return FALSE;
		}

		$this->db->select_sum($inbig,'prebig');
		$this->db->select_sum($insmall,'presmall');
		$this->db->where('drawdate', $drawdate); 
		$this->db->where('number', $number); 
		$this->db->where($account_type, $uid); 
		$query = $this->db->get('transactions');
		
		foreach ($query->result_array() as $row)
		{
		   return $row;
		}	
	}


	function insertpage($data)
	{
		$this->db->insert_batch('page_details', $data);
	}
	function insert_manual_sms($data)
	{
		$this->db->insert_batch('sms_manual', $data);
	}
	function insert_sms_log($data)
	{
		$this->db->insert_batch('sms_log', $data);
	}
	function inserttrans($data)
	{
		$this->db->insert_batch('transactions', $data);
	}
	function inserttransfix($data)
	{
		$this->db->insert_batch('transactions_fix', $data);
	}
	function insertadminintake($data)
	{
		$this->db->insert_batch('admin_intake_pool', $data);
	}
	function insertbetrecords($data)
	{
		$this->db->insert_batch('bet_records', $data);
	}

	function dividefunc($eatbig, $eatsmall, $prebig, $presmall, $big, $small)
	{
		$divideamt[0] = 0; //  eat big
		$divideamt[1] = 0; //  out big
		$divideamt[2] = 0; //  eat small
		$divideamt[3] = 0; //  out small
		
		if ($presmall < 0)
		{
			$presmall = 0;
		}
		// --------------- big eat & out -----------------------
		if ($big > ($eatbig - $prebig)) // eat remiander big and out the rest
		{
			$eatbamt = $eatbig - $prebig;
			$divideamt[0] = round($eatbamt,4); // eat big amt
			$big = $big - $eatbamt;
			$divideamt[1] = round($big,4); // out big amt
		}
		else //eat all into system
		{
			$eatbamt = $big;
			$divideamt[0] = round($eatbamt,4); // eat big amt
			$big = 0;
		}

		// --------------- small eat & out ---------------------

		
		if ($eatsmall > 0)
		{
			if((($eatbamt + $prebig) * 4) >= ($eatsmall * 3))
			{
				$PreOutSml = Ceil((($prebig * 4) - ($eatsmall * 3)) / 3);
				if ($PreOutSml < 0) {$PreOutSml = 0;}
				$NewOutsml = Ceil(((($eatbamt+$prebig) * 4) - ($eatsmall * 3)) / 3) - $PreOutSml; // amount to top up for max big
				$small = $small + $NewOutsml + $presmall; // total amt to out as small
				$divideamt[3] = round($small,4); // out small amt

				$outsamt = $NewOutsml;
				//echo "System top-up for max big = ".$outsamt." small<br>";
				$tempresult = 0 - ($presmall + $NewOutsml); // eat small amt
				$divideamt[2] = round($tempresult,4);
			}

			else 
			{
				$eatsamt = floor((($eatsmall * 3) - (($eatbamt + $prebig)*4)) / 3); // max small amt to eat
				if (($small + $presmall) >= $eatsamt)
				{
					$small = ($small + $presmall) - $eatsamt;
					$divideamt[3] = round($small,4); // out small amt
					$eatsamt = $eatsamt - $presmall;
					$divideamt[2] = round($eatsamt,4); // eat small amt
				}
				else
				{
					$eatsamt = $small;
					$divideamt[2] = round($eatsamt,4); // eat small amt
					$small = 0;
				}
			}
		}
		else
		{
			$eatsamt = 0 - $presmall;
			$divideamt[2] = round($eatsamt,4); // eat small amt
			$small = $small - $eatsamt;
			$divideamt[3] = round($small,4); // out small amt
		}
		
		return $divideamt;
	}

	function get_report($todate,$fromdate,$uid)
	{
		switch(strlen($uid))
		{
			case 2: $sql = "SELECT drawdate,
							man_id,
							mas_id,
							placeout_comm as placeout_comm,
							intake_tax as intake_tax,
							sum(total_po_big) as total_po_big,
							sum(total_po_small) as total_po_small,
							sum(total_intake_big) as total_intake_big,
							sum(total_intake_small) as total_intake_small,
							sum(ticket_perc) as ticket_perc,
							sum(total_po_ticket) as total_po_ticket,
							sum(downline_total_po_ticket) as downline_total_po_ticket,
							sum(total_meb_strike) as total_meb_strike,
							sum(total_own_strike) as total_own_strike,
							sum(total_downline_strike) as total_downline_strike,
							sum(total_intake_ticket) as total_intake_ticket,
							sum(total_own_intake_ticket) as total_own_intake_ticket,
							sum(total_downline_intake_ticket) as total_downline_intake_ticket,
							sum(total_intake_tax) as total_intake_tax,
							sum(total_own_intake_tax) as total_own_intake_tax,
							sum(total_downline_intake_tax) as total_downline_intake_tax,
							share_co_perc as share_co_perc,
							sum(share_co_amt) as share_co_amt,
							sum(share_co_amt100) as share_co_amt100,
							share_po_perc as share_po_perc,
							sum(share_po_amt) as share_po_amt,
							sum(share_po_amt100) as share_po_amt100,
							sum(sms_charges) as sms_charges,
							sum(expenses) as expenses		
							FROM pl_mas WHERE drawdate >= ? and drawdate <= ? and mas_id = ?";
					break;
			case 4: $sql = "SELECT
							drawdate,
							mas_id,
							agg_id,
							placeout_comm as placeout_comm,
							intake_tax as intake_tax,
							sum(total_po_big) as total_po_big,
							sum(total_po_small) as total_po_small,
							sum(total_intake_big) as total_intake_big,
							sum(total_intake_small) as total_intake_small,
							sum(ticket_perc) as ticket_perc,
							sum(total_po_ticket) as total_po_ticket,
							sum(downline_total_po_ticket) as downline_total_po_ticket,
							sum(total_meb_strike) as total_meb_strike,
							sum(total_own_strike) as total_own_strike,
							sum(total_downline_strike) as total_downline_strike,
							sum(total_intake_ticket) as total_intake_ticket,
							sum(total_own_intake_ticket) as total_own_intake_ticket,
							sum(total_downline_intake_ticket) as total_downline_intake_ticket,
							sum(total_intake_tax) as total_intake_tax,
							sum(total_own_intake_tax) as total_own_intake_tax,
							sum(total_downline_intake_tax) as total_downline_intake_tax,
							share_co_perc as share_co_perc,
							sum(share_co_amt) as share_co_amt,
							sum(share_co_amt100) as share_co_amt100,
							share_po_perc as share_po_perc,
							sum(share_po_amt) as share_po_amt,
							sum(share_po_amt100) as share_po_amt100,
							share_mas_perc as share_mas_perc,
							sum(share_mas_amt) as share_mas_amt,
							sum(share_mas_amt100) as share_mas_amt100
							FROM pl_agg WHERE drawdate >= ? and drawdate <= ? and agg_id = ?";
					break;
			case 6: $sql = "SELECT
							drawdate,
							mas_id,
							agg_id,
							agt_id,
							placeout_comm as placeout_comm,
							intake_tax as intake_tax,
							sum(total_po_big) as total_po_big,
							sum(total_po_small) as total_po_small,
							sum(total_intake_big) as total_intake_big,
							sum(total_intake_small) as total_intake_small,
							sum(ticket_perc) as ticket_perc,
							sum(total_po_ticket) as total_po_ticket,
							sum(downline_total_po_ticket) as downline_total_po_ticket,
							sum(total_meb_strike) as total_meb_strike,
							sum(total_own_strike) as total_own_strike,
							sum(total_own_intake_ticket) as total_own_intake_ticket,
							sum(total_own_intake_tax) as total_own_intake_tax,
							share_co_perc as share_co_perc,
							sum(share_co_amt) as share_co_amt,
							sum(share_co_amt100) as share_co_amt100,
							share_agg_perc as share_agg_perc,
							sum(share_agg_amt) as share_agg_amt,
							sum(share_agg_amt100) as share_agg_amt100,
							share_mas_perc as share_mas_perc,
							sum(share_mas_amt) as share_mas_amt,
							sum(share_mas_amt100) as share_mas_amt100
							FROM pl_agt WHERE drawdate >= ? and drawdate <= ? and agt_id = ?";
					break;
			case 8: 
					break;
		}

		$query = $this->db->query($sql, array($fromdate,$todate,$uid)); 
		foreach ($query->result_array() as $row)
		{
			return $row;
		}
	}

	function get_intake_details($date,$type)
	{
		switch($type)
		{
			case 'admin':	$sql = "SELECT *		
							FROM admin_intake_detail WHERE drawdate = ?";
							break;
			case 'bookie':	$sql = "SELECT *		
							FROM bookie_intake_detail WHERE drawdate = ?";
							break;
			case 'master':	$sql = "SELECT *		
							FROM master_po_detail WHERE drawdate = ?";
							break;
		}

		$query = $this->db->query($sql, array($date)); 
		foreach ($query->result_array() as $row)
		{
			return $row;
		}
	}


	function get_share_downline($todate,$fromdate,$uid)
	{
		switch(strlen($uid))
		{
			case 2: $sql = "SELECT 
					sum(share_co_amt) as share_co,
					sum(share_po_amt) as share_po,
					sum(share_mas_amt) as share_mas,
					sum(total_own_intake_tax) as tax
					FROM pl_agg WHERE drawdate >= ? and drawdate <= ? and mas_id = ?"; 
					break;
			case 4: $sql = "SELECT 
					sum(share_co_amt) as share_co,
					sum(share_agg_amt) as share_agg,
					sum(share_mas_amt) as share_mas,
					sum(total_own_intake_tax) as tax
					FROM pl_agt WHERE drawdate >= ? and drawdate <= ? and agg_id = ?"; 
					break;
		}

		$query = $this->db->query($sql, array($fromdate,$todate,$uid)); 
		foreach ($query->result_array() as $row)
		{
			return $row;
		}
	}

	function get_downline_total($todate,$fromdate,$uid)
	{
		switch(strlen($uid))
		{
			case 2: $sql = "SELECT 
					sum(total_po_ticket - total_intake_ticket) as total_ticket,
					sum(total_meb_strike - total_own_strike - total_downline_strike) as total_strike,
					sum(ticket_perc) as total_perc,
					sum(share_mas_amt + share_po_amt + share_co_amt) as total_share,
					sum(total_intake_tax) as total_tax
					FROM pl_agg WHERE drawdate >= ? and drawdate <= ? and mas_id = ?"; 
					break;
			case 4: $sql = "SELECT 
					sum(total_po_ticket - total_own_intake_ticket) as total_ticket,
					sum(total_meb_strike - total_own_strike) as total_strike,
					sum(ticket_perc) as total_perc,
					sum(share_mas_amt + share_agg_amt + share_co_amt) as total_share,
					sum(total_own_intake_tax) as total_tax
					FROM pl_agt WHERE drawdate >= ? and drawdate <= ? and agg_id = ?"; 
					break;
			case 6: $sql = "SELECT 
					sum(total_po_big) as total_big,
					sum(total_po_small) as total_small,
					sum(total_ticket) as total_ticket,
					sum(total_strike) as total_strike
					FROM pl_meb WHERE drawdate >= ? and drawdate <= ? and agt_id = ?";
					break;
			case 8: break;
		}

		$query = $this->db->query($sql, array($fromdate,$todate,$uid)); 
		foreach ($query->result_array() as $row)
		{
			return $row;
		}
	}

	function get_downline_report($todate,$fromdate,$uid)
	{
		
		switch(strlen($uid))
		{
			case 2: $sql = "SELECT users_agg.name as name,
							pl_agg.drawdate as drawdate,
							pl_agg.mas_id as mas_id,
							pl_agg.agg_id as agg_id,
							pl_agg.placeout_comm as placeout_comm,
							pl_agg.intake_tax as intake_tax,
							sum(pl_agg.total_po_big) as total_po_big,
							sum(pl_agg.total_po_small) as total_po_small,
							sum(pl_agg.total_intake_big) as total_intake_big,
							sum(pl_agg.total_intake_small) as total_intake_small,
							sum(pl_agg.ticket_perc) as ticket_perc,
							sum(pl_agg.total_po_ticket) as total_po_ticket,
							sum(pl_agg.downline_total_po_ticket) as downline_total_po_ticket,
							sum(pl_agg.total_meb_strike) as total_meb_strike,
							sum(pl_agg.total_own_strike) as total_own_strike,
							sum(pl_agg.total_downline_strike) as total_downline_strike,
							sum(pl_agg.total_intake_ticket) as total_intake_ticket,
							sum(pl_agg.total_own_intake_ticket) as total_own_intake_ticket,
							sum(pl_agg.total_downline_intake_ticket) as total_downline_intake_ticket,
							sum(pl_agg.total_intake_tax) as total_intake_tax,
							sum(pl_agg.total_own_intake_tax) as total_own_intake_tax,
							sum(pl_agg.total_downline_intake_tax) as total_downline_intake_tax,
							pl_agg.share_co_perc as share_co_perc,
							sum(pl_agg.share_co_amt) as share_co_amt,
							sum(pl_agg.share_co_amt100) as share_co_amt100,
							pl_agg.share_po_perc as share_po_perc,
							sum(pl_agg.share_po_amt) as share_po_amt,
							sum(pl_agg.share_po_amt100) as share_po_amt100,
							pl_agg.share_mas_perc as share_mas_perc,
							sum(pl_agg.share_mas_amt) as share_mas_amt,
							sum(pl_agg.share_mas_amt100) as share_mas_amt100			
							FROM pl_agg
							left join users_agg on pl_agg.agg_id = users_agg.agg_id
							WHERE drawdate >= ? and drawdate <= ? and pl_agg.mas_id = ? group by pl_agg.agg_id order by pl_agg.agg_id asc"; 
					break;
			case 4: $sql = "SELECT users_agt.name as name,
							pl_agt.drawdate,
							pl_agt.mas_id,
							pl_agt.agg_id,
							pl_agt.agt_id,
							pl_agt.placeout_comm as placeout_comm,
							pl_agt.intake_tax as intake_tax,
							sum(pl_agt.total_po_big) as total_po_big,
							sum(pl_agt.total_po_small) as total_po_small,
							sum(pl_agt.total_intake_big) as total_intake_big,
							sum(pl_agt.total_intake_small) as total_intake_small,
							sum(pl_agt.ticket_perc) as ticket_perc,
							sum(pl_agt.total_po_ticket) as total_po_ticket,
							sum(pl_agt.downline_total_po_ticket) as downline_total_po_ticket,
							sum(pl_agt.total_meb_strike) as total_meb_strike,
							sum(pl_agt.total_own_strike) as total_own_strike,
							sum(pl_agt.total_own_intake_ticket) as total_own_intake_ticket,
							sum(pl_agt.total_own_intake_tax) as total_own_intake_tax,
							pl_agt.share_co_perc as share_co_perc,
							sum(pl_agt.share_co_amt) as share_co_amt,
							sum(pl_agt.share_co_amt100) as share_co_amt100,
							pl_agt.share_agg_perc as share_agg_perc,
							sum(pl_agt.share_agg_amt) as share_agg_amt,
							sum(pl_agt.share_agg_amt100) as share_agg_amt100,
							pl_agt.share_mas_perc as share_mas_perc,
							sum(pl_agt.share_mas_amt) as share_mas_amt,
							sum(pl_agt.share_mas_amt100) as share_mas_amt100
							FROM pl_agt
							left join users_agt on pl_agt.agt_id = users_agt.agt_id
							WHERE drawdate >= ? and drawdate <= ? and pl_agt.agg_id = ? group by pl_agt.agt_id order by pl_agt.agt_id asc"; 
					break;
			case 6: $sql = "SELECT 
							users_meb.name as name,
							pl_meb.drawdate as drawdate,
							pl_meb.mas_id as mas_id,
							pl_meb.agg_id as agg_id,
							pl_meb.agt_id as agt_id,
							pl_meb.meb_id as meb_id,
							sum(pl_meb.placeout_comm) as placeout_comm,
							sum(pl_meb.total_po_big) as total_po_big,
							sum(pl_meb.total_po_small) as total_po_small,
							sum(pl_meb.total_ticket) as total_ticket,
							sum(pl_meb.total_strike) as total_strike
							FROM pl_meb 
							left join users_meb on pl_meb.meb_id = users_meb.meb_id
							WHERE drawdate >= ? and drawdate <= ? and pl_meb.agt_id = ? group by pl_meb.meb_id order by pl_meb.meb_id asc"; 
					break;
			case 8: 
					break;
		}
		$query = $this->db->query($sql, array($fromdate,$todate,$uid)); 
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

	function get_coy_report($fromdate,$todate)
	{
		$sql = "SELECT
				mas_id,
				man_id,
				sum(total_ticket) as total_ticket,
				sum(total_strike) as total_strike,
				sum(ticket_perc) as ticket_perc,
				sum(intake_tax) as intake_tax,
				sum(sms_charges) as sms_charges,
				sum(share_co_perc) as share_co_perc,
				sum(share_co_amt) as share_co_amt,
				sum(share_co_amt100) as share_co_amt100,
				sum(share_po_perc) as share_po_perc,
				sum(share_po_amt) as share_po_amt,
				sum(share_po_amt100) as share_po_amt100
				FROM pl_coy WHERE drawdate >= ? and drawdate <= ? and total_ticket > 0 group by mas_id order by mas_id asc";
		
		$query = $this->db->query($sql, array($fromdate,$todate)); 
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

	function get_coy_sum_report($fromdate,$todate)
	{
		$sql = "SELECT 
				sum(total_ticket) as total_ticket,
				sum(total_strike) as total_strike,
				sum(ticket_perc) as total_perc,
				sum(share_co_amt100) as total_co_amt,
				sum(share_po_amt100) as total_po_amt
				FROM pl_coy WHERE drawdate >= ? and drawdate <= ? and total_ticket > 0"; 

		$query = $this->db->query($sql, array($fromdate,$todate)); 
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row;
			}
		}
	}

	function get_bok_report($fromdate,$todate)
	{
		$sql = "SELECT 
				pl_bok.bok_id,
				users_bok.name,
				sum(total_ticket) as total_ticket,
				sum(total_strike) as total_strike,
				sum(po_return) as po_return
				FROM pl_bok
				left join users_bok on users_bok.bok_id = pl_bok.bok_id 
				WHERE drawdate >= ? and drawdate <= ? and total_ticket > 0 group by pl_bok.bok_id order by users_bok.bok_id asc"; 
		$query = $this->db->query($sql, array($fromdate,$todate)); 
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

	function get_bok_sum_report($fromdate,$todate)
	{
		$sql = "SELECT 
				sum(total_ticket) as total_ticket,
				sum(total_strike) as total_strike,
				sum(po_return) as total_po_return
				FROM pl_bok WHERE drawdate >= ? and drawdate <= ? and total_ticket > 0"; 

		$query = $this->db->query($sql, array($fromdate,$todate)); 
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row;
			}
		}
	}

	function get_draw_count($fromdate,$todate)
	{
		$sql = "SELECT 
				count(distinct(drawdate)) as count
				FROM drawdate WHERE drawdate >= ? and drawdate <= ?"; 

		$query = $this->db->query($sql, array($fromdate,$todate)); 
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				return $row['count'];
			}
		}
	}	

	function get_fix_transactions()
	{

		$sql = "SELECT 
				DISTINCT(transactions_fix.meb_id) AS meb_id, 
				transactions_fix.pageref 
				FROM `transactions_fix` 
				left join users_meb on users_meb.meb_id = transactions_fix.meb_id
				where users_meb.status = 'active'
				ORDER BY transactions_fix.meb_id ASC"; 
		
		$query = $this->db->query($sql); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$result[$x] = $row;
			$x = $x + 1;
		}	
		return $result;
	}

	function get_fix_number($meb_id, $pageref)
	{

		$sql = "SELECT number,cmd,amt_big,amt_small,numinpage FROM `transactions_fix` where meb_id = ? and pageref = ? order by numinpage asc"; 
		$query = $this->db->query($sql, array($meb_id, $pageref)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$result[$x] = $row;
			$x = $x + 1;
		}	
		return $result;
	}

	function get_results($drawdate,$prizetype)
	{

		$sql = "SELECT number FROM results WHERE drawdate = ? and prizetype = ?"; 
		$query = $this->db->query($sql, array($drawdate, $prizetype)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$result[$x] = $row;
			$x = $x + 1;
		}	
		return $result;
	}

	function get_results_details_coy($drawdate, $number, $prizetype)
	{

		$sql = "SELECT 
				results.prizetype as prizetype,
				results.number as number,

				IFNULL(sum(strike_company.amt_big), 0) as company_big,
				IFNULL(sum(strike_company.amt_small), 0) as company_small,
				IFNULL(sum(strike_company.coy_strike), 0) as company_strike

				FROM results
				left join strike_company on results.drawdate = strike_company.drawdate and results.number = strike_company.number

				where results.drawdate = ? and results.number = ? and results.prizetype = ?";
				
		$query = $this->db->query($sql, array($drawdate, $number ,$prizetype)); 
		foreach ($query->result_array() as $row)
		{
			$result = $row;
		}	
		return $result;
	}
	
	function get_results_details_bok($drawdate, $number, $prizetype)
	{

		$sql = "SELECT 
				results.prizetype as prizetype,
				results.number as number,

				IFNULL(sum(strike_bookie.amt_big), 0) as bookie_big,
				IFNULL(sum(strike_bookie.amt_small), 0) as bookie_small,
				IFNULL(sum(strike_bookie.bok_strike), 0) as bookie_strike

				FROM results
				left join strike_bookie on results.drawdate = strike_bookie.drawdate and results.number = strike_bookie.number

				where results.drawdate = ? and results.number = ? and results.prizetype = ?";
				
		$query = $this->db->query($sql, array($drawdate, $number ,$prizetype)); 
		foreach ($query->result_array() as $row)
		{
			$result = $row;
		}	
		return $result;
	}

	function get_results_details_meb($drawdate, $number, $prizetype)
	{

		$sql = "SELECT 
				results.prizetype as prizetype,
				results.number as number,

				IFNULL(sum(strike_users.amt_big), 0) as member_big,
				IFNULL(sum(strike_users.amt_small), 0) as member_small,
				IFNULL(sum(strike_users.meb_strike), 0) as member_strike,

				IFNULL(sum(strike_users.agt_intake_big + strike_users.agg_intake_big + strike_users.mas_intake_big), 0) as other_big,
				IFNULL(sum(strike_users.agt_intake_small + strike_users.agg_intake_small + strike_users.mas_intake_small), 0) as other_small,
				IFNULL(sum(strike_users.agt_strike + strike_users.agg_strike + strike_users.mas_strike), 0) as other_strike

				FROM results
				left join strike_users on results.drawdate = strike_users.drawdate and results.number = strike_users.number
				where results.drawdate = ? and results.number = ? and results.prizetype = ?";
				
		$query = $this->db->query($sql, array($drawdate, $number ,$prizetype)); 
		foreach ($query->result_array() as $row)
		{
			$result = $row;
		}	
		return $result;
	}

	function get_member_from_mobile($mobile)
	{
		$sql = "SELECT meb_id 
				FROM users_meb
				WHERE (handphone1 like ? or handphone2 like ?)"; 

		$query = $this->db->query($sql, array($mobile,$mobile)); 
		foreach ($query->result_array() as $row)
		{
			return $row['meb_id'];
		}
	}

	function check_sms_time($timestamp,$msg,$mobile)
	{
		$sql = "SELECT count(*) as count 
				FROM sms_log
				WHERE msg = ? and mobile = ? and sms_expire >= ?"; 

		$query = $this->db->query($sql, array($msg, $mobile, $timestamp)); 
		foreach ($query->result_array() as $row)
		{
			return $row['count'];
		}
	}

	function send_sms ($host, $port, $username, $password, $phoneNoRecip, $msgText) { 
	 
		$fp = fsockopen($host, $port, $errno, $errstr);
		if (!$fp) {
			echo "errno: $errno \n";
			echo "errstr: $errstr\n";
			return $result;
		}

		//fwrite($fp, "GET /isms_send.php?un=angel1888&pwd=angel1888&dstno=65" . rawurlencode($phoneNoRecip) . "&sendid=6018991888&type=1&msg=" . rawurlencode($msgText) . " HTTP/1.0\n");
		
		fwrite($fp, "GET /api.aspx?apiusername=APIJGTB1BMJ4C&apipassword=APIJGTB1BMJ4CJGTB1&mobileno=65" . rawurlencode($phoneNoRecip) . "&senderid=+6018991888&languagetype=1&message=" . rawurlencode($msgText) . " HTTP/1.0\n");

		if ($username != "") {
		   $auth = $username . ":" . $password;
			//echo "auth: $auth\n";
		   $auth = base64_encode($auth);
			//echo "auth: $auth\n";
		   fwrite($fp, "Authorization: Basic " . $auth . "\n");
		}
		fwrite($fp, "\n");
	  
		$res = "";
	 
		while(!feof($fp)) {
			$res .= fread($fp,1);
		}
		fclose($fp);
		
	 
		return $res;
	}

}
?>