<?php

class docente_modelo{

	public $db;
	public $docentes;
	public $cuil;

	public function __construct(){
	
		require_once("conectar.php");
		If( session_status() != PHP_SESSION_ACTIVE ){
			session_start();
		}
		$this -> db = conectar::conexion();
		$this -> docentes = array();
		$this -> cuil = $_SESSION["cuil"];
		
	}	
	
	public function GetDocente(){

		
		$consulta = $this -> db -> query( 'select id, establecimiento, visible, anulado, firmado, firmado2, rechazo, rechazo2, id_recibo, periodo, periodo(periodo ) as periodos, importe from recibos where visible = 1 and firmado2 = 1 and anulado = 0 and cuil = "' . $this -> cuil . '" order by periodos' );	
		while( $filas = $consulta -> fetch( PDO::FETCH_ASSOC ) ){
			$this -> docentes[] = $filas;
		}
		return $this -> docentes;
	}

	}
?>