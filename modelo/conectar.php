<?php
	class conectar{

		public static function conexion(){
			try{
				$conexion = new PDO( 'mysql:host=127.0.0.1; dbname=proyecto', 'horacio', 'alambre' );
    	    	$conexion -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
    	    	$conexion -> exec("SET CHARACTER SET utf8");
        	}catch( PDOException $e ){
    	    	die( 'Ërror ' . $e -> getMessasge() );	
    	    	exit;
    	    }
    	    return $conexion;
		}
	}
?>