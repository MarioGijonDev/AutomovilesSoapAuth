<!DOCTYPE html>
<html>
<head>
    <style>
        figure {
            border: 1px #cccccc solid;
            padding: 4px;
            margin: auto;
        }

        figcaption {
            background-color: navy;
            color: white;
            font-weight: bolder;
            font-style: italic;
            padding: 2px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php
        require_once 'client.php';

        if(isset($_GET['marca'])){

            $marca = empty($_GET['marca']) ? 'none' : $_GET['marca'];

            $modelos = $client->instance->ObtenerModelosPorMarca($marca);

            if(empty($modelos)){
                die("No existen modelos de la marca {$marca}");
            }

        }else{

            die("ERROR: variable marca not found");

        }

    ?>
    <h1>Modelos disponibles marca: <?= $marca ?></h1>
    <?php
        foreach ($modelos as $modelo) {?>
            <figure>
                <img style="width: 20%" src="images/<?= strtolower($marca) ?>.png" alt="logo <?= $marca ?>" />
                <figcaption><?= $modelo ?></figcaption>
            </figure>
        <?php }
    ?>
</body>
</html>

<?php


?>