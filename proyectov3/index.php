<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION["nombre"])) {
    header("Location: login.php");
    exit();
}
// Restaurar el carrito desde la cookie si está presente
//Si existe el la cookie del carrito del usuario, la importamos y deserializamos la sesion del carrito del usuario
if (isset($_COOKIE[$_SESSION["nombre"]])) {
	$_SESSION[$_SESSION["nombre"]] = unserialize($_COOKIE[$_SESSION["nombre"]]);
}
// Inicializar el array del carrito si no existe
// Inicializamos la sesión del carrito del usuario si no existe
if (!isset($_SESSION[$_SESSION["nombre"]])) {
    $_SESSION[$_SESSION["nombre"]] = [];
}

// Aumentar y disminuir el carrito
if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Si le damos a comprar
    if (isset($_POST["comprar"])) {
				// Va a meter en $producto el valor del boton al que le demos
        $producto = $_POST["comprar"];
        // Agregar el producto al carrito y si no existe lo inicializa en 1
        $_SESSION[$_SESSION["nombre"]][$producto] = isset($_SESSION[$_SESSION["nombre"]][$producto]) ? $_SESSION[$_SESSION["nombre"]][$producto] + 1 : 1;
    // Eliminar el producto del carrito
		} elseif (isset($_POST["eliminar"])) {
				// va a coger el producto del foreach de abajo
        $producto = $_POST["eliminar"];
        // Verificar si hay más de una unidad antes de eliminar
        if ($_SESSION[$_SESSION["nombre"]][$producto] > 1) {
						// Si hay mas de una unidad la decrementa
            $_SESSION[$_SESSION["nombre"]][$producto]--;
        } else {
            // Si solo hay una unidad, elimina el producto del carrito
						// El unset elimina la variable producto de la sesion
            unset($_SESSION[$_SESSION["nombre"]][$producto]);
        }
    }
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Catálogo</title>
	<meta name="author" content="Omar Alonso">
	<meta name="author" content="Pablo Ramirez">
	<meta name="author" content="Ignacio Rodríguez">
	<link rel="stylesheet" href="css/index.css">
</head>

<body>
	<header>
		<!-- Sale el nombre del usuario-->
		<p>Bienvenido, <?php echo $_SESSION["nombre"]; ?>!</p>
		<nav>

		</nav>
	</header>
	<main>
    <section>
      <h1>Productos</h1>
      <hr>
      <form method="post" action="#">
				<div>
					<article>
						<p>Battlefield 2042</p>
						<img src="img/BF.jpg" alt="BF2042">
						<p>29,99€ - <button type="submit" name="comprar" value="battlefield2042">Comprar</button></p>
						<a href="detalles_Productos.html">Acerca del juego</a>
					</article>
					<article>
						<p>Horizon Zero Dawn</p>
						<img src="img/horizon_Zero.jpg" alt="HZD">
						<p>29,99€ -  <button type="submit" name="comprar" value="horizonzerodown">Comprar</button></p>
						<a href="detalles_Productos.html">Acerca del juego</a>
					</article>
					<article>
						<p>Euro Track Simulator</p>
						<img src="img/euroTrack.jpg" alt="EURO TS">
						<p>29,99€ -  <button type="submit" name="comprar" value="eurotruck">Comprar</button></p>
						<a href="detalles_Productos.html">Acerca del juego</a>
					</article>
					<article>
						<p>Forza Horizon 5</p>
						<img src="img/forza_horizon.jpg" alt="FH5">
						<p>49,99€ -  <button type="submit" name="comprar" value="forzahorizon5">Comprar</button></p>
						<a href="detalles_Productos.html">Acerca del juego</a>
					</article>
					<article>
						<p>Flight Simulator</p>
						<img src="img/flight_simu.jpg" alt="FS">
						<p>59,99€ -  <button type="submit" name="comprar" value="flightsimulator">Comprar</button></p>
						<a href="detalles_Productos.html">Acerca del juego</a>
					</article>
				</div>
      </form>
    </section>
  </main>
    <aside>
        <h1>Carrito</h1>
        <hr>
        <form method="post" action="#">
            <?php

            $precios = [
                "battlefield2042" => 29.99,
                "horizonzerodown" => 29.99,
                "eurotruck" => 29.99,
                "forzahorizon5" => 49.99,
                "flightsimulator" => 59.99,
            ];

            // Mostrar productos en el carrito y calcular el total
						// Inicializamos el total
            $total = 0;
						//Para cada producto existente del carrito
            foreach ($_SESSION[$_SESSION["nombre"]] ?? [] as $producto => $cantidad) {
								//Sacamos del array los precios gracias a que esta indexado con el nombre del producto 
                $precio = $precios[$producto];
								//Sacamos el total de cada producto
                $subtotal = $precio * $cantidad;
								//Le vamos sumando el total de cada producto para crear el total
                $total += $subtotal;
								//añadimos el producto al carrito
                echo '<p>'.$producto.' - '.$cantidad.' unidades <button type="submit" name="eliminar" value="'.$producto.'">Eliminar una unidad</button></p>';
            }
						// Creamos una cookie para cada usuario que inicie sesión serializando(pasando a cadena de caracteres) la sesión del carrito
						// Se serializa la sesión para poder transferirla al cliente en forma de cookie, ya que solo se puede pasar texto plano entre el servidor y el cliente
						setcookie($_SESSION["nombre"], serialize($_SESSION[$_SESSION["nombre"]]), time() + 1*24*60*60, "/"); // Cookie caduca en un dia
            ?>
        </form>
				<!--Sacamos el precio total del carrito y utilizamos la función number_format() para dejarlo solo con dos decimales-->
        <p>Total: <?php echo number_format($total, 2); ?>€</p>
    </aside>
    <footer>
      <p><a href='logout.php'>Cerrar sesión</a></p>
      <p>&copy; <?php echo date("Y"); ?> - PLAYPORTAL</p>
    </footer>
</body>

</html>