<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/css/loading.css" />
				
<style>
.passport,.work_permit,.airport_pass,.user_detail,.compulsory_course,.basic_course,.low_levy_course{
	display: none;
}

#table_container{
	overflow:scroll;
}

a{
	color:#484c50;
}

.control-label{
	font-weight: bold;
}

.modal-title{
	padding-top: 5px;
	height: 35px;
}

.modal-header{
	background-color: #EEE;
}
</style>

<div id="content">
	<div class="se-pre-con"></div>
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>User</li>s
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>User</h3>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">User List</h4>
			</div>
			<div class="widget-body" id="table_container">
				<div class="span11" style="padding:0;margin:0;">
					&nbsp;
				</div>
				<div class="span2 right" style="padding:0;margin:0;">	
					<button type="reset" class="btn btn-icon btn-success glyphicons user_add span3" onclick="add_user()"><i></i>Add New User</button>
				</div>
				<div class="separator"></div>
				<div class="separator"></div>
				<div style="height:600px;margin-left: 2px;">
					<table class="table table-bordered table-primary table-condensed">
						<thead>
							<tr>
								<th width="10px">S/N</th>
								<th width="180px">Username</th>
								<th class="center" width="100px">Status</th>
								<th width="60px" >Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$i=0;
								foreach ($user as $user_item){
									$i++;
									$id=$user_item['id'];
							?>
									<tr class="gradeX">
										<td class="center"><?php echo $i; ?></td>
										<td><?php echo $user_item['username']; ?></td>
										<td class="center"><?php echo $user_item['status']; ?></td>
										<td class="center actions" style="padding-left:2px;">
											<?php echo anchor('user/add/'.$user_item['id'], '<i></i>',array('class' => 'btn-action glyphicons pencil btn-success'));?>
										</td>
									</tr>
							<?php 
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	
<script>
	function reload(){
		window.location.href = '<?PHP echo site_url("user/management"); ?>';
	}

	function add_user(){
		window.location.href = '<?PHP echo site_url("user/add"); ?>';
	}

	$(function() {
		$(".datetimepicker").datepicker({
		showOn: 'both', 
		buttonImage: '<?php echo base_url();?>public/images/icon/calendar.gif', 
		buttonImageOnly: true,
		changeMonth: true,
      	changeYear: true
		});
	});

	$(document).on("click", ".open-homeLeaveModal", function (e) {

	    e.preventDefault();

	    var _self = $(this);

	    var nts = _self.data('nts');
	    $("#nts").val(nts);

	    $(_self.attr('href')).modal('show');
	});

	function save_home_leave()
	{
		var nts=$("#nts").val();
		if($("#start_hl_date").val()!="")
		{
			var date_arr="";
			date_arr=$("#start_hl_date").val().split("/");
			var start_hl_date=date_arr[2]+"-"+date_arr[0]+"-"+date_arr[1];

		    var date_arr="";
			date_arr=$("#end_hl_date").val().split("/");
			var end_hl_date=date_arr[2]+"-"+date_arr[0]+"-"+date_arr[1];

		    var string_data=nts+"---"+start_hl_date+"---"+end_hl_date;

		    $.ajax(
			{
				url: "<?php echo site_url('utility/save_home_leave/"+string_data+"'); ?>",
				type:'POST', //data type
				dataType : "json",
				success:function(data){
					alert("Data Updated");
					window.location.href = '<?PHP echo site_url("user/management"); ?>';
				},
				error:function(data){
					alert("Error when Saving");
				}
			});
		}
		else
		{
			alert("Start Home Leave Date cannot be Empty");
		}
	}

	function show_hl_date()
	{
		var status=$("#status").val();
		if(status=="Cancel Permit" || status=="Resign" || status=="Terminated" || status=="Transfer")
		{
			$(".end_date").show();
		}
		else
		{
			$(".end_date").hide();
		}
	}

	$(document).ready(function(){
		show_hl_date();
	});

	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});

	function show_detail(id, value, width)
	{
		var table_width=$('#table_container').width();

		if($('#' + id).is(":checked"))
		{
			$('.' + value).show();
			
			table_width=table_width+width;
			$('#table_container').width(table_width);
		}
		else
		{
			$('.' + value).hide();
			table_width=table_width-width;
			$('#table_container').width(table_width);
		}
	}
</script>	
	
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
