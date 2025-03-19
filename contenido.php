<?php  
  require_once('validar_sesion_sys.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link href="../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>

<body class="sb-nav-fixed">
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="#"><img src="../../../img/logoieppdch.png" width="100%" height="100%" /></a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
     <div class="input-group">
       <div class="input-group-append">
        <!--  <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button> -->
       </div>
     </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
     <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
       <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
        <div class="dropdown-divider"></div>
         <a class="dropdown-item" href="../../cerrarsesion_sys.php">Cerrar sesión</a>
        </div>
     </li>
    </ul>
  </nav>

  <div id="layoutSidenav">
   <div id="layoutSidenav_nav">
    <?php
     include ("nav_sys.php");
    ?>
   </div>
   <div id="layoutSidenav_content">
    <main>
    <div class="container-fluid">
     <div class="card m-1">
      <div class="card-header my-0 py-0">Modulo de Captura de Contenidos</div>
       <div class="row no-gutters">
         <div class="col-auto text-center m-2">
          <i class="fas fa-school fa-5x text-secondary"></i>
         </div>
         <div class="col">
           <div class="card-body my-0 py-0 mx-0">
             <?php
             echo '<div class=\'row no-gutters\'><div class=\'col-md-6 col-sm-8\'>Nombre: '.$_SESSION['usua']['nombre_usuario'].'</div><div class=\'col-md-6 col-sm-4\'>Tipo de Usuario: '.$_SESSION['usua']['tipo_usuario'].'</div></div>'.'<div class=\'row no-gutters\'><div class=\'col\'>Email.: '.$_SESSION['usua']['email'].'</div></div>';
             ?>
           </div>
          </div>
         </div>
        </div>
        <?php
         if(isset($_SESSION['error_bcurp']) && $_SESSION['error_bcurp']!='')
         {
          echo "<div class='alert alert-warning text-center' role='alert'>".$_SESSION['error_bcurp']."</div>";
          $_SESSION['error_bcurp']='';
          unset($_SESSION['error_bcurp']);
         }
        ?>
                    
<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_evaluacion";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los niveles
$sql_nivel = "SELECT id_nivel, nombre_nivel FROM nivel";
$result_nivel = $conn->query($sql_nivel);

// Obtener los grados
$sql_grado = "SELECT id_grado, nombre_grado FROM grado";
$result_grado = $conn->query($sql_grado);

// Obtener los campos formativos
$sql_campo_formativo = "SELECT id_campo_formativo, nombre_campo_formativo FROM campo_formativo";
$result_campo_formativo = $conn->query($sql_campo_formativo);

// Cerrar la conexión
$conn->close();
?>

<h5>Capturar Contenido y Relacionar con PDA</h5>

<form action="insertar_contenido.php" method="POST">
    <!-- Selección de Nivel -->
    <label for="nivel">Nivel:</label><BR>
    <select name="nivel" id="nivel" required>
        <option value="">--Seleccionar Nivel--</option>
        <?php
        if ($result_nivel->num_rows > 0) {
            while($row = $result_nivel->fetch_assoc()) {
                echo "<option value='" . $row['id_nivel'] . "'>" . $row['nombre_nivel'] . "</option>";
            }
        }
        ?>
    </select>
    <br><br>

    <!-- Selección de Grado -->
    <label for="grado">Grado:</label><BR>
    <select name="grado" id="grado" required>
        <option value="">--Seleccionar Grado--</option>
        <?php
        if ($result_grado->num_rows > 0) {
            while($row = $result_grado->fetch_assoc()) {
                echo "<option value='" . $row['id_grado'] . "'>" . $row['nombre_grado'] . "</option>";
            }
        }
        ?>
    </select>
    <br><br>

    <!-- Selección de Campo Formativo -->
    <label for="campo_formativo">Campo Formativo:</label><BR>
    <select name="campo_formativo" id="campo_formativo" required>
        <option value="">--Seleccionar Campo Formativo--</option>
        <?php
        if ($result_campo_formativo->num_rows > 0) {
            while($row = $result_campo_formativo->fetch_assoc()) {
                echo "<option value='" . $row['id_campo_formativo'] . "'>" . $row['nombre_campo_formativo'] . "</option>";
            }
        }
        ?>
    </select>
    <br><br>

    <!-- Nombre del Contenido -->
    <label for="nombre_contenido">Nombre del Contenido:</label><BR>
    <textarea id="nombre_contenido" name="nombre_contenido" rows="4" cols="100" required></textarea>
    <br><br>

    <!-- Fecha de Creación -->
    <label for="fecha_creacion">Fecha de Creación:</label>
    <input type="date" name="fecha_creacion" id="fecha_creacion" required>
    <br><br>

    <!-- Relacionar hasta 7 PDAs -->
    <h3>Agregar hasta 7 PDA</h3>
    <div id="pda_fields">
        <label for="pda_1">PDA 1:</label><BR>
        <textarea id="pda_1" name="pda_1" rows="4" cols="100" required></textarea>
        <br><br>
    </div>
    <button type="button" id="add_pda_button">Agregar más PDA</button>
    <br><br>

    <button type="submit">Guardar Contenido</button>
</form>

<script>
let pdaCount = 1;

document.getElementById('add_pda_button').onclick = function() {
    if (pdaCount < 7) {
        pdaCount++;
        const pdaDiv = document.createElement('div');
        pdaDiv.innerHTML = `<label for="pda_${pdaCount}">PDA ${pdaCount}:</label><BR>
                            <textarea id="pda_${pdaCount}" name="pda_${pdaCount}" rows="4" cols="100" required></textarea>
                            <br><br>`;
        document.getElementById('pda_fields').appendChild(pdaDiv);
    }
};
</script>



        <!-- <div>
         <p>
         <form action="alta_contenido.php" method="post" >
          <div class="container-fluid">
            <h5>Alta de Contenido</h5>
            <label for="nombre_contenido">Nombre del contenido:</label><br>
            <textarea id="nombre_contenido" name="nombre_contenido" rows="4" cols="100" required></textarea><br><br>
            <label for="fecha_creacion">Fecha de creación:</label><br>
            <input type="date" id="fecha_creacion" name="fecha_creacion" required><br><br>
            <label for="codigo_unico_contenido">Código de Referencia:</label><br>
            <input type="text" id="codigo_unico_contenido" name="codigo_unico_contenido" required><br><br>
            <label for="observacion">Observación:</label><br>
            <textarea id="observacion" name="observacion" rows="3" cols="80"></textarea><br><br>
            <input type="submit" name="alta_contenido" value="Dar de Alta Contenido"><br><br>
          </div> 
         </form>
       </div>   fin de row 1 --> 

      
      </div>
     </div>
    </main>
    
 </div>
</div>

<footer class="py-4 bg-light mt-auto">
  <?php
   include ("../footer_sys.php");
    //mysqli_free_result($resultado);
  ?>
</footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="../js/scripts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="../assets/demo/chart-area-demo.js"></script>
  <script src="../assets/demo/chart-bar-demo.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
  <script src="../assets/demo/datatables-demo.js"></script>

<?php

?>
    
<script src="https://code.jquery.com/jquery-2.2.2.min.js"></script> 
<!-- jQuery 3 -->
<script src="../ajax/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../ajax/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

</body>
</html>


    <!-- <script>
        $(document).ready(function() {
            $("#contenido").change(function() {
                var contenidoId = $(this).val();
                if (contenidoId !== "") {
                    $.ajax({
                        url: "get_pda.php",
                        type: "POST",
                        data: { contenido_id: contenidoId },
                        success: function(data) {
                            $("#pda").html(data);
                        }
                    });
                } else {
                    $("#pda").html('<option value="">Seleccione un contenido primero...</option>');
                }
            });
        });
    </script> -->




