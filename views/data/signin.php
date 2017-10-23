<!-- JS Custom JS for this template -->
<script type="text/javascript" charset="utf8" src="./views/views/js/signin.js"></script>
<!-- Custom styles for this template -->
<link href="./views/views/css/signin.css" rel="stylesheet">
<link rel="stylesheet" href="./views/views/css/bootstrap new.css" media="all"/>
<?php
require "../base_config.php";
$land_page = $eventus_tix_base_url."/organizer/event_organizer_list";
?>
<script language='javascript'>
	var landingpage = "<?php echo $land_page ?>";
	var rememberme = '<?php echo(isset($_COOKIE["remember_me"])? $_COOKIE["remember_me"]: ""); ?>';
</script>