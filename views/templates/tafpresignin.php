<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo APPTITLE ?></title>

    <!-- Bootstrap core CSS -->
   <!-- <link href="./views/views/css/bootstrap.css" rel="stylesheet"> -->
    <link href="./views/views/css/bootstrap new.css" rel="stylesheet">

    <!-- TAF CSS -->
    <link href="./views/views/css/taf.css" rel="stylesheet">

    <!-- JS jQuery -->
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>

    <!-- JS Bootstrap -->
    <script type="text/javascript" charset="utf8" src="./views/views/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="./views/views/js/taf.js"></script>
  </head>
  <body>
    <?php require_once HEADPIECE; ?>
    <?php require_once NECKPIECE; ?>
   
        <?php
            $this->renderContent($page);
            // require_once "views/data/" . $page . ".php";
            // require_once "views/views/" . $page . ".html";
        ?>
   
    <?php require_once TAILPIECE; ?>
</body>
</html>
