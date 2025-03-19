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

// Verificar que el formulario se haya enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del contenido
    $nombre_contenido = $_POST['nombre_contenido'];
    $fecha_creacion = $_POST['fecha_creacion'];
    $id_nivel = $_POST['nivel'];
    $id_grado = $_POST['grado'];
    $id_campo_formativo = $_POST['campo_formativo'];

    // Insertar en la tabla contenido
    $sql_contenido = "INSERT INTO contenido (nombre_contenido, fecha_creacion, id_nivel, id_grado, id_campo_formativo)
                      VALUES (?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql_contenido)) {
        $stmt->bind_param("ssiii", $nombre_contenido, $fecha_creacion, $id_nivel, $id_grado, $id_campo_formativo);
        $stmt->execute();
        $id_contenido = $stmt->insert_id;
        $stmt->close();
    } else {
        die("Error al insertar el contenido: " . $conn->error);
    }

    // Insertar los PDAs si existen
    for ($i = 1; $i <= 7; $i++) {
        if (!empty($_POST["pda_$i"])) {
            $nombre_pda = $_POST["pda_$i"];
            $fecha_alta = date("Y-m-d");

            $sql_pda = "INSERT INTO pda (nombre_pda, fecha_alta, id_contenido) VALUES (?, ?, ?)";
            if ($stmt = $conn->prepare($sql_pda)) {
                $stmt->bind_param("ssi", $nombre_pda, $fecha_alta, $id_contenido);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    echo "Contenido y PDA(s) insertados correctamente.";
     // Verifica si existe la variable HTTP_REFERER
     if (!empty($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']); 
     exit;
     } else {
     // Si no hay un referer, redirige a una página por defecto
     header("Location: contenido.php"); 
     exit;
     }
}

// Cerrar la conexión
$conn->close();
?>
