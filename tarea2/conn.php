<?php

// Conexión a la base de datos
$servername = "localhost";
$username = "username1";
$password = "password";
$dbname = "control";

$conn = new mysqli($servername, $username, $password, $dbname);

// Chequeo de conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// CRUD para la tabla autos

if(isset($_GET["accion"])){
    $accion = $_GET["accion"];

    if($accion == "leer_autos"){
        $sql = "SELECT * FROM autos";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            $autos = array();
            while($row = $result->fetch_assoc()){
                $auto = array(
                    "id" => $row["id"],
                    "marca" => $row["marca"],
                    "modelo" => $row["modelo"],
                    "ano" => $row["ano"],
                    "no_serie" => $row["serie"]
                );
                $autos[] = $auto;
            }
            $response["status"] = "ok";
            $response["mensaje"] = $autos;
        } else{
            $response["status"] = "error";
            $response["mensaje"] = "No hay autos registrados.";
        }
    }

    if($accion == "crear_auto"){
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $ano = $_POST['ano'];
        $no_serie = $_POST['serie'];

        $sql = "INSERT INTO autos (marca, modelo, ano, serie) VALUES ('$marca', '$modelo', '$ano', '$serie')";

        if ($conn->query($sql) === TRUE) {
            $response["status"] = "ok";
            $response["mensaje"] = "Auto creado exitosamente.";
        } else {
            $response["status"] = "error";
            $response["mensaje"] = "Error al crear el auto: " . $conn->error;
        }
    }

    if($accion == "actualizar_auto"){
        parse_str(file_get_contents("php://input"), $_PUT);
        $auto_id = $_PUT['id'];
        $marca = $_PUT['marca'];
        $modelo = $_PUT['modelo'];
        $ano = $_PUT['ano'];
        $no_serie = $_PUT['serie'];

        $sql = "UPDATE autos SET marca='$marca', modelo='$modelo', ano='$ano', serie='$serie' WHERE id=$auto_id";

        if ($conn->query($sql) === TRUE) {
            $response["status"] = "ok";
            $response["mensaje"] = "Auto actualizado exitosamente.";
        } else {
            $response["status"] = "error";
            $response["mensaje"] = "Error al actualizar el auto: " . $conn->error;
        }
    }

    if($accion == "eliminar_auto"){
        $auto_id = $_GET['auto_id'];

        $sql = "DELETE FROM autos WHERE id=$auto_id";

        if ($conn->query($sql) === TRUE) {
            $response["status"] = "ok";
            $response["mensaje"] = "Auto eliminado exitosamente.";
        } else {
            $response["status"] = "error";
            $response["mensaje"] = "Error al eliminar el auto: " . $conn->error;
        }
    }
}

echo json_encode($response);


// CRUD para la tabla clientes
if(isset($_GET["accion"])){
    $accion = $_GET["accion"];

    if($accion == "leer"){
        $sql = "SELECT * FROM clientes";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            $clientes = array();
            while($row = $result->fetch_assoc()){
                $cliente = array(
                    "id" => $row["id"],
                    "nombre" => $row["nombre"],
                    "email" => $row["email"]
                );
                $clientes[] = $cliente;
            }
            $response["status"] = "ok";
            $response["mensaje"] = $clientes;
        } else{
            $response["status"] = "error";
            $response["mensaje"] = "No hay clientes registrados.";
        }
    }

    if($accion == "crear"){
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];

        $sql = "INSERT INTO clientes (nombre, email) VALUES ('$nombre', '$email')";

        if ($conn->query($sql) === TRUE) {
            $response["status"] = "ok";
            $response["mensaje"] = "Cliente creado exitosamente.";
        } else {
            $response["status"] = "error";
            $response["mensaje"] = "Error al crear el cliente: " . $conn->error;
        }
    }

    if($accion == "actualizar"){
        parse_str(file_get_contents("php://input"), $_PUT);
        $cliente_id = $_PUT['id'];
        $nombre = $_PUT['nombre'];
        $email = $_PUT['email'];

        $sql = "UPDATE clientes SET nombre='$nombre', email='$email' WHERE id=$cliente_id";

        if ($conn->query($sql) === TRUE) {
            $response["status"] = "ok";
            $response["mensaje"] = "Cliente actualizado exitosamente.";
        } else {
            $response["status"] = "error";
            $response["mensaje"] = "Error al actualizar el cliente: " . $conn->error;
        }
    }

    if($accion == "eliminar"){
        $cliente_id = $_GET['cliente_id'];

        $sql = "DELETE FROM clientes WHERE id=$cliente_id";

        if ($conn->query($sql) === TRUE) {
            $response["status"] = "ok";
            $response["mensaje"] = "Cliente eliminado exitosamente.";
        } else {
            $response["status"] = "error";
            $response["mensaje"] = "Error al eliminar el cliente: " . $conn->error;
        }
    }
}

echo json_encode($response);
;


// Endpoint para mostrar autos de un cliente específico
if(isset($_GET["accion"])){
    $accion = $_GET["accion"];

    if($accion == "mostrar_autos"){
        $cliente_id = $_GET['cliente_id'];
        
        $sql = "SELECT autos.* FROM autos
                INNER JOIN propietario_auto ON autos.id = propietario_auto.id_auto
                WHERE propietario_auto.id_cliente = $cliente_id";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            $autos = array();
            while($row = $result->fetch_assoc()){
                $auto = array(
                    "id" => $row["id"],
                    "marca" => $row["marca"],
                    "modelo" => $row["modelo"],
                    "ano" => $row["ano"],
                    "no_serie" => $row["no_serie"]
                );
                $autos[] = $auto;
            }
            $response["status"] = "ok";
            $response["mensaje"] = $autos;
        } else{
            $response["status"] = "error";
            $response["mensaje"] = "No hay autos registrados para este cliente.";
        }
    }
}

echo json_encode($response);


$conn->close();
?>
