<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title><?= $tituloPagina ?></title>
		<link rel="icon" href="img/logo2.jpeg">
		<link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/estiloPerfilNegociador.css" />
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet">
		<script src="<?= RUTA_JS ?>/factoriaStartUp.js"> </script>

	</head>

	<body id="Perfil">

		<?php
		//include($_SERVER['DOCUMENT_ROOT'].'/factoriaStartup/sidebarDer.php');
		require(RAIZ_APP.'/vistas/comun/cabeceraNegociador.php');
		?>

		<main>
            <article>
				<?= $contenidoPrincipal ?>
			</article>
		</main>
		<?php
		require(RAIZ_APP.'/sidebarDerNegociador.php');
		?>
	</body>
</html>