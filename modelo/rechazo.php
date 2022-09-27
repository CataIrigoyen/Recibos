<!DOCTYPE html>
<html>
    <head>
    <!-- Standard Meta -->
    <link  rel="icon"   href="../vista/img/logo.png"/>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properties -->
    <title>Motivo de rechazo</title>
    <link rel="stylesheet" type="text/css" href="semantic-ui/semantic.min.css">
    <script src="semantic-ui/jquery.min.js" type="text/javascript"></script>
    <script src="semantic-ui/semantic.min.js" type="text/javascript"></script>

	<?php
		require_once( "conectar.php" );
		If( session_status() != PHP_SESSION_ACTIVE ){
    		session_start();
    	}
		if( !isset($_POST["boton_actualizar"]) ):
  		    $action   = $_SERVER[ "PHP_SELF"];
			$id       = $_GET["id"];
			$db       = conectar::conexion();
			$sql      = "select motivo_rechazo from recibos where id = ?";
			$consulta = $db -> prepare( $sql );
			$consulta -> execute( array( $id ) );
			while( $filas = $consulta -> fetch( PDO::FETCH_BOTH ) ){
              $mensaje  = $filas[ 0 ];
			}
		else:
        	$mensaje  = $_POST["txtMensaje"];
            $id       = $_POST["id"];
            $sql      = "update recibos set motivo_rechazo = ? where id = ?";
            $db        = conectar::conexion();                
        	$consulta = $db -> prepare( $sql );
        	$consulta -> execute( array( $mensaje, $id ) );	
			
			Header( "Location: " . $_SESSION["retorno"] );			
		endif;					
?>
		<div class="ui main text container">
            <h2 class="ui header">
                <i class="gavel icon"></i>
                <div class="content">Motivo de rechazo<div class="sub header"></div>
                </div>
            </h2>               
            <hr id="linea"/>
            
            <form id="frm" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                <div class="ui form">
                    <div id="fieldMensaje">
                        <label id="label">Motivo</label>
                        <textarea id="txtMensaje" name="txtMensaje" autofocus><?php echo $mensaje?></textarea>
                    </div>
				</div>
                <hr id="linea1"/>			
            	
				<input name="boton_actualizar" class="ui primary button" type="submit" value="Guardar">
			</form>	

            <!--<a class="small ui button"  href="<?php echo isset($retorno)?$retorno:'javascript:window.history.go(-2);'; ?>">Cerrar</a>
            <a class="small ui button"  href="<?php echo isset($retorno)?$retorno:'javascript:window.history.go(-2);'; ?>">Cerrar</a>-->
        </div>
    </body>
  </html>