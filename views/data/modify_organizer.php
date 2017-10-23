<script type="text/javascript" charset="utf8" src="./views/views/js/modify_organizer.js"></script>
<link rel="stylesheet" href="./views/views/css/bootstrap new.css" media="all"/>
<link rel="stylesheet" href="./views/views/css/create_organizer.css" media="all"/>
<?php 
require "../base_config.php";
require_once "./api/Organizer.php";
$org_obj = new Organizer();
$email = $_REQUEST['id'];
$organizer_data = $org_obj->getOrganizerByEmail($email);
?>
<script type="text/javascript">
var pass_organizers = <?php echo json_encode($organizer_data) ?>;
</script>