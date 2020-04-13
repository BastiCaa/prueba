
	

	<table border=1 cellpadding='1' cellspacing='0' align="center">
		<tr>
		<td>
		Nombre
		</td>
		<td>
		Sección
		</td>
		<td>
		Carrera
		</td>
		<td>
		N° Grupo
		</td>
		<td>
		Empresa
		</td>
		<td>
		Sistema de información
		</td>
		</tr>









<?php
	

//variables de conexión a la base de datos
$host="localhost";
$user="root";
$pw ="";
$db= "nombre_tu_bd";



//Variable de búsqueda
$busqueda=$_POST['valorBusqueda'];

//Filtro anti-XSS
$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
$caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047;");
$busqueda = str_replace($caracteres_malos, $caracteres_buenos, $busqueda);

//Variable vacía (para evitar los E_NOTICE)
$mensaje = "";


//Comprueba si $busqueda está seteado
if (isset($busqueda)) {
	$conexion=mysqli_connect($host,$user,$pw)or die("Error al conectar con el servidor");
    mysqli_select_db($conexion,$db)or die("Error al conectar con la base de datos");

	$sql="SELECT nombre,seccion,carrera,grupo.id_grupo,empresa, descripcion FROM alumno,grupo where grupo.id_grupo=alumno.id_grupo and(matricula like '%$busqueda%' or  nombre like '%$busqueda%' or  empresa like '%$busqueda%')";  
	$consulta = mysqli_query($conexion, $sql);

	//Obtiene la cantidad de filas que hay en la consulta
	$filas = mysqli_num_rows($consulta);
	mysqli_close($conexion);
	//Si no existe ninguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
	if ($filas === 0) {
		$mensaje = "<p>No hay resultados para $busqueda</p>";
	} else {
		//Si existe alguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
		echo 'Resultados para <strong>'.$busqueda.'</strong>';

		//La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle
		while($resultados = mysqli_fetch_array($consulta)) {
			$nombre = $resultados['nombre'];
			$carrera = $resultados['carrera'];
			$grupo = $resultados[3];
			$seccion = $resultados['seccion'];
			$empresa = $resultados['empresa'];
			$descripcion = $resultados['descripcion'];

			//Output
			$mensaje .= "
			<tr>
			<td>
			$nombre
			</td>
			<td align='center'>
			$seccion
			</td>
			<td align='center'>
			$carrera
			</td>
			<td align='center'>
			$grupo
			</td>
			<td>
			$empresa
			</td>
			<td>
			$descripcion
			</td></tr>";

		};//Fin while $resultados

	}; //Fin else $filas

};//Fin isset $consultaBusqueda

//Devolvemos el mensaje que tomará jQuery
echo $mensaje;
?>
    </table>





<div align="left"><a href="busquedasimple.php">volver</a></div><br/>