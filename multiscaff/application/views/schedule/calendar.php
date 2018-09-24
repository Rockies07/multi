<style>
#calendar {
	max-width: 95%;
	margin: 0 auto;
	padding: 20px;
	font-size: 16px;
}
</style>

<link rel="stylesheet" href="<?php echo base_url();?>public/css/fullcalendar.css" />
<link rel="stylesheet" href="<?php echo base_url();?>public/css/fullcalendar.print.css" media='print' />
<script src="<?php echo base_url();?>public/js/moment.min.js"></script>
<script src="<?php echo base_url();?>public/js/fullcalendar.min.js"></script>
<script>

	$(document).ready(function() {
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
	        editable: true,
	        eventLimit: true,
	        events: <?php echo $schedule ?>,
	        defaultDate: "<?php echo date('Y-m-d'); ?>",
	        eventDrop: function(event, delta) {
	        	day=delta/60/60/24/1000;
	        	sec=delta+1000;
	            
	        	var string_data=event.id+"---"+day;
	        	
			    $.ajax(
				{
					url: "<?php echo site_url('utility/update_calendar_drag/"+string_data+"'); ?>",
					type:'POST', //data type
					dataType : "json",
					success:function(data){
						//alert("Data Updated");
					},
					error:function(data){
						alert("Error when Saving");
					}
				});

	        },

	        eventResize: function(event, delta) {
	        	hour=delta/60/60/1000;
	        	sec=delta/1000;
	            
	        	var string_data=event.id+"---"+sec;
	        	
			    $.ajax(
				{
					url: "<?php echo site_url('utility/update_calendar_resize/"+string_data+"'); ?>",
					type:'POST', //data type
					dataType : "json",
					success:function(data){
						//alert(data.start+" Data Updated "+sec);
					},
					error:function(data){
						alert("Error when Saving");
					}
				});
	        },

	        loading: function(bool) {
	            if (bool) $('#loading').show();
	            else $('#loading').hide();
	        }

	    });
	});

</script>

<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Schedule</li>
		<li class="divider"></li>
		<li>Daily Management</li>
	</ul>
	<div id="calendar"></div>
