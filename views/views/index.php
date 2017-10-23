<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="./views/views/css/bootstrap.css" rel="stylesheet">

    <!-- JS Custom JS for this template -->
    <script type="text/javascript" charset="utf8" src="./views/views/js/signin.js"></script>
    <!-- Custom styles for this template -->
    <link href="./views/views/css/signin.css" rel="stylesheet">
  </head>
  <body>
<?php
$actionurl = $_SERVER['REQUEST_URI'];
if (strpos($actionurl, "noauth.php"))
	$actionurl = LANDINGPAGE;

?>
    <div class="container">
    <img id="logo" src="<?php echo BASEURL; ?>/views/views/img/logo.png"/>
    <h1 id="heading">TechArtusFramework</h1>
      <form class="form-signin" method='post' action='<?php echo $actionurl; ?>'>
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" name='username' id='username' class="input-block-level" placeholder="Username" autofocus value="<?php
if(isset($_COOKIE['remember_me'])) echo $_COOKIE['remember_me']; ?>">
        <input type="password" name='password' id='password' class="input-block-level" placeholder="Password">
        <label class="checkbox">
          <input type="checkbox" name='remember' id='remember' <?php if(isset($_COOKIE['remember_me'])) {
			echo 'checked="checked"';
		}
		else {
			echo '';
		}
		?> > Remember me
        </label>
        <button class="btn btn-large btn-primary btn-block" type="submit">Sign in</button>
        <button class="btn btn-large btn-primary btn-block" type="button" id='register'>Register</button>
      </form>
    </div>
</body>
</html>
