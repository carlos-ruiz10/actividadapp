<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// Obtener todos los estudiantes
$app->get('/api/estudiantes', function(Request $request, Response $response){

	//echo "Estudiantes";
	$sql = "select * from estudiante";
	try{
		// Obtener el objeto DB 
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->query($sql);
        $estudiantes = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($estudiantes);

	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener un estudiante por no de control
$app->get('/api/estudiantes/{n_control}', function(Request $request, Response $response){
    $n_control = $request->getAttribute('n_control');
    $sql = "SELECT * FROM estudiante WHERE n_control = $n_control";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->query($sql);
        $estudiante = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($estudiante);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un estudiante
$app->post('/api/estudiantes/add', function(Request $request, Response $response){
    $n_control = $request->getParam('n_control');
    $nombre = $request->getParam('nombre');
    $apellidop = $request->getParam('apellidop');
    $apellidom = $request->getParam('apellidom');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');
    $sql = "INSERT INTO estudiante (n_control, nombre_estudiante, a_paterno_e, a_materno_e, semestre, carrera_clave) VALUES (:n_control, :nombre, :apellidop, :apellidom, :semestre, :carrera_clave)";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':n_control',      $n_control);
        $stmt->bindParam(':nombre',         $nombre);
        $stmt->bindParam(':apellidop',      $apellidop);
        $stmt->bindParam(':apellidom',      $apellidom);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave',  $carrera_clave);
        $stmt->execute();
        echo '{"notice": {"text": "Estudiante agregado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar estudiante
$app->put('/api/estudiantes/update/{n_control}', function(Request $request, Response $response){
    $n_control = $request->getParam('n_control');
    $nombre = $request->getParam('nombre');
    $apellidop = $request->getParam('apellidop');
    $apellidom = $request->getParam('apellidom');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');
    $sql = "UPDATE estudiante SET
                n_control               = :n_control,
                nombre_estudiante       = :nombre,
                a_paterno_e             = :apellidop,
                a_materno_e             = :apellidom,
                semestre                = :semestre,
                carrera_clave           = :carrera_clave
            WHERE n_control = $n_control";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':n_control',      $n_control);
        $stmt->bindParam(':nombre',         $nombre);
        $stmt->bindParam(':apellidop',      $apellidop);
        $stmt->bindParam(':apellidom',      $apellidom);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave',  $carrera_clave);
        $stmt->execute();
        echo '{"notice": {"text": "Estudiante actualizado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Borrar estudiante
$app->delete('/api/estudiantes/delete/{n_control}', function(Request $request, Response $response){
    $n_control = $request->getAttribute('n_control');
    $sql = "DELETE FROM estudiante WHERE n_control = $n_control";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Estudiante eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//-------------------------------------------------------------------------------------------
//CARRERA

// Obtener todas las carreras
$app->get('/api/carrera', function(Request $request, Response $response){
    //echo "materias";
    $sql = "select * from carrera";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $carrera = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
      //  echo json_encode($carrera);
      print_r($carrera);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener una carrera por clave
$app->get('/api/carrera/{clave_carrera}', function(Request $request, Response $response){
    $clave_carrera = $request->getAttribute('clave_carrera');
    $sql = "SELECT * FROM carrera WHERE clave_carrera = '".$clave_carrera."'";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->query($sql);
        $carreras = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //echo json_encode($carrera);
        print_r($carreras);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar una carrera
$app->post('/api/carrera/add', function(Request $request, Response $response){
    $clave = $request->getParam('clave');
    $nombre = $request->getParam('nombre');


    $sql = "INSERT INTO carrera (clave_carrera, nombre_carrera) VALUES (:clave, :nombre)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':clave',  $clave);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        echo '{"notice": {"text": "carrera agregada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Actualizar carrera
$app->put('/api/carrera/update/{clave_carrera}', function(Request $request, Response $response){
    $clave_carrera = $request->getParam('clave_carrera');
    $nombre = $request->getParam('nombre');
   
    $sql = "UPDATE carrera SET
                clave_carrera        = :clave_carrera,
                nombre_carrera       = :nombre
                
            WHERE clave_carrera = '".$clave_carrera."'";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':clave_carrera',   $clave_carrera);
        $stmt->bindParam(':nombre',          $nombre);
        $stmt->execute();
        echo '{"notice": {"text": "Carrera actualizada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar carrera
$app->delete('/api/carrera/delete/{clave_carrera}', function(Request $request, Response $response){
    $clave_carrera = $request->getAttribute('clave_carrera');

    $sql = "DELETE FROM carrera WHERE clave_carrera = '".$clave_carrera."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Carrera eliminada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


//--------------------------------------------------------------------------------------------------------
//DEPARTAMENTO

// Obtener todos los departamentos
$app->get('/api/departamento', function(Request $request, Response $response){

    $sql = "select * from departamento";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->query($sql);
        $departamento = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
      //  echo json_encode($departamento);
      print_r($departamento);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener un departamento por clave
$app->get('/api/departamento/{rfc_dep}', function(Request $request, Response $response){
    $rfc_dep = $request->getAttribute('rfc_dep');
    $sql = "SELECT * FROM departamento WHERE rfc_dep = '".$rfc_dep."'";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->query($sql);
        $departamento = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($departamento);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un departamento
$app->post('/api/departamento/add', function(Request $request, Response $response){
    $rfc_dep = $request->getParam('rfc_dep');
    $nombre = $request->getParam('nombre');
        $trabajador_rfc = $request->getParam('trabajador_rfc');


    $sql = "INSERT INTO departamento (rfc_dep, nombre_dep, trabajador_rfc) VALUES (:rfc_dep, :nombre, :trabajador_rfc)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':rfc_dep', $rfc_dep);
        $stmt->bindParam(':nombre',  $nombre);
        $stmt->bindParam(':trabajador_rfc',$trabajador_rfc);
        $stmt->execute();
        echo '{"notice": {"text": "Departamento agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar departamento
$app->put('/api/departamento/update/{rfc_dep}', function(Request $request, Response $response){
    $rfc_dep = $request->getParam('rfc_dep');
    $nombre = $request->getParam('nombre');
        $trabajador_rfc=$request->getParam('trabajador_rfc');

    $sql = "UPDATE departamento SET
                rfc_dep        = :rfc_dep,
                nombre_dep     = :nombre,
                trabajador_rfc = :trabajador_rfc

            WHERE rfc_dep = '".$rfc_dep."'";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':rfc_dep',   $rfc_dep);
        $stmt->bindParam(':nombre',    $nombre);
        $stmt->bindParam(':trabajador_rfc',  $trabajador_rfc);
        $stmt->execute();

        echo '{"notice": {"text": "Departamento actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar departamento
$app->delete('/api/departamento/delete/{rfc_dep}', function(Request $request, Response $response){
    $rfc_dep = $request->getAttribute('rfc_dep');

    $sql = "DELETE FROM departamento WHERE rfc_dep = '".$rfc_dep."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Departamento eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//----------------------------------------------------------------------------------------------------
//INSTITUTO

// Obtener todos los institutos
$app->get('/api/instituto', function(Request $request, Response $response){
    //echo "instituto";
    $sql = "select * from instituto";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->query($sql);
        $institu = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //  echo json_encode($institu);
        print_r($institu);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Obtener un instituto por clave
$app->get('/api/instituto/{clave}', function(Request $request, Response $response){
    $clave = $request->getAttribute('clave');

    $sql = "SELECT * FROM instituto WHERE clave = '".$clave."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->query($sql);
        $instituto = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($instituto);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un instituto
$app->post('/api/instituto/add', function(Request $request, Response $response){
    $clave = $request->getParam('clave');
    $nombre_instituto = $request->getParam('nombre_instituto');

    $sql =  "INSERT INTO instituto (clave, nombre) VALUES (:clave, :nombre_instituto)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':clave',                    $clave);
        $stmt->bindParam(':nombre_instituto',         $nombre_instituto);
        $stmt->execute();
        echo '{"notice": {"text": "instituto agregado"}';

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Actualizar instituto
$app->put('/api/instituto/update/{clave}', function(Request $request, Response $response){
    $clave = $request->getParam('clave');
    $nombre_instituto = $request->getParam('nombre_instituto');

    $sql = "UPDATE instituto SET
                clave                  = :clave,
                nombre                 = :nombre_instituto
                                
            WHERE clave = '".$clave."'";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':clave',   $clave);
        $stmt->bindParam(':nombre_instituto',  $nombre_instituto);
        $stmt->execute();
        echo '{"notice": {"text": "Instituto actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Borrar instituto
$app->delete('/api/instituto/delete/{clave}', function(Request $request, Response $response){
    $clave = $request->getAttribute('clave');

    $sql = "DELETE FROM instituto WHERE clave = '".$clave."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Instituto eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//-------------------------------------------------------------------------------------------------------
//TRABAJADOR

//todos los trabajadores
$app->get('/api/trabajador', function(Request $request, Response $response){
    //echo "trabajador";
    $sql = "select * from trabajador";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->query($sql);
        $trabajador = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //  echo json_encode($trabajador);
        print_r($trabajador);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener un trabajador por RFC
$app->get('/api/trabajador/{rfc_tra}', function(Request $request, Response $response){
    $rfc_tra = $request->getAttribute('rfc_tra');

    $sql = "SELECT * FROM trabajador WHERE rfc_tra = '".$rfc_tra."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->query($sql);
        $trabajador = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($trabajador);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un trabajador
$app->post('/api/trabajador/add', function(Request $request, Response $response){
    $rfc_tra = $request->getParam('rfc_tra');
    $nombre_trabajador = $request->getParam('nombre_trabajador');
    $apellido_p = $request->getParam('apellido_p');
    $apellido_m = $request->getParam('apellido_m');
    $clave_presupuestal = $request->getParam('clave_presupuestal');

    $sql =  "INSERT INTO trabajador (rfc_tra, nombre_tra,a_paterno_tra,a_materno_tra,clave_presupuestal) VALUES (:rfc_tra,:nombre_trabajador,:apellido_p,:apellido_m,:clave_presupuestal)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':rfc_tra',          $rfc_tra);
        $stmt->bindParam(':nombre_trabajador',       $nombre_trabajador);
        $stmt->bindParam(':apellido_p',              $apellido_p);
        $stmt->bindParam(':apellido_m',              $apellido_m);
        $stmt->bindParam(':clave_presupuestal',      $clave_presupuestal);
        $stmt->execute();
        echo '{"notice": {"text": "Trabajador agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Actualizar trabajador
$app->put('/api/trabajador/update/{rfc_tra}', function(Request $request, Response $response){
    $rfc_tra = $request->getParam('rfc_tra');
    $nombre_trabajador = $request->getParam('nombre_trabajador');
    $apellido_p = $request->getParam('apellido_p');
    $apellido_m = $request->getParam('apellido_m');
    $clave_presupuestal = $request->getParam('clave_presupuestal');

    $sql = "UPDATE trabajador SET
           rfc_tra                   = :rfc_tra,
           nombre_tra                = :nombre_trabajador,
           a_paterno_tra             = :apellido_p,
           a_materno_tra             = :apellido_m,
           clave_presupuestal        = :clave_presupuestal
                                
            WHERE rfc_tra = '".$rfc_tra."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':rfc_tra',            $rfc_tra);
        $stmt->bindParam(':nombre_trabajador',  $nombre_trabajador);
        $stmt->bindParam(':apellido_p',         $apellido_p);
        $stmt->bindParam(':apellido_m',         $apellido_m);
        $stmt->bindParam(':clave_presupuestal', $clave_presupuestal);
        $stmt->execute();

        echo '{"notice": {"text": "Trabajor actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar trabajador
$app->delete('/api/trabajador/delete/{rfc_tra}', function(Request $request, Response $response){
    $rfc_tra = $request->getAttribute('rfc_tra');

    $sql = "DELETE FROM trabajador WHERE rfc_tra = '".$rfc_tra."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Trabajador eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//-------------------------------------------------------------------------------------------------------
//ACTIVIDADES COMPLEMENTARIAS

// Obtener todas las actividades
$app->get('/api/actividad', function(Request $request, Response $response){

    $sql = "select * from actividad_comp";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $carrera = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
      //  echo json_encode($carrera);
      print_r($carrera);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener una actividad por clave
$app->get('/api/actividad/{clave_act}', function(Request $request, Response $response){
    $clave_act = $request->getAttribute('clave_act');
    $sql = "SELECT * FROM actividad_comp WHERE clave_act = '".$clave_act."'";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->query($sql);
        $carreras = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //echo json_encode($carrera);
        print_r($carreras);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar una actividad
$app->post('/api/actividad/add', function(Request $request, Response $response){
    $clave = $request->getParam('clave');
    $nombre = $request->getParam('nombre');


    $sql = "INSERT INTO actividad_comp (clave_act, nombre_act) VALUES (:clave, :nombre)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':clave',  $clave);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        echo '{"notice": {"text": "Actividad agregada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Actualizar Actividad
$app->put('/api/actividad/update/{clave_act}', function(Request $request, Response $response){
    $clave_act = $request->getParam('clave_act');
    $nombre = $request->getParam('nombre');
   
    $sql = "UPDATE actividad_comp SET
                clave_act            = :clave_act,
                nombre_act           = :nombre
                
            WHERE clave_act = '".$clave_act."'";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':clave_act',   $clave_act);
        $stmt->bindParam(':nombre',          $nombre);
        $stmt->execute();
        echo '{"notice": {"text": "Actividad actualizada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar actividad
$app->delete('/api/actividad/delete/{clave_act}', function(Request $request, Response $response){
    $clave_act = $request->getAttribute('clave_act');

    $sql = "DELETE FROM actividad_comp WHERE clave_act = '".$clave_act."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Actividad eliminada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});