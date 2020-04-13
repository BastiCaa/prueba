
<html>
<head>
<title>Ingresar nuevo alumno.</title>
<!--  Se define el lenguaje de codificación que acepte acentos y ñ, solo en el código html-->
<meta charset="utf-8">
</head>

<body>

<div align="right"><a href="index.html">volver</a></div>
<td  align="center"><h2 align="center">Ingresar nuevo alumno</h2>

	<!-- Formulario, se enviaran los datos de este a la pagina procesar_form1.php mediante el metodo post-->
	<form name="formName" action="procesar/procesar_form1.php" method="post" >
	
	<!--Tabla que permite ordenas y alinear el aspecto del formulario -->
	<table  border="0" align="center" >
	<tr><td valign="top">- </td>
	<td valign="top"><strong>Matricula</strong></td>
	<td valign="top">:</td>
	<td><input type="number" name="matricula"  size="100" placeholder="Ingrese N° matricula" required ></td></tr>
	
	
	<tr><td valign="top">- </td>
	<td valign="top"><strong>Nombres</strong></td>
	<td valign="top">:</td>
	<td><input type="text" name="F_nombres" placeholder="Ingrese NOMBRES"  required></td></tr>	
	
	<tr><td valign="top">- </td>
	<td valign="top"><strong>Apellidos</strong></td>
	<td valign="top">:</td>
	<td><input name="F_apellidos" placeholder="Ingrese APELLIDOS"   required></td></tr>
	
	<!--Select programado en forma manual-->
	<tr><td valign="top">- </td>
	<td valign="top"><strong>Carrera</strong></td>
	<td valign="top">:</td>
	<td><select type="text" name="carrera">
		<option value="ICM">Ingeniería Civil Matemática</option>
		<option value="ICI">Ingeniería Civil Industrial</option>
	</select>
	</td></tr> 
	
	
	<!--El elemento input, teniendo el valor "radio" en su atributo type,
	representa una opción que pertenece a un grupo en el que no más de una opción puede ser seleccionada al mismo tiempo.
	Estos grupos están normalmente conformados por un número de botones de opción, todos compartiendo el mismo valor en el atributo name.
	Cada opcion se identifica con el atributo value.-->
	<tr><td valign="top">- </td>
	<td valign="top"><strong>Sección</strong></td>
	<td valign="top">:</td>
	<td><input type="radio" name="seccion" value="1"> 1
    <input type="radio" name="seccion" value="2"> 2</td></tr>
	
	<!-- Select completado leyendo desde la BD por un codigo PHP insertado en el HTML -->
	<tr><td valign="top">- </td>
	<td valign="top"><strong>Grupo</strong></td>
	<td valign="top">:</td>
	<td><select type="text" name="grupo">
<?php
		require('procesar/conexion.php'); 
		$con=mysqli_connect($host,$user,$pw)or die("Error al conectar con el servidor");
		mysqli_select_db($con,$db)or die("Error al conectar con la base de datos");
		$sql = "SELECT id_grupo, empresa FROM grupo;"; /*Recupera los datos de los grupos y los pone en el cada opcion del select*/

		$consulta = mysqli_query($con,$sql); 

		while ($fila= mysqli_fetch_assoc($consulta)) 
		{

				echo "<option value=".$fila["id_grupo"].">".$fila["id_grupo"]."-".$fila["empresa"]."</option>";


		}
	



?>
	
	</select>
	</td></tr> 	
	
	
	
	<!--
	El elemento HTML <input type="checkbox"> es un elemento de entrada que te seleccionar varias opciones a la vez, 
	El atributo value es usado para definr el valor enviado por el checkbox. 
	El atributo checked se usa para indicar que el elemento está seleccionado. -->
  	<tr><td valign="top">- </td>
	<td valign="top"><strong>Lenguajes de programacion favoritos</strong></td>
	<td valign="top">:</td>
	<td>
	<!--Aparece LP[] para guardarlos en un arreglo-->
    <input type="checkbox" name="LP[]" value="Java"> Java<br>
	<input type="checkbox" name="LP[]" value="Python" checked> Python<br>
    <input type="checkbox" name="LP[]" value="PHP" checked> PHP<br>
	<input type="checkbox" name="LP[]" value="C" checked> C<br>
	<input type="checkbox" name="LP[]" value="Ruby" > Ruby<br></td></tr>
<tr> </tr>
<tr> </tr>
	<tr><td colspan="3"></td>
	<td align="center">

	<input type="submit" value="Ingresar">
	</td>
	</tr>
	</table>
	</form>


</body>
</html>

