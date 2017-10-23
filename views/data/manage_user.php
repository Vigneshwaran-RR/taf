<script type="text/javascript" charset="utf8" src="./views/views/js/manage_user.js"></script>
<link rel="stylesheet" href="./views/views/css/bootstrap new.css" media="all"/>
<link rel="stylesheet" href="./views/views/css/manage_user.css" media="all"/>
<link rel="stylesheet" href="./views/views/css/create_organizer.css" media="all"/>
<?php
require "../base_config.php";
require_once "./api/User.php";
$pathToEditUser 		= $eventus_tix_base_url."/organizer/edit_user";
$pathToEditSendPasswd 	= $eventus_tix_base_url."/organizer/send_password";
$pathToDeleteUser 		= $eventus_tix_base_url."/organizer/delete_user";
$org_id 				= $_REQUEST['id'];
$org_obj 				= new User();
$org_data 				= $org_obj->getAllOrganizerUsers($org_id);

foreach ($org_data as $key => $value) {
	$organizer_data[] = $value;
}

?>

<script type="text/javascript">
var pathToEditUser 			= "<?php echo $pathToEditUser ?>";
var pathToEditSendPasswd 	= "<?php echo $pathToEditSendPasswd ?>";
var pathToDeleteUser 		= "<?php echo $pathToDeleteUser ?>";
var organizer_id			= "<?php echo $org_id ?>";
var pass_organizers 		= <?php echo json_encode($organizer_data) ?>;
</script>