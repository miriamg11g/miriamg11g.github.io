<style>

body {

background: #fcfbfb;
margin: 0;
padding: 0;
font-size: 16px;
line-height: 1.5;
font-family: "Poppins", sans-serif;
overflow-x: hidden;
font-weight: 400;
color: rgb(0, 0, 0);
background-size: cover;
background-attachment: fixed;
background-repeat: no-repeat;
min-height: 100vh;
}


footer {
	margin-top: 100px;
	background-position: center bottom;
	background-repeat: no-repeat;
	background-color: rgb(41, 40, 40);
	color: #bbb;
	line-height: 1.5;
	font-family: "Poppins", sans-serif;
	width: 100%;
  margin-bottom: 0px;
  padding: 20px;
  text-align: center;
  position: relative;
  bottom: 0;
  width: 100%;
}

footer a {
	text-decoration: none;
	color: #eee;
}

a:hover {
	text-decoration: underline;
}

.ft-title {
	color: #fff;
	font-family: ’Merriweather’, serif;
	font-size: 1.375rem;
	padding-bottom: 0.625rem;
}

.container {
	flex: 1;
	/* same as flex-grow: 1; */
}

.ft-main {
	padding: 1.25rem 1.875rem;
	display: flex;
	flex-wrap: wrap;
}

.ft-main-item {
	padding: 1.25rem;
	min-width: 12.5rem;
	margin: 0 90px 0px 0;
}


p {
	margin-bottom: 8px;
}

ul {
	margin: 0;
	padding: 0;
	list-style-type: none;
}

ul li {
	margin-bottom: 0px;
	line-height: 1.5;
	color: #777;
	position: relative;
	display: inline-block;
	padding: 0;
}


/* Estilos adicionales para la imagen */
.ft-main-item:last-child {
  display: flex;
  align-items: center;
}

.ft-main-item:last-child img {
  width: 120px;
  margin-left: 150px;
  margin-right: 0px; 
  margin-top: -30px; 
}

</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
</head>
<body>
<div class="container"></div>
    <footer>
      <!-- Footer main -->
      <section class="ft-main">
        <div class="ft-main-item">
          <h2 class="ft-title">Acerca de nosotros</h2>
          <ul>
            <li><a href="#">Acerca de Factoria StartUp</a></li>
            <li><a href="#">Miembros</a></li>
          </ul>
        </div>
        <div class="ft-main-item">
          <h2 class="ft-title">Ayuda</h2>
          <ul>
            <li><a href="contacto.php">Contacto</a></li>
          </ul>
        </div>
        <div class="ft-main-item">
          <h2 class="ft-title">Políticas</h2>
          <ul>
            <li><a href="normasDeUso.php">Normas de uso</a></li>
          </ul>
        </div>
        <div class="ft-main-item">
          <p>Suscribirse a nuestras ofertas especiales</p>
          <form>
            <input type="email" name="email" placeholder="Enter email address">
            <input type="submit" value="Subscribe">
          </form>
        </div>
      </section>
    
    </footer>
</body>
</html>