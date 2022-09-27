<!DOCTYPE html>
<html>
    <head>
    <!-- Standard Meta -->
    	<link  rel="icon"   href="../vista/img/logo.png"/>
    	<meta charset="utf-8" />
    	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    	<?php
		    If( session_status() != PHP_SESSION_ACTIVE ){
    	  		session_start();
    		}

	    	if( !isset($_SESSION["seleccion"] ) ):
    			if( $_POST["accion"] == 1):
	    			echo "<title>Firmar Recibos</title>";
    			else:
    				echo "<title>Rechazar Recibos</title>";
    			endif;	
    		else:
    			if( $_SESSION["seleccion"] == 1 ):
    				echo "<title>Firmar Recibos</title>";
    			else:
    				echo "<title>Rechazar Recibos</title>";
    			endif;	
    		endif;	
    		    	?>
    	<link rel="stylesheet" type="text/css" href="semantic-ui/semantic.min.css">
    	<script src="semantic-ui/jquery.min.js" type="text/javascript"></script>
    	<script src="semantic-ui/semantic.min.js" type="text/javascript"></script>
		<style>
			body{
            	margin-top: 40px;
            	margin-bottom: 40px;
        	}
        	#label{
        		color: black;
        		font-family: "Arial";
        		font-size: 14px;
        	}	
        	
        	#linea{
        		border-color: Rgb( 213, 247, 247 );
        		border-style: 
        	}	
		</style>
	</head>
	<body>
		<?php
		  require_once( "conectar.php" );
			if( !isset( $_SESSION["passw"] ) ){
				Header( "Location: /horacio/sia_recibos/login.php" );
			}
			if( !isset($_SESSION["chkRecibo"] ) ):
				$_SESSION["retorno"] = $_SERVER['HTTP_REFERER'];	
				if( !isset( $_POST["chkRecibo"] ) ):
					Header( "Location: " . $_SESSION["retorno"]);
				endif;
			endif;		
			$action  = $_SERVER[ "PHP_SELF"];
			if(!isset($_POST["boton_actualizar"])):
				if(!isset( $_SESSION["seleccion"] ) ):
					$_SESSION["seleccion"] = $_POST[ "accion"];
				endif;
				if(!isset( $_SESSION["chkRecibo"] ) ):
					$_SESSION["chkRecibo"]= $_POST[ "chkRecibo"];
				endif;	
				$valorDevuelto = verificaRecibos();
				if( $valorDevuelto == 0):
					Header( "Location: " . $_SESSION["retorno"] );
				endif;	
			else:
				$usuario       = $_POST["usuario"];
				$password      = $_POST["password"];
				$elArray       = $_SESSION["chkRecibo"];
				$date          = date( "d/m/yy" ); //new DateTime('NOW');
				$texto_rechazo = "Fecha de rechazo: " . $date ."\n" . "Rechazado por el empleado" ."\n" . "MOTIVO DEL RECHAZO:";
				if( $usuario == $_SESSION["usuario"] && $password == $_SESSION["passw"] ):
					$db = conectar::conexion();
					for($i = 0; $i < count( $elArray ); $i++){
						$sql="select rechazo, rechazo2, firmado, firmado2, visible, anulado from recibos where id = ?";
						$consulta  = $db -> prepare( $sql );
						$consulta -> execute( array( $elArray[ $i ] ) );						
						while( $filas = $consulta -> fetch( PDO::FETCH_BOTH ) ){
              $rechazo  = $filas[ 0 ];
              $rechazo2 = $filas[ 1 ];  
              $firmado  = $filas[ 2 ];  
              $firmado2 = $filas[ 3 ];
              $visible  = $filas[ 4 ];                
              $anulado  = $filas[ 5 ];
							if( $filas[ 0 ] == 0 && $filas[ 1 ] == 0 ):
								$bbdd = conectar::conexion();
								if( $_SESSION["seleccion"] == 1):
									$update = "update recibos set firmado = 1, fecha_firma = ? where id = ?";
								else:	
									$update = "update recibos set rechazo = 1, fecha_rechazo = ?, motivo_rechazo = ? where id = ?";
                endif;
								$resultado = $bbdd -> prepare( $update );
								if( $_SESSION["seleccion"] == 1):
									$resultado -> execute( array( date('yy-m-d'), $elArray[ $i ] ) );						
								else:
									$resultado -> execute( array( date('yy-m-d'), $texto_rechazo, $elArray[ $i ] ) );						
								endif;	
							endif;	
						}		
					  $nId = $elArray[ $i ];  
          }
				  if( $_SESSION["seleccion"] == 2 ):
          Header( "Location: ../modelo/rechazo.php?id=" . $nId );

          else:
             unset( $_SESSION["chkRecibo"] );
					   unset( $_SESSION["seleccion"] );
					   Header( "Location: " . $_SESSION["retorno"] );
          endif;   
				endif;	
			endif;
		?>	
		<div class="ui main text container">
			<h2 class="ui header" id="header">
  				<i class="thumbtack icon"></i>
  					<div class="content">Confirme operación<div class="sub header">Ingrese sus credenciales</div>
  					</div>
			</h2> 				
		<hr id="linea"/>		
        <form id="frm" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div class="ui form">
                <div class="fields">
                    <div class="eight wide field">
                        <label id="label">Usuario</label>
                        <input type="text" name="usuario" required value="">     
                    </div>
                </div>    
            </div>    

            <div class="ui form">
                <div class="fields">
                    <div class="eight wide field">
                        <label id="label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required value="">     
                    </div>
                </div>    
            </div>  
            <hr id="linea"/>
            <input type="button" onClick="history.back()" class="ui button" value="Cancelar">
            <input name="boton_actualizar" class="ui primary button" type="submit" value="Confirmar">
        </form>    
    </body>
</html>    

<?php

function verificaRecibos(){
	
	$valorDevuelto = 0;
	$arrayRecibos  = $_SESSION[ "chkRecibo"];
	$db = conectar::conexion();
	for( $i = 0; $i < count( $arrayRecibos); $i++ ){
		$sql = "select rechazo, rechazo2, firmado from recibos where id = ?";
		$result = $db -> prepare( $sql );
		$result -> execute( array( $arrayRecibos[ $i ] ) );
		while( $filas = $result -> fetch( PDO::FETCH_BOTH ) ){
			if( $_SESSION["seleccion"] == 1 ):
				if( $filas[ 2 ] == 1 || $filas[ 0 ] == 1 || $filas[ 1 ] == 1 ):
					$valorDevuelto = 0;
				else:
					$valorDevuelto = 1;
					break;
				endif;
			else:
				if( $filas[ 0 ] == 1 || $filas[ 1 ] == 1 || $filas[ 2 ] == 1 ):
					$valorDevuelto = 0;
				else:			
					$valorDevuelto = 1;
					break;
				endif;
			endif;	
		}
	}
	return $valorDevuelto;
}
?>

<script>
function doFormat(x, pattern, mask) {
  var strippedValue = x.replace(/[^0-9]/g, "");
  var chars = strippedValue.split('');
  var count = 0;

  var formatted = '';
  for (var i=0; i<pattern.length; i++) {
    const c = pattern[i];
    if (chars[count]) {
      if (/\*/.test(c)) {
        formatted += chars[count];
        count++;
      } else {
        formatted += c;
      }
    } else if (mask) {
      if (mask.split('')[i])
        formatted += mask.split('')[i];
    }
  }
  return formatted;
}

document.querySelectorAll('[data-mask]').forEach(function(e) {
  function format(elem) {
    const val = doFormat(elem.value, elem.getAttribute('data-format'));
    elem.value = doFormat(elem.value, elem.getAttribute('data-format'), elem.getAttribute('data-mask'));
    
    if (elem.createTextRange) {
      var range = elem.createTextRange();
      range.move('character', val.length);
      range.select();
    } else if (elem.selectionStart) {
      elem.focus();
      elem.setSelectionRange(val.length, val.length);
    }
  }
  e.addEventListener('keyup', function() {
    format(e);
  });
  e.addEventListener('keydown', function() {
    format(e);
  });
  format(e)
});

document.querySelectorAll('[dni-mask]').forEach(function(e) {
  function format(elem) {
    const val = doFormat(elem.value, elem.getAttribute('dni-format'));
    elem.value = doFormat(elem.value, elem.getAttribute('dni-format'), elem.getAttribute('dni-mask'));
    
    if (elem.createTextRange) {
      var range = elem.createTextRange();
      range.move('character', val.length);
      range.select();
    } else if (elem.selectionStart) {
      elem.focus();
      elem.setSelectionRange(val.length, val.length);
    }
  }
  e.addEventListener('keyup', function() {
    format(e);
  });
  e.addEventListener('keydown', function() {
    format(e);
  });
  format(e)
});
</script> 