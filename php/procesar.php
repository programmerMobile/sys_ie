<?php
include('clases.php');
include('validar.php');
include('../conexion.php');


function ProcesarDatosDeAlumno()
{
    $Alumnos = new ArrayObject();
    $mysqli = Db::conectar();
    $comando = "insert into alumnos (email, nombre, carnet, edad, curso, foto) values (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($comando);

    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $carnet = $_POST['carnet'];
    $edad = $_POST['edad'];
    $curso = $_POST['curso'];
    $foto = $_FILES['foto']['name'];
    $fotoRuta = "";

    $errores = array();
    $opciones_edad = array(
        'options' => array(
            'min_range' => 15,
            'max_range' => 50
        )
    );

    $opciones_curso = array(
        'options' => array(
            'min_range' => 1,
            'max_range' => 5
        )
    );

    if (!validarTexto($nombre)) {
        $errores = "Ingrese correctamente su nombre";
    }

    if (!validarTexto($carnet)) {
        $errores = "Ingrese correctamente el carnet";
    }

    if (!validarEmail($email)) {
        $errores = "Ingrese correctamente su correo";
    }

    if (!validarEntero($edad, $opciones_edad)) {
        $errores = "Ingrese correctamente su edad";
    }

    if (!validarEntero($curso, $opciones_curso)) {
        $errores = "Ingrese correctamente el curso";
    }


    foreach ($errores as $error) {
        print("Error: $error");
    }

    if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
        $nombreDirectorio = "../img/";
        $idUnico = time();
        $nombreFichero = $idUnico . "-" . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], $nombreDirectorio . $nombreFichero);
        $fotoRuta = $nombreFichero;
    } else
        print("No se ha podido subir el fichero\n");

    // $alumno = new Alumno($email, $nombre, $carnet, $edad, $curso, $fotoRuta);

    $stmt->bind_param("sssiis", $email, $nombre, $carnet, $edad, $curso, $fotoRuta);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();

    header('Location:../index.php');
}

function ProcesarDatosProfesor()
{
    $Profesores = new ArrayObject();
    $mysqli = Db::conectar();
    $comando = "insert into profesores values (?, ?, ?, ?)";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($comando);

    $clave = $_POST['clave'];
    $nombre = $_POST['nombre'];
    $ecivil = $_POST['estado-civil'];
    $cv = $_POST['curriculum'];
    $cvRuta = '';
    $errores = array();


    if (!validarTexto($nombre)) {
        $errores = "Ingrese correctamente su nombre";
    }

    if (is_uploaded_file($_FILES['curriculum']['tmp_name'])) {
        $nombreDirectorio = "../cv/";
        $idUnico = time();
        $nombreFichero = $idUnico . "-" . $_FILES['curriculum']['name'];
        move_uploaded_file($_FILES['curriculum']['tmp_name'], $nombreDirectorio . $nombreFichero);
        $cvRuta = $nombreFichero;
    } else
        print("No se ha podido subir el fichero\n");

    // $profesor = new Profesor($clave, $nombre, $ecivil, $cvRuta);

    $stmt->bind_param("ssss", $clave, $nombre, $ecivil, $cvRuta);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
    
    header('Location:../index.php');
}

function ProcesarDatosAula()
{
    $Aulas = new ArrayObject();
    
    $mysqli = Db::conectar();
    $comando = "insert into aulas values(?, ?)";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($comando);

    $naula = $_POST['numero-aula'];
    $cap = $_POST['capacidad'];
    $errores = array();

    $opciones_capacidad = array(
        'options' => array(
            'min_range' => 1,
            'max_range' => 50
        )
    );

    if (!validarTexto(naula)) {
        $errores = "Ingrese correctamente el numero de aula";
    }

    if (!validarEntero($cap, $opciones_capacidad)) {
        $errores = "Ingrese correctamente la capacidad del aula";
    }

    // $aula = new Aula($naula, $cap);

    $stmt->bind_param("ss", $naula, $cap);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();

    header('Location:../index.php');
}

// validacion de Alumno 
if (isset($_POST['submit-alumno']))
    ProcesarDatosDeAlumno();

// Validacion de Profesor
if (isset($_POST['submit-profesor']))
    ProcesarDatosProfesor();

// Validacion de Aula
if (isset($_POST['submit-aula']))
    ProcesarDatosAula();
