/*var btnAbrirPopup = document.getElementById('btn-abrir-negociador2');
var overlay = document.getElementById('overlay');
var popup = document.getElementById('popup');
var btnCerrarPopup = document.getElementById('btn-cerrar-popup'); //variable boton para abrir el popup 


//abrir ventana emergente del negociador
btnAbrirPopup.addEventListener('click', function(){ //cuando se haga clicl en esa funcion, funcione
    overlay.classList.add('active');
    //cuando el overlay este en pantalla queremsoq que tenga una clase
    popup.classList.add('show');
});


//cerrar ventana emergente del negociador 
btnCerrarPopup.addEventListener('click', function(){ //cuando se haga clicl en esa funcion, funcione
    overlay.classList.remove('active');
    popup.classList.remove('show');
});
*/


var btnAbrirPopup = document.getElementById('btn-abrir-negociador2');
var popup = document.getElementById('popup');
var btnCerrarPopup = document.getElementById('btn-cerrar-popup');
var abierto = 0;

		// Abrir ventana emergente del negociador
		btnAbrirPopup.addEventListener('click', function() {

			if(abierto == 0){
				abierto = 1;
				popup.classList.add('show');
			}
			else{
				abierto = 0;
				popup.classList.remove('show');
			}
		});
        

	function eliminarFila(filaId) {
		// Obtener el ID de la fila que se quiere eliminar
		var id_match = filaId; // ID de la fila de alguna manera
				
		// Crear una solicitud AJAX
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "FormularioEliminarMatch.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				
		// Enviar los datos de la fila que se quiere eliminar
		xhr.send(filaId);
	}