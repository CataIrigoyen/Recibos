<?php
  if( session_status() != PHP_SESSION_ACTIVE ){
    session_start();
  }
  //define('URL_SEMANTIC_UI', 'http://localhost/horacio/sia_recibos/vista/semantic-ui');
  limpiaVar();
  require_once( "modelo/docentes_modelo.php" );
  $conexion = new docente_modelo;
  $matriz   = $conexion -> getDocente();
  $empleado = $_SESSION["empleado"];
  $cuil     = $_SESSION["cuil"];
  $_SESSION['retorno'] = "/proyecto/index.php"
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
      <script>
      function firmar(){
        document.getElementById('accion').value = '1';
        document.getElementById('frmRecibos').submit();
      }

      function rechazar(){
        document.getElementById('accion').value = '2';
        document.getElementById('frmRecibos').submit();
      }
    </script>
  <style>
    #fecha{
      text-align: center;
    }
    #cuil{
      text-align: center; 
    }
    #tabla{
      margin-top: 15px;
      border-width: 2px;
    }
    #titulo{
      margin-top: 40px; 
    }
    #boton_rechazo{
      color: red;
    }
    #boton_motivo{
      color: rgb( 10, 10, 10);
    }
    #boton_motivo2{
      color: Rgb( 200, 200, 200 );
    }

    #boton_firma{
      color: green; 
    }
    #menu{
      border-width: 2px;
    }
    #porte{
      background-color: Rgb( 230, 230, 230 );
    }
    #slider{
      background-color: Rgb( 230, 230, 230 );
    }
    #icon{
      margin-left: 15px;
    }
    </style>
  </head>
  <body>
    <div class="ui main text container" id="titulo">
        <h2 class="ui header">
            <i class="circular user icon"></i>
              <div class="content"><?php echo $empleado; ?><div class="sub header"><?php echo "27-33602013-7"; ?></div>
              </div>
        </h2>         
        <form id="frmRecibos" name="frmRecibos" method="post" action="/proyecto/modelo/firma_docente.php">  
          <input type="hidden" name="accion" id="accion" value=""/>
            <div class="ui attached stackable menu" id ="menu">
              <div class="ui container">
              <a class="item" href="javascript:firmar();">
              <i class="handshake icon"></i>Firmar
            </a>
  
            <a class="item" href="javascript:rechazar();">
              <i class="bolt icon"></i>Rechazar
            </a>  
  
            <?php  
              printf("<a class=\"item\" href=\"modelo/logout.php\">" );
            ?>
              <i class="arrow alternate circle right icon"></i>Salir
            </a>
        
          </div>
        </div>


      <table class="ui compact celled definition table" id = "tabla">
        <thead class="full-width">
          <tr>
            <th data-tooltip="Seleccionar" data-position="top right" data-inverted="" id="porte"><i class="list ul icon" id="icon"></i></th>
            <th>Periodo</th>
            <th>Nº Recibo</th>
            <th data-tooltip="Recibos firmados" data-position="top right" data-inverted="" id="porte"><i class="handshake icon"></i></th>
            <th data-tooltip="Recibos rechazados" data-position="top right" data-inverted="" id="porte"><i class="bolt icon"></i></th>
            <th data-tooltip="Generar recibo PDF" data-position="top right" data-inverted="">Pdf</th>      
            <th data-tooltip="Motivo de rechazo" data-position="top right" data-inverted="">M.R</th>      
            
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ( $matriz as $key){
          ?> 
          <tr>
            <td class="collapsing">
              <div class="ui fitted slider checkbox" id="slider" >
                <input type="checkbox" name="chkRecibo[]" value="<?php echo $key["id"]  ?>"> <label></label>
              </div>
            </td>
            <td width="32%"><?php echo $key[ "periodos" ]; ?></td>
          <td width="32%"><?php echo str_pad( "1", 4, "0", STR_PAD_LEFT ) . "-" . str_pad( StrVal( $key["id_recibo"] ), 5, "0", STR_PAD_LEFT ) ?></td>

          <?php if( $key["firmado"] ): ?>
            <td width="5%"><i class="check circle icon" id="boton_firma"></i> </td>
          <?php else: ?>
              <td width="5%"><i class="circle outline icon" id="boton_firma"></i> </td>
          <?php endif; ?>   

          <?php if( $key["rechazo"] || $key["rechazo2"] ): ?>
              <td width="5%"><i class="check circle icon" id="boton_rechazo"></i></td>
          <?php else: ?>
            <td width="5%"><i class="circle outline icon" id="boton_rechazo"></i></td>
          <?php endif; ?>   
          <?php
            if( $key["rechazo2"] == 1 || $key["rechazo"] == 1 ):
              printf("<td><img src=\"vista/img/pdf2.png\"></td>");
            else:  
              printf("<td><a target=\"_blank\" href=\"modelo/construye_pdf.php?cuil=%s&id_recibo=%s&periodo=%s&empleado=%s\"><img src=\"vista/img/pdf2.png\"></a> </td>", $cuil, $key["id_recibo"], $key["periodo"], $empleado );
            
          endif;
          ?>
          <?php
            if( $key["rechazo2"] == 1 || $key["rechazo"] == 1 ):
              printf("<td><a href=\"modelo/rechazo.php?id=%s&visible=%s&firmado2=%s&anulado=%s&rechazo2=%s&firmado=%s&rechazo=%s\"><i class=\"edit icon\" id=\"boton_motivo\" ></a></td>", $key["id"], $key["visible"], $key["firmado2"], $key["anulado"], $key["rechazo2"], $key["firmado"], $key[ "rechazo" ] );
            else:
              echo "<td width=\"5%\"><i class=\"edit icon\" id=\"boton_motivo2\"></i></td>";
            endif;  
          ?>
        </tr>
        <?php
          }
        ?>
      </tbody>
      <tfoot class="full-width">
        <tr>
          <th></th>
          <th colspan="7">
          </th>
        </tr> 
      </tfoot>
      </div>
    </form>
  </body>
</html>    

<?php
function limpiaVar(){

   if( isset( $_SESSION["chkRecibo"] ) ):
      unset( $_SESSION["chkRecibo"] );
  endif;        
  if( isset( $_SESSION["seleccion"] ) ):
        unset( $_SESSION["seleccion"] );
  endif;      
    if( isset( $_SESSION["retorno"] ) ):
        unset( $_SESSION["retorno"] );
  endif;      


}
?>