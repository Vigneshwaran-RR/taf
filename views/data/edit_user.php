<script type="text/javascript" charset="utf8" src="./views/views/js/edit_user.js"></script>
<link rel="stylesheet" href="./views/views/css/bootstrap new.css" media="all"/>
<link rel="stylesheet" href="./views/views/css/event_organizer_list.css" media="all"/>
<link rel="stylesheet" href="./views/views/css/edit_user.css" media="all"/>

<?php
require "../base_config.php";
require_once "./api/User.php";
//echo $eventus_tix_base_url;
$id = $_REQUEST['id'];
$org_obj 	= new User();
$org_data 	= $org_obj->getOrganizerUserByEmail($id);
echo $org_data[0]['password'];
?>

<script type="text/javascript">
var pass_organizer_user		= <?php echo json_encode($org_data) ?>;
</script>