<?php
include ("conn.php");

if(isset($_GET["accion"])){
    $accion = $_GET["accion"];

    if($accion =="leer"){

        $sql = "select * from alumnos where 1";
        $result =$db->query($sql);

        if($result->num_rows>0){
            while($fila = $result-> fetch_assoc()){
                $item["id"]=$fila ["id"];
                $item["nombres"]=$fila ["nombres"];
                $item["apellido_paterno"]=$fila ["apellido_paterno"];
                $item["apellido_mateno"]=$fila ["apellido_mateno"];
                $arrAlumnos[]= $item;





            }
            $response["status"]= "ok";
            $response["mensaje"]= $arrAlumnos;
            

        } else{
            $response["status"] = "Error";
            $response["mensaje"] = "No hay alumnos registrados";
        }
        
    }
    echo json_encode($response);
}