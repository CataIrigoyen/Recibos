<?php
    If( session_status() != PHP_SESSION_ACTIVE ){
      session_start();
    }
  	foreach($_SESSION as $key => $value) {
		$_SESSION[$key] = NULL;
	}
	session_destroy();	
	header("Location: /proyecto/login.php");
?>