<?php
    session_start();

    if ( ! isset($_POST['numero'])) {//si no envio nada;
    $_SESSION['numero']=rand(1,10);
    $_SESSION['intentos']=0;
    };
    $numero_aleatorio =$_SESSION['numero'];
    $intentos=$_SESSION['intentos'];
    $_SESSION['intentos']=$_SESSION['intentos']+1;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Adivina cualquier cosa</title>
    </head>
    <body>
        <h1>Adivina cualquier cosa</h1>
        <div>
            <form action="index.php" method="post">
                <input type="text" name="numero" value="">
                <input type="submit" name="" value="enviar">
            </form>
            <?php 
            if( isset($_POST['numero']) ) {
                echo "<h3>Has enviado algo: " . $_POST['numero'] . "</h3>";
                if ($numero_aleatorio == $_POST['numero']) {
                    echo "<img src=confeti.gif>";
                    echo "<h1>HAS GANADO!!!</1>";
                }
                if ($numero_aleatorio < $_POST['numero']) {
                    echo "<h1>Tu número es muy alto</h1>";
                    echo "<img src=globo.jpg>";
                }
                if ($numero_aleatorio > $_POST['numero']) {
                    echo "<h1>Tu número es muy bajo</h1>";
                    echo "<img src=precipicio.jpeg>";
                }
            } else {
                echo "Bienvenido al juego";
            }
            if( isset($_POST['numero']) ) {
                echo "<p>Intento nº: " . $intentos . "</p>";
            }
            
            ?>
            <p>
                <a href="index.php">Reiniciar Partida</a>
            </p>
        </div>
    </body>
</html>