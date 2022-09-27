<?php
  	require_once("conectar.php");
  	if( session_status() != PHP_SESSION_ACTIVE ){
    	session_start();
  	}
	if( isset( $_POST["username"] ) && isset( $_POST["password"] ) ):
		$db        = conectar::conexion();
		$usuario   = $_POST["username"];
		$passw     = $_POST["password"];
		$query     = "select * from usuarios where usuario = ? and passw = ?";
		$resultado = $db -> prepare( $query);
		$resultado -> execute( array( $usuario, $passw ) );
		if( $resultado->rowCount() == 1 ):
			$_SESSION['r_social']      = "ASOCIACION CIVIL INSTITUTO SILOE";
			$_SESSION['empleado']      = "DELLACASA MERCEDES";
			$_SESSION["cuil"]    	   = "20-13267868-6";
			$_SESSION["usuario"]       = $usuario;
			$_SESSION["passw"]         = $passw;
			Header( "Location: /proyecto/index.php" );	
		else:
			Header( "Location: /proyecto/login.php" );	
		endif;	


	else:
		Header( "Location: /proyecto/login.php" );
	endif;	
?>
