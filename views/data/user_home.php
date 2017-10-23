<script type="text/javascript" charset="utf8" src="./views/views/js/user_home.js"></script>
<link rel="stylesheet" href="./views/views/css/bootstrap new.css" media="all"/>
<link rel="stylesheet" href="./views/views/css/user_home.css" media="all"/>
<?php
require "../base_config.php";
require_once "./api/Organizer.php";

$org_obj 					= new Organizer(); 
$organizer_events_data 		= $org_obj->get_org_events($_SESSION['taf_org_id']); // All events that comes under organizer
$organizer_event_full_data 	= $org_obj->get_org_event_shows_data($organizer_events_data);
$count = count($organizer_event_full_data);
?>

<script type="text/javascript">
var organizer_event_full_data = <?php echo json_encode($organizer_event_full_data) ?>;
var count = <?php echo $count ?>;
// var shows = <?php echo json_encode($organizer_event_full_data) ?>;
// var shows_date = <?php echo json_encode($shows_date) ?>;
// var shows_time = <?php echo json_encode($shows_time) ?>;
// var show_count = <?php echo json_encode($show_count) ?>;
// var shows_name = <?php echo json_encode($shows_name) ?>;
</script>