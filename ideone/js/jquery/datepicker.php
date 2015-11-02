<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {
	$("#premium_start").datepicker({dateFormat: 'yy-mm-dd 00:00:00'});
	$("#premium_end").datepicker({dateFormat: 'yy-mm-dd 00:00:00'});
	$("#pending_date").datepicker({dateFormat: 'yy-mm-dd 00:00:00'});
	$("#cancelled_date").datepicker({dateFormat: 'yy-mm-dd 00:00:00'});
	$("#eot_date").datepicker({dateFormat: 'yy-mm-dd 00:00:00'});
	
	$("#date_start").datepicker({dateFormat: 'yy-mm-dd 00:00:00'});
	$("#date_end").datepicker({dateFormat: 'yy-mm-dd 00:00:00'});
});
</script>