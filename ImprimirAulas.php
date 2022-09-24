<?php
include('./model/head.php');
?>


<?php
$mysqli = Db::conectar();
$comando = "select * from aulas";
$result = $mysqli->query($comando);
?>

<div class="container">
    <?php if ($result->num_rows > 0) : ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Numero de aula</th>
                    <th scope="col">Capacidad</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($aula = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php print($aula['numero_aula']); ?></td>
                        <td><?php print($aula['capacidad']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    <?php else : ?>
        <p class="lead"> No hay datos de aulas para mostrar </p>
    <?php endif; ?>
</div>