
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<script src="jquery-1.9.1.min.js"></script>
<script>
$(document).ready(function() {
    $("#resultadoBusqueda").html('<p>Ingrese matricula, nombre de alumno o nombre de la empresa de su proyecto que desee buscar</p>');
});

function buscar() {
    var textoBusqueda = $("input#busqueda").val();
 
     if (textoBusqueda != "") {
		 
        $.post("procesar_busqueda_simple.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
            $("#resultadoBusqueda").html(mensaje);
         }); 
     } else { 
        $("#resultadoBusqueda").html('<p>Ingrese matricula, nombre de alumno o nombre de la empresa de su proyecto que desee buscar</p>');
        };
};
</script>
<title>Búsqueda AJAX</title>
</head>
<body>
<table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" >
<tr>
   <td bgcolor="#FFFFFF"><h1 align='center'>Búsqueda AJAX</h1>
	<div align="right"><a href="index.html">volver</a></div>
   </td>
</tr>
</table>

<form accept-charset="utf-8" method="POST">
<input type="text" name="busqueda" id="busqueda" value="" placeholder="" maxlength="30" autocomplete="off" onKeyUp="buscar();" />
</form>
<div id="resultadoBusqueda"></div>

</body>
</html>