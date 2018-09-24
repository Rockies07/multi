        <!-- Sidebar Wrapper -->
        <div id="mws-sidebar">
        
            <!-- Hidden Nav Collapse Button -->
            <div id="mws-nav-collapse">
                <span></span>
                <span></span>
                <span></span>
            </div>
            
        	<!-- Searchbox -->
            
            <!-- Main Navigation -->
            <div id="mws-navigation1">
			
                <ul>
					<li><a style="color:#fff; line-height: 12px; font-size:12px;" id='txt'></a></li>
					<li><a style="color:#fff; line-height: 12px; font-size:12px;">Close Time: <?PHP echo $closetime;?></a></li>
					<div style="color:#000; text-align:center; background-color:#ffa84c; font-weight:bold; font-size:16px;">
                         Shortcuts
					</div>
					<li>
                        <a href="<?php echo site_url('c_entry');?>">Entry</a>
					</li>
					<li>
                        <a href="<?php echo site_url('c_entryfix');?>">Fix Entry</a>
					</li>
					<li>
                        <a href="<?php echo site_url('c_entrywild');?>">Wildcard Entry</a>
					</li>
					<?PHP
					if (strlen($uid) <= 4) //no upload for agt and meb
						{
					?>
					<li>
                        <a href="<?php echo site_url('c_upload');?>">Upload</a>
					</li>
					<?PHP
						}
					?>                           
				</ul>
			</div>
                    <!-- <li><a href="table.html"><i class="icon-table"></i>Profile Page</a></li>
					 <li class="active"><a href="table2.html"><i class="icon-table"></i> Table 2</a></li>-->
                    
					<div id="mws-navigation">
					<ul>
					<div style="color:#000; text-align:center; background-color:#ffa84c; font-weight:bold; font-size:16px;">
                         Main Menu
					</div>
					<li>
                        <a href="#">1.0 User</a>
					<?PHP if($this->session->userdata('side_page') == 1)
							{
								echo '<ul>';
							}
							else
							{
								echo '<ul style="display:none;">';
							}
					?>
                        
                            <li ><a href="<?php echo site_url('c_profile');?>">1.1 Profile</a></li>
							<?PHP
							if (strlen($uid) != 8) //hide for member
								{
							?>
                            <li><a href="<?php echo site_url('c_usermgt');?>">1.2 Management</a></li>
							<?PHP
								}
							?>                           
                        </ul>
                    </li>
					
					<li>
                        <a href="#">2.0 Results</a>
					<?PHP if($this->session->userdata('side_page') == 2)
							{
								echo '<ul>';
							}
							else
							{
								echo '<ul style="display:none;">';
							}
					?>
                            <li><a href="<?php echo site_url('c_results');?>">2.1 Results</a></li>
                            <li><a href="<?php echo site_url('c_payoutguide');?>">2.2 Payout Guide</a></li>
                            
                        </ul>
                    </li>
					
					<li >
                        <a href="#" >3.0 Reports</a>
					<?PHP if($this->session->userdata('side_page') == 3)
							{
								echo '<ul>';
							}
							else
							{
								echo '<ul style="display:none;">';
							}
					?>
                            <li><a href="<?php echo site_url('c_poreportbypage');?>">3.1 Report by page</a></li>
							<?PHP
							if (strlen($uid) != 8) //hide for member
								{
							?>
                            <li><a href="<?php echo site_url('c_posummary');?>">3.2 PlaceOut Summary</a></li>
							<li><a href="<?php echo site_url('c_strike');?>">3.3 Strike Summary</a></li>
                            <li><a href="<?php echo site_url('c_profitloss');?>">3.4 Profit / Loss</a></li>
							<?PHP
								}
							?>                           
                        </ul>
                    </li>
							<?PHP
							if (strlen($uid) != 8) //hide for member
								{
							?>
					<li>
                        <a href="#">4.0 Company Reports</a>
					<?PHP if($this->session->userdata('side_page') == 4)
							{
								echo '<ul>';
							}
							else
							{
								echo '<ul style="display:none;">';
							}
					?>
							<?PHP
							if (strlen($uid) == 2 || strlen($uid) == 14) //show only for master
								{
							?>
                            <li><a href="<?php echo site_url('c_companypl');?>">4.1 Company P/L</a></li>
                            <?PHP
								}
							?>                     
							<?PHP
							if (strlen($uid) == 16) //show only for agent
								{
							?>
                            <li><a href="<?php echo site_url('c_companypl');?>">4.1 Upline P/L</a></li>
                            <?PHP
								}
							?>                   
							<li><a href="<?php echo site_url('c_companystake');?>">4.2 Company Stake</a></li>
							<?PHP
							if (strlen($uid) == 2) //show only for master
								{
							?>
                            <li><a href="<?php echo site_url('c_companystrike');?>">4.3 Company Strike Details</a></li>
                            <?PHP
								}
							?>                           
                        </ul>
                    </li>
					<li>
                        <a href="#">5.0 Logs</a>
					<?PHP if($this->session->userdata('side_page') == 5)
							{
								echo '<ul>';
							}
							else
							{
								echo '<ul style="display:none;">';
							}
					?>
                            <li><a href="<?php echo site_url('c_fixlog');?>">5.1 Fix Entry Logs</a></li>							                            
                        </ul>
                    </li>
							<?PHP
								}
							?>                           

                   
                    
                    
                </ul>
            </div>
        </div>