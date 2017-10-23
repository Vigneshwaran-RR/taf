<link href="./views/views/css/DeleteRoles.css" rel="stylesheet">
<script src="./views/views/js/DeleteRoles.js"></script>

<?php

require_once "api/Role.php";
$role_obj = new Role();
$roles_data = $role_obj->getAllRoles();
$roles = $roles_data;

?>

<script type="text/javascript" language="javascript">
	var pass_roles = <?php echo json_encode($roles); ?>;	
</script>