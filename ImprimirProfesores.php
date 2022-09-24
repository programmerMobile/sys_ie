<?php
include_once('./model/head.php');
// include('./model/includes.php');
include_once('./conexion.php');
?>

<?php
$mysqli = Db::conectar();

if (isset($_POST['submitEditar'])) {

    $nombreFichero = "";
    if (is_uploaded_file($_FILES["curriculum-nuevo"]["tmp-name"])) {
        $directorio = "./img";
        $idUnico = time();
        $nombreFichero = $idUnico . "-" . $_FILES['curriculum-vitae']['tmp-name'];
        move_uploaded_file($_FILES['curriculum-vitae']['tmp-name'], $directo . $nombreFichero);
    } else {
        $nombreFichero = $_POST['curriculum-antiguo'];
    }

    $comando = "update profesores set clave='" . $_POST['clave'] . "', nombre ='" . $_POST['nombre']
        . "', estado_civil = '" . $_POST['estado_civil'] . "', curriculum ='" . $nombreFichero
        . "' where clave =" . $_POST['clave'];

    $stmt = $mysqli->stmt_init();
    $stmt->prepare($comando);
    $stmt->execute();
    $stmt->close();
}

if(isset($_POST['submitEliminar'])) {
    
    $comando = "delete from profesores where clave = '". $_POST['clave'] . "'"; 
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($comando);
    $stmt->execute();
    $stmt->close();
}

?>


<?php

$comando = "select * from profesores";
$result = $mysqli->query($comando);
$mysqli->close();

?>

<div class="container">

    <?php if ($result->num_rows > 0) : ?>


        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Clave</th>
                    <th scope="col">Nombre completo</th>
                    <th scope="col">Estado civil</th>
                    <th scope="col">Curriculum</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($profesor = $result->fetch_array()) : ?>
                    <input type="text" name="" id="campoEstado" value="<?php print $profesor['estado_civil'] ?>" hidden>

                    <form action="./ImprimirProfesores.php" method="post" id="formEliminar">

                        <tr>
                            <input type="text" name="clave" value="<?php print($profesor['clave']); ?>" id="" hidden>
                            <td><?php print($profesor['clave']); ?></td>
                            <td><?php print($profesor['nombre']); ?></td>
                            <td><?php print($profesor['estado_civil']) ?></td>
                            <td class="curriculum" style="height: 500px;" id="curriculum">
                                <embed src="./cv/<?php echo ($profesor['curriculum']); ?>" type="application/pdf" width="100%" height="100%">
                            </td>
                            <td class="d-flex flex-column">
                                <button type="button" class="btn btn-outline-success mt-4" data-toggle="modal" data-target="#exampleModal">Editar</button>
                                <button type="submit" class="btn btn-outline-danger mt-3" name="submitEliminar">Eliminar</button>
                            </td>
                        </tr>
                    </form>

                    <!-- Modal/Editar -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">

                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <form action="./ImprimirProfesores.php" method="POST" id="formEditar">
                                                <div class="form-group">
                                                    <!-- <label for="clave">Clave</label> -->
                                                    <input type="text" class="form-control" id="clave" name="clave" pattern=".{1,6}" value="<?php print $profesor['clave'] ?>" hidden>
                                                </div>

                                                <div class="form-group">
                                                    <label for="nombre">Nombre completo</label>
                                                    <input type="text" class="form-control" id="nombre" name="nombre" pattern=".{2,200}" value="<?php print $profesor['nombre'] ?>" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="estado-civil">Estado civil </label>
                                                    <select class="form-control" name="estado-civil" id="estado-civil" required>
                                                        <option> <?php print $profesor['estado_civil'] ?> </option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="curriculum"> Curriculum vitae </label>
                                                    <input type="text" name="curriculum-antiguo" value="<?php print $profesor['curriculum'] ?>" hidden>
                                                    <input type="file" class="form-control" id="curriculum" name="curriculum-nuevo" placeholder="Agregar curriculum">
                                                </div>
                                            </form>
                                        </div> <!-- .col -->
                                    </div> <!-- .row -->
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" form="formEditar" name="submitEditar"> Realizar modificaciones </button>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p class="lead"> No hay datos de profesores para mostrar </p>
    <?php endif; ?>
</div>

<script>
    let dato = document.getElementById("campoEstado").value;
    document.getElementById("exampleModalLabel").innerHTML = dato;
</script>