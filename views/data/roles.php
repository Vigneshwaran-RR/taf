<link href="./views/views/css/roles.css" rel="stylesheet">
<script src="./views/views/js/roles.js"></script>
<?php 
require "../base_config.php";
require_once "./api/Role.php";
require_once "./api/User.php";
require_once "./api/Pages.php";

$role_obj = new Role();
$user_obj = new User();
$pages_obj = new Pages();
/*
$get_roles 	= array();
$get_users 	= array();
$get_pages 	= array();
$role_names = array();
$role_id 	= array(); */
$roles_data = $role_obj->getAllRoles();
$roles = $roles_data;
$users_data = $user_obj->getAllUsers();
$users = $users_data;
$pages_data = $pages_obj->getAllPages();
$pages = $pages_data;

?>

<script type="text/javascript" language="javascript">
	var pass_roles = <?php echo json_encode($roles) ?>;	
    var pass_users = <?php echo json_encode($users) ?>;
    var pass_pages = <?php echo json_encode($pages) ?>;    
</script>