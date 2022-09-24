<?php
include_once('./model/head.php');
include_once('conexion.php');
?>

<?php

$mysqli = Db::conectar();

if (isset($_POST['editar-alumno'])) {

    $fotoRuta = "";
    if (is_uploaded_file($_FILES['foto-actualizada']['tmp_name'])) {
        $nombreDirectorio = "./img/";
        $idUnico = time();
        $nombreFichero = $idUnico . "-" . $_FILES['foto-actualizada']['name'];
        move_uploaded_file($_FILES['foto-actualizada']['tmp_name'], $nombreDirectorio . $nombreFichero);
        $fotoRuta = $nombreFichero;
    } else
    {
        $fotoRuta = $_POST['foto-no-actualizada'];
    }
    

    $comando = "update alumnos set nombre='" . $_POST['nombre'] . "', carnet='" . $_POST['carnet'] . "', "
        . "email='" . $_POST['email'] . "', edad=" . $_POST['edad'] . ", curso=" . $_POST['curso']
        . ", foto='" . $fotoRuta . "' where id =" . $_POST['id'];
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($comando);
    $stmt->execute();

    header("Location:./MostrarDatosIngresados.php");
}

if(isset($_POST['eliminar-alumno'])) {
    $comando = "delete from alumnos where id=". $_POST['id'];
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($comando);
    $stmt->execute();
    $stmt->close();

    header("Location:./MostrarDatosIngresados.php");
}

?>
    <!-- Seleccion de todos los elementos -->
<?php


$comando = "select * from alumnos";
$result = $mysqli->query($comando);
$mysqli->close();
?>

<div class="container">

    <?php if ($result->num_rows > 0) : ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col"> Foto </th>
                    <th scope="col"> Nombre </th>
                    <th scope="col"> Carnet </th>
                    <th scope="col"> Edad </th>
                    <th scope="col"> Correo </th>
                    <th scope="col"> Curso </th>
                    <th scope="col"> Acciones </th>
                </tr>
            </thead>
            <tbody>

                <?php while ($alumno = $result->fetch_array()) : ?>

                    <!-- Formulario modal -->
                    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalScrollableTitle"> Alumno </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-10">
                                            <form action="./ImprimirAlumnos.php" method="post" id="formEditar" enctype="multipart/form-data">

                                                <input type="number" name="id" value="<?php print  $alumno['id'] ?>" hidden>
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" value="<?php print $alumno['email'] ?>" ? required>
                                                    <small id="emailHelp" class="form-text text-muted">Siempre se cuidadoso con tu correo electrónico</small>
                                                </div>

                                                <div class="form-group">
                                                    <label for="nombre">Nombre completo</label>
                                                    <input type="text" class="form-control" id="nombre" name="nombre" pattern="[A-Za-z]+{2,200}" value="<?php print $alumno['nombre'] ?>" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="carnet">Numero de carnet</label>
                                                    <input type="text" class="form-control" id="carnet" name="carnet" pattern=".{1,10}" value="<?php print $alumno['carnet'] ?>" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="edad">Edad</label>
                                                    <input type="number" class="form-control" id="edad" name="edad" min="15" max="50" value="<?php print $alumno['edad'] ?>" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="curso">Curso</label>
                                                    <input type="number" class="form-control" id="curso" name="curso" min="1" max="5" value="<?php print $alumno['curso'] ?>" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="foto">Foto</label>
                                                    <input type="file" class="form-control" id="foto" name="foto-actualizada">
                                                    <input type="text" name="foto-no-actualizada" value="<?php print $alumno['foto']?>" hidden>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="editar-alumno" class="btn btn-outline-success" form="formEditar"> Realizar cambios </button>
                                </div>

                            </div>
                        </div>
                    </div> <!-- modal -->

                    <form action="./ImprimirAlumnos.php" method="post" id="formEliminar">
                        <tr>
                            <input type="number" name="id" value="<?php print $alumno['id']?>" hidden>
                            <td> <img class="imagen-alumno" style="width: 200px;" src="./img/<?php print $alumno['foto'] ?>" alt=""> </td>
                            <td> <?php print $alumno['nombre']; ?> </td>
                            <td> <?php print $alumno['carnet']; ?> </td>
                            <td> <?php print $alumno['edad']; ?> </td>
                            <td> <?php print $alumno['email']; ?> </td>
                            <td> <?php print $alumno['curso']; ?> </td>

                            <td class="d-flex flex-column">
                                <button type="button" id="editar-alumno" class="btn btn-outline-success mt-4" data-toggle="modal" data-target="#exampleModalScrollable"> Editar </button>
                                <button type="submit" id="eliminar-alumno" name="eliminar-alumno" class="btn btn-outline-danger mt-3" form="formEliminar">Eliminar</button>
                            </td>
                        </tr>
                    </form>

                <?php endwhile; ?>
            </tbody>
        </table>

    <?php else : ?>
        <p class="lead"> No hay datos de alumnos para mostrar </p>

    <?php endif; ?>
</div>