<?php
include("./model/head.php"); 
include('./model/encabezado.php');
?>

<div class="container my-5">

    <!-- Formulario Alumnos -->
    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne">
                        Formulario de alumnos
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                <div class="card-body">
                    <?php include('./model/Alumno.php') ?>
                </div>
            </div>
        </div>

        <!-- Formulario Profesores -->
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo">
                        Formulario de profesores
                    </button>
                </h2>
            </div>
            <div id="collapseTwo" class="collapse" data-parent="#accordionExample">
                <div class="card-body">
                    <?php include('./model/Profesor.php') ?>
                </div>
            </div>
        </div>

        <!-- Formulario Aulas -->
        <div class="card">
            <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree">
                        Formulario de aulas
                    </button>
                </h2>
            </div>
            <div id="collapseThree" class="collapse" data-parent="#accordionExample">
                <div class="card-body">
                    <?php include('./model/Aula.php') ?>
                </div>
            </div>
        </div>

        <div class="card">

            <div class="card-header" id="headingFour">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour">
                        Listado de alumnos, profesores y aulas
                    </button>
                </h2>
            </div>

            <div id="collapseFour" class="collapse" data-parent="#accordionExample">
                <div class="card-body">

                    <a class="btn btn-outline-dark my-3" href="./MostrarDatosIngresados.php" role="button"> Ver listados </a>

                </div>
            </div>

        </div>

    </div>


</div> <!-- .container -->

<?php include('./model/final.php') ?>