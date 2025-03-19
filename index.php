<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Inicio</title>
    <?php  
      require_once('bootstrap/bootstrap.php');
    ?>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-196085043-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-196085043-1');
</script>

    
  </head>
  <body>
    <div class="wrapper fadeInDown">
      <div id="formContent">
        <div class="fadeIn first">
          <img src="img/logoieppdch.png" width="100%" height="100%" />
          <hr>
          <strong><h3> Sistema de Información <br></h3> 
        </div>

        <div align="center">
          <?php 
                 if (isset($_GET["acceso_sys"]))
                         $mensaje=($_GET["acceso_sys"]);
                  else
                     $mensaje="";
                     echo '<h2>'.$mensaje.'</h2>';
          ?>
        </div>

        <form class="form-signin" method="POST" action="validar_sys.php">
          <div class="form-label-group">
            <input type="text" id="inputEmail" class="form-control" placeholder="Email address" name="usrname" required autofocus>
            <label for="inputEmail">Usuario</label>
          </div>

          <div class="form-label-group">
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="psw" required>
            <label for="inputPassword">Contraseña</label>
          </div> 
        
            <input type="submit" class="fadeIn fourth" value="Ingresar">
        </form>


      </div>
    </div>
  </body>
</html>