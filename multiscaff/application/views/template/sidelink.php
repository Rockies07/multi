<div id="wrapper">
	<div id="menu" class="hidden-phone">
		<div id="menuInner">
		
			<!-- Scrollable menu wrapper with Maximum height -->
			<div class="slim-scroll" data-scroll-height="420px">
			<ul>
				<li class="heading"><span>Category</span></li>
				<li class="glyphicons home"><?php echo anchor('home/index', '<i></i><span>Dashboard</span>');?></li>
				<li class="hasSubmenu">
					<a data-toggle="collapse" class="glyphicons adress_book" href="#menu_hrm"><i></i><span>HRM</span></a>
					<ul class="collapse" id="menu_hrm">
						<li class=""><?php echo anchor('employee/management', 'NTS Worker List (Active)');?></li>
						<li class=""><?php echo anchor('employee/get_list/Active/0', 'NTS Worker List (Left)');?></li>
						<li class=""><?php echo anchor('report/employee_activity', 'NTS Worker Activity');?></li>
						<li class=""><?php echo anchor('transaction_employee/add', 'Daily Supply Transaction');?></li>
						<li class=""><?php echo anchor('transaction_employee/management', 'Daily NTS Worker List');?></li>
						<li class=""><?php echo anchor('report/man_count_summary', 'Man Count Summary');?></li>
					</ul>
				</li>
				<li class="hasSubmenu">
					<a data-toggle="collapse" class="glyphicons pencil" href="#menu_transaction"><i></i><span>Transaction</span></a>
					<ul class="collapse" id="menu_transaction">
						<li class=""><?php echo anchor('transaction_unit/add', 'Daily (Unit)');?></li>
						<li class=""><?php echo anchor('monthly_expenses/management', 'Monthly Expenses');?></li>
						<li class=""><?php echo anchor('purchase/add', 'Purchase Assets');?></li>
						<li class=""><?php echo anchor('loan/add', 'Loan');?></li>
					</ul>
				</li>
				<li class="hasSubmenu">
					<a data-toggle="collapse" class="glyphicons calendar" href="#menu_schedule"><i></i><span>Scheduler</span></a>
					<ul class="collapse" id="menu_schedule">
						<li class=""><?php echo anchor('schedule/calendar', 'Daily Management');?></li>
						<li class=""><?php echo anchor('schedule/timeline', 'Remark & Timeline');?></li>
					</ul>
				</li>
				<li class="hasSubmenu">
					<a data-toggle="collapse" class="glyphicons table" href="#menu_journal"><i></i><span>Journal</span></a>
					<ul class="collapse" id="menu_journal">
						<li class=""><?php echo anchor('transaction_journal/add_deposit', 'Deposit');?></li>
						<li class=""><?php echo anchor('transaction_journal/add_expenses', 'Expenses');?></li>
						<li class=""><?php echo anchor('transaction_journal/journal_statement', 'Statement');?></li>
						<li class=""><?php echo anchor('transaction_journal/account_summary', 'Account Summary');?></li>
					</ul>
				</li>
				<li class="hasSubmenu">
					<a data-toggle="collapse" class="glyphicons shopping_cart" href="#menu_inventory"><i></i><span>Inventory</span></a>
					<ul class="collapse" id="menu_inventory">
						<li class=""><?php echo anchor('transaction_inventory/inventory_requisition', 'Inventory Requisition');?></li>
					</ul>
				</li>
				<li class="glyphicons calendar"><?php echo anchor('transaction_employee/management', '<i></i><span>Absence</span>');?></li>
				<li class="hasSubmenu">
					<a data-toggle="collapse" class="glyphicons calendar" href="#menu_CRM"><i></i><span>CRM</span></a>
					<ul class="collapse" id="menu_CRM">
						<li class=""><?php echo anchor('transaction_inventory/inventory_requisition', 'Assign Task');?></li>
						<li class=""><?php echo anchor('transaction_inventory/inventory_requisition', 'Create Notes');?></li>
						<li class=""><?php echo anchor('transaction_inventory/inventory_requisition', 'Task List');?></li>
						<li class=""><?php echo anchor('transaction_inventory/inventory_requisition', 'Upcoming Activity');?></li>
					</ul>
				</li>
				<li class="hasSubmenu">
					<a data-toggle="collapse" class="glyphicons envelope" href="#menu_report"><i></i><span>Report</span></a>
					<ul class="collapse" id="menu_report">
						<li class=""><?php echo anchor('report/period', 'Daily');?></li>
						<!--<li class=""><?php echo anchor('report/period', 'Daily');?></li>-->
						<li class=""><?php echo anchor('report/monthly', 'Monthly(Simple)');?></li>
						<li class=""><?php echo anchor('report/monthly_by_date', 'Monthly(Detail)');?></li>
						<li class=""><?php echo anchor('report/project', 'Project');?></li>
						<li class=""><?php echo anchor('report/collection', 'Collection');?></li>
					</ul>
				</li>
			</ul>
			<ul>
				<li class="heading"><span>Administration</span></li>
				<li class="glyphicons settings"><?php echo anchor('setting/management', '<i></i><span>Setting</span>');?></li>
				<li class="hasSubmenu">
					<a data-toggle="collapse" class="glyphicons sort" href="#menu_master"><i></i><span>Master</span></a>
					<ul class="collapse" id="menu_master">
						<li class=""><?php echo anchor('account/management', 'Account');?></li>
						<li class=""><?php echo anchor('business/management', 'Business');?></li>
						<li class=""><?php echo anchor('client/management', 'Client');?></li>
						<li class=""><?php echo anchor('country/management', 'Country');?></li>
						<li class=""><?php echo anchor('product/management', 'Inventory');?></li>
						<li class=""><?php echo anchor('ledger/management', 'Ledger');?></li>
						<li class=""><?php echo anchor('project/management', 'Project');?></li>
						<li class=""><?php echo anchor('site/management', 'Site');?></li>
						<li class=""><?php echo anchor('supplier/management', 'Supplier');?></li>
						<!--<li class=""><a href="product_edit.html?lang=en"><span>Product</span></a></li>
						<li class=""><a href="product_edit.html?lang=en"><span>Manufacturing</span></a></li>-->
					</ul>
				</li>
				<li class="glyphicons group"><?php echo anchor('employee/group', '<i></i><span>Group</span>');?></li>
				<li class="glyphicons calendar"><?php echo anchor('day_preset/management', '<i></i><span>Holiday Preset</span>');?></li>
				<li class="glyphicons cogwheel"><?php echo anchor('transaction_employee/configuration', '<i></i><span>Update Detail</span>');?></li>
				<li class="glyphicons user"><?php echo anchor('user/management', '<i></i><span>User Management</span>');?></li>
			</ul>
		</div>
		
		</div>
		<!-- // Nice Scroll Wrapper END -->
		
	</div>