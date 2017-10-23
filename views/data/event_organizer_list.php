<script type="text/javascript" charset="utf8" src="./views/views/js/event_organizer_list.js"></script>
<link rel="stylesheet" href="./views/views/css/bootstrap new.css" media="all"/>
<link rel="stylesheet" href="./views/views/css/event_organizer_list.css" media="all"/>
<?php
require "../base_config.php";
require_once "./api/Organizer.php";
$pathToLoad = $eventus_tix_base_url."/organizer/create_organizer";
$modify_org = $eventus_tix_base_url."/organizer/modify_organizer";
$manage_org = $eventus_tix_base_url."/organizer/manage_user";
$log_out 	= $eventus_tix_base_url."/organizer/logout";

$org_obj = new Organizer();
//$get_Organizers = array();
$organizer_data = $org_obj->getAllOrganizers();
?>
<script type="text/javascript">
var pathToLoad = "<?php echo $pathToLoad ?>";
var modify_org = "<?php echo $modify_org ?>";
var manage_org = "<?php echo $manage_org ?>";
var logout 	   = "<?php echo $log_out ?>";
var pass_organizers = <?php echo json_encode($organizer_data) ?>;
</script>