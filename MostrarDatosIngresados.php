<?php
    include('./model/head.php');
    include('./model/encabezado.php');
    include('./php/clases.php');
    include('./conexion.php');
?>

<style>

    .volver {
        position: absolute;
        left: 10%;
        top: 20%;
    }

</style>

<button type="button" id="btn-volver" class="btn btn-outline-dark volver"><- Volver</button>

<div class="container">
    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Listar los alumnos
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body ">
                    <?php include("./ImprimirAlumnos.php"); ?>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Listar los profesores
                    </button>
                </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    <?php include("./ImprimirProfesores.php"); ?>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Listar las Aulas
                    </button>
                </h2>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                    <?php include("./ImprimirAulas.php"); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let btnVolver = document.getElementById("btn-volver");
    btnVolver.addEventListener("click", () => {
        location.href = "./index.php";
    });
</script>

<?php include('./model/final.php'); ?>