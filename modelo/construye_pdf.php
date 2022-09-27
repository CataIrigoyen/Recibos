<?php
  if( session_status() != PHP_SESSION_ACTIVE ){
    session_start();
  }
?>
<!DOCTYPE html>
<html>
  <head>
	<!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properties -->
    <link rel="stylesheet" type="text/css" href="semantic-ui/semantic.css">
    <script src="semantic-ui/jquery.min.js" type="text/javascript"></script>
    <script src="semantic-ui/semantic.min.js" type="text/javascript"></script>
  </head>
  <body>
  	<div class="ui bottom attached warning message"><i class="warning icon"></i> EN CONSTRUCCIÓN </div>
  </body>	
</html>