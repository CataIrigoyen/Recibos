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
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="ui one column stackable center aligned page grid">
        <div class="column eight wide">
            <form class="ui form" method="post" action="/proyecto/modelo/loguear.php">
                <div class="ui hidden divider"></div>
                <h1 class="ui dividing header">Sistema recibos digitales</h1>
                <br>
                <div class="field">
                    <input name="username" placeholder="Usuario" type="text">
                </div>
                <div class="field">
                    <input name="password" placeholder="Contraseña" type="password">
                </div>
                <div class="field">
                    <div class="ui checkbox">
                        <input name="userRememberMe" type="checkbox">
                        <label>Recordar credenciales</label>
                    </div>
                </div>
                <div class="ui hidden divider"></div>
                <input name="boton_actualizar" class="fluid ui primary button" type="submit" value="Iniciar Sesi&oacute;n">
            </form>
        </div>
    </div>
  </body>
</html>