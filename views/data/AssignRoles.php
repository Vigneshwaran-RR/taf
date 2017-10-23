<link href="./views/views/css/AssignRoles.css" rel="stylesheet">
<script src="./views/views/js/AssignRoles.js"></script>
<?php

require_once "api/Role.php";
require_once "api/User.php";
$role_obj = new Role();
$user_obj = new User();
$roles_data = $role_obj->getAllRoles();
$roles = $roles_data;
$users_data = $user_obj->getAllUsers();
$users = $users_data;

?>

<script type="text/javascript" language="javascript">
	var pass_roles = <?php echo json_encode($roles); ?>;	
    var pass_users = <?php echo json_encode($users); ?>;
</script>