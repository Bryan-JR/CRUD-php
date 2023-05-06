<?php


try {
    //$mbd = new PDO('mysql:host=localhost;dbname=personas', 'root', 'AdminRoot123');
    $mbd = new PDO('mysql:host=localhost;dbname=personas', 'root', 'Qwe.123');
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

try 
{    
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Código para procesar una solicitud GET
        if(isset($_GET["id"])){
            $persona=$mbd->prepare('SELECT * FROM persona WHERE Identificacion = ?');
            $persona->bindParam(1, $_GET['id']);
            $persona->execute();
            $result = $persona->fetch(PDO::FETCH_ASSOC);
            header('Content-type:application/json;charset=utf-8');    
            echo json_encode([
                "persona"=>$result
            ]);
        } else {
            $generos=$mbd->prepare('SELECT * FROM genero');
            $generos->execute();        
            $resultadoGen = $generos->fetchAll(PDO::FETCH_ASSOC);
            $programa=$mbd->prepare('SELECT * FROM programa');
            $programa->execute();        
            $resultadoPro = $programa->fetchAll(PDO::FETCH_ASSOC);
            $personas=$mbd->prepare('SELECT Identificacion, nombre, email, fecha_na, (SELECT G.genero FROM genero G WHERE G.idGenero = P.idGenero) as genero,(SELECT Pr.programa FROM programa Pr WHERE Pr.idPrograma = P.idPrograma) as programa, observaciones FROM persona P');
            $personas->execute();        
            $resultadoPer = $personas->fetchAll(PDO::FETCH_ASSOC);
            header('Content-type:application/json;charset=utf-8');    
            echo json_encode([
                "generos"=>$resultadoGen,
                "programas"=>$resultadoPro,
                "personas"=>$resultadoPer
            ]);
        }
        
        
    }
    
    elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Creamos una sentencia preparada
        $statement=$mbd->prepare("INSERT INTO persona (Identificacion, nombre, email, fecha_na, idGenero, idPrograma, observaciones) VALUES (:ide, :nom, :ema, :fnac, :gen, :prog, :obs)");

        // Asociamos los parametros de la consulta a las variables de los datos
        $statement->bindParam(':ide', $identificacion);
        $statement->bindParam(':nom', $nombre);
        $statement->bindParam(':ema', $email);    
        $statement->bindParam(':fnac', $fecha_nac);
        $statement->bindParam(':gen', $genero);
        $statement->bindParam(':prog', $programa);
        $statement->bindParam(':obs', $observaciones);    

        // Asignamos los datos de las variables
        $identificacion = $data['identificacion'];
        $nombre         = $data['nombre'];
        $email          = $data['email'];
        $fecha_nac      = $data['fecha_nac'];
        $genero         = $data['genero'];
        $programa       = $data['programa'];
        $observaciones  = $data['observaciones'];

        // Insertar
        $statement->execute();
    
        // Retornamos resultados
        header('Content-type:application/json;charset=utf-8');    
        echo json_encode([
            'persona' => $data
        ]);
    }
    
    elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $statement=$mbd->prepare("UPDATE persona SET Identificacion = :ide, nombre = :nom, email = :ema, fecha_na = :fnac, idGenero = :gen, idPrograma = :prog, observaciones = :obs WHERE Identificacion = :ide");

        // Asociamos los parametros de la consulta a las variables de los datos
        $statement->bindParam(':ide', $identificacion);
        $statement->bindParam(':nom', $nombre);
        $statement->bindParam(':ema', $email);    
        $statement->bindParam(':fnac', $fecha_nac);
        $statement->bindParam(':gen', $genero);
        $statement->bindParam(':prog', $programa);
        $statement->bindParam(':obs', $observaciones);    

        // Asignamos los datos de las variables
        $identificacion = $data['identificacion'];
        $nombre         = $data['nombre'];
        $email          = $data['email'];
        $fecha_nac      = $data['fecha_nac'];
        $genero         = $data['genero'];
        $programa       = $data['programa'];
        $observaciones  = $data['observaciones'];

        // Insertar
        $statement->execute();
    
        // Retornamos resultados
        header('Content-type:application/json;charset=utf-8');    
        echo json_encode([
            'persona' => $data
        ]);
    }
    
    elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        // Código para procesar una solicitud DELETE
        $persona=$mbd->prepare('DELETE FROM persona WHERE Identificacion = ?');
        $persona->bindParam(1, $_GET['id']);
        $persona->execute(); 
        echo "Borrado";
    }

} catch (PDOException $e) {
    header('Content-type:application/json;charset=utf-8');    
    echo json_encode([
        'error' => [
            'codigo' =>$e->getCode() ,
            'mensaje' => $e->getMessage()
        ]
    ]);
}







