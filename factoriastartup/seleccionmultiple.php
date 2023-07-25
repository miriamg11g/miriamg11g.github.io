<!DOCTYPE html>
<html>
<head>
  <title>Formulario con Casillas de Verificación</title>
  <style>
    /* Estilos CSS */
    body {
      font-family: Arial, sans-serif;
    }
    
    .form-container {
      width: 400px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      background-color: #f4f4f4;
    }
    
    label {
      display: block;
      margin-bottom: 10px;
    }
    
    input[type="submit"] {
      width: 100%;
      margin-top: 10px;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Formulario con Casillas de Verificación</h2>
    <form method="post" action="seleccionmultiple_procesar_formulario.php">
      <label for="opcion1"><input type="checkbox" id="opcion1" name="opciones[]" value="opcion1"> Opción 1</label>
      <label for="opcion2"><input type="checkbox" id="opcion2" name="opciones[]" value="opcion2"> Opción 2</label>
      <label for="opcion3"><input type="checkbox" id="opcion3" name="opciones[]" value="opcion3"> Opción 3</label>
      <label for="opcion4"><input type="checkbox" id="opcion4" name="opciones[]" value="opcion4"> Opción 4</label>
      <label for="opcion5"><input type="checkbox" id="opcion5" name="opciones[]" value="opcion5"> Opción 5</label>
      <input type="submit" value="Enviar">
    </form>
  </div>
</body>
</html>
