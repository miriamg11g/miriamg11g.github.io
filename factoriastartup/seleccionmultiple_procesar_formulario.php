<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtener los valores seleccionados
  $opciones = $_POST["opciones"];

  // Imprimir los valores seleccionados
  echo "Opciones seleccionadas:<br>";
  foreach ($opciones as $opcion) {
    echo $opcion . "<br>";
  }
}
?>
