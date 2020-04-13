<html>
<head>
<!--  Se define el lenguaje de codificación que acepte acentos y ñ, solo en el código html-->
<meta charset="utf-8">
<title>Información alumno</title>
</head>
<body>
<!--Esta página se encuentra en la carpeta procesar, ../ se utiliza para volver a la carpeta anterior -->
<div align="right"><a href="../index.html">volver</a></div><br/>
<h1 align="center">Información Alumnos</h1>
<?php


/*include('conexion.php') incorpora a este código las variables de conexión al servidor y base de datos
$host= dirección servidor
$user=usuario
$pw=contraseña servidor
$db=base 
*/
include('conexion.php');

	//obtiene el valor ingresado en el input llamado "matricula", mediante el método post
	$matricula=$_POST['matricula'];

	//Conecta con el servidor de lo contrario muestra el error.
	$conexion=mysqli_connect($host,$user,$pw)or die("Error al conectar con el servidor");
	
	//Selecciona la Base de datos del servidor de lo contrario muestra el error.
    mysqli_select_db($conexion,$db)or die("Error al conectar con la base de datos");

	/*La variable $matricula se puede concatenar en forma automática en un texto, 
	si la variable no es numérica  debe estar entre comillas simple
	*/

	$sql="SELECT * from alumno, grupo where alumno.id_grupo=grupo.id_grupo and alumno.matricula=$matricula";
    
	
	//ejecuta la consulta ocupando la variable $sql y $conexion
	$consulta = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
	
	/* cerrar la conexión */
	mysqli_close($conexion);
	
	
	/*mysqli_num_rows() calcula el número de filas de la consulta, si el número de tuplas es 0, quiere decir que no se encontró el alumno 
	cuya matrícula sea la almacenada en la variable $matricula, esto es controlado con un if.
	*/

	if(mysqli_num_rows($consulta)==0)
	{
		echo "<b>Alumno no econtrado.</b>";
	}
	else
	{
		/*mysqli_fetch_array Obtiene una fila de resultados como un array asociativo, numérico, o ambos
		En este caso el resultado de la consulta obtendrá solo una tupla, por lo que no se requiere recorrer mediante un ciclo for o while*/
		$fila=mysqli_fetch_array($consulta);
		
		//las funciones:codificacion(),carrera(),p_asistencia(),promedio_tareas(),detalle_asistencia() y detalle_notas() estan programadas mas abajo
		
		$nombre=codificacion($fila['nombre']);
		
		//Utilizamos $fila como un string asociativo cuyo indice es el nombre del campo
		$seccion=$fila['seccion'];
		$grupo=$fila['id_grupo'];
		$empresa=$fila['empresa'];
		$sistema=$fila['descripcion'];
		$carrera=carrera($fila['carrera']);
		$asistencia=p_asistencia($matricula);
		$promedio=promedio_tareas($matricula);

		
		//creamos una tabla con bordes invisibles para ordenar y alinear los datos mostrados del alumno
		echo "<table>";
		echo "<tr><td>Matricula</td><td>:</td>";
		echo "<td>".$matricula."</td></tr>";
		
		echo "<tr><td>Nombre</td><td>:</td>";
		echo "<td>".$nombre."</td></tr>";
				
		echo "<tr><td>Carrera</td><td>:</td>";
		echo "<td>".$carrera."</td></tr>";
		
		echo "<tr><td>Seccion</td><td>:</td>";
		echo "<td>".$seccion."</td></tr>";	
		
		echo "<tr><td>Grupo</td><td>:</td>";
		echo "<td>".$grupo."</td></tr>";	
		
		echo "<tr><td>Empresa</td><td>:</td>";
		echo "<td>".$empresa."</td></tr>";

		echo "<tr><td>Sistema de Información</td><td>:</td>";
		echo "<td>".$sistema."</td></tr>";	
		
		echo "<tr><td>Asistencia lab. S1</td><td>:</td>";
		echo "<td>".$asistencia. "%</td></tr>";	
		
		echo "<tr><td>Promedio tareas</td><td>:</td>";
		echo "<td>".$promedio. "</td></tr>";	
		echo "</table>";
		
		echo "<hr>";
		//una función en php también permite escribir en pantalla
		detalle_asistencia($matricula);
		
		echo "<hr>";
		detalle_notas($matricula);
		
		
	}
//funciones

//Función que permite cambiar la codificación de un valor extraído desde la BD, de esa forma es posible mostrar sin errores tildes, ñ y caracteres especiales.	
function codificacion($texto)
{
	
	// Detecta la codificación de caracteres almacenados en la BD
	$codificacion=mb_detect_encoding($texto,"UTF-8,ISO-8859-1");
	
	//iconv — Convierte un string a la codificación de caracteres indicada
	$retorno=iconv($codificacion, 'UTF-8',$texto);
	return $retorno;
} 

//la carrera se almacena como IMC o ICI, para mostrar el texto completo se ha creado esta función
function carrera($c)
{
	if($c=="ICM")
	{
		return "Ingeniería Civil Matemática";
	}
	else
	{
		return "Ingeniería Civil Industrial";
	}
}
	
//calcula el porcentaje de asistencia en una consulta, recibe como argumento la matricula del alumno
function p_asistencia($m)
{
	include('conexion.php');
	$conexion=mysqli_connect($host,$user,$pw)or die("Error al conectar con el servidor");
	mysqli_select_db($conexion,$db)or die("Error al conectar con la base de datos");
	$sql="SELECT sum(asistencia)/count(*) as porcentaje_a FROM asiste WHERE matricula=$m GROUP by matricula;";
	$consulta = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
	mysqli_close($conexion);
	$fila=mysqli_fetch_array($consulta);
	$porcentaje=$fila['porcentaje_a'];
	return $porcentaje*100;
}

//calcula el promedio de notas en una consulta, recibe como argumento la matricula del alumno
function promedio_tareas($m)
{
	include('conexion.php');
	$conexion=mysqli_connect($host,$user,$pw)or die("Error al conectar con el servidor");
	mysqli_select_db($conexion,$db)or die("Error al conectar con la base de datos");
	$sql="SELECT round(avg(nota),1) FROM realiza where matricula=$m";
	$consulta = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
	mysqli_close($conexion);
	$fila=mysqli_fetch_array($consulta);
	//$fila en este caso es utilizado con un arreglo normal y obtenemos el primer elemento cuyo indice es 0
	$promedio=$fila[0];
	return $promedio;
	
}


//Muestra una tabla con el detalle de asistencia, recibe como argumento la matricula del alumno
function detalle_asistencia($m)
{
	include('conexion.php');
	$conexion=mysqli_connect($host,$user,$pw)or die("Error al conectar con el servidor");
	mysqli_select_db($conexion,$db)or die("Error al conectar con la base de datos");
	$sql="SELECT * FROM asiste, laboratorio where matricula=$m and laboratorio.id_laboratorio=asiste.id_laboratorio;";
	$consulta = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
	//la conexión es cerrada pero su resultado completo se guardó en la variable $consulta.
	mysqli_close($conexion);
	//El resultado de esta consulta puede ser mas de una tupla, por lo que es necesario recorrerlo con un for o while
	$n_tuplas=mysqli_num_rows($consulta);
	
	echo "<h3>Detalle asistencia.</h3>";
	echo "<table border=1 cellpadding='1' cellspacing='0'><tr><td>Fecha</td><td>Asistencia (*)</td><tr>";

	for($i=0;$i<$n_tuplas;$i++)
	{
		//cada vez que se ejecuta mysqli_fetch_array, la lectura de $consulta avanza una tupla la cual es almacenada en fila como un arreglo normal y asociativo
		$fila=mysqli_fetch_array($consulta);
		echo "<tr><td>".date("d/m/Y", strtotime($fila['fecha']))."</td>";
		echo "<td align='center'>".$fila['asistencia']."</td></tr>";
	}
	echo "</table>";
	echo "<p><h6>(*) 1= asistió, 0.5= atrasado, 0= ausente </h6></p>";
}

//Muestra una tabla del detalle de notas de las tareas, recibe como argumento la matricula del alumno
function detalle_notas($m)
{
	include('conexion.php');
	$conexion=mysqli_connect($host,$user,$pw)or die("Error al conectar con el servidor");
	mysqli_select_db($conexion,$db)or die("Error al conectar con la base de datos");
	$sql="SELECT * FROM realiza WHERE matricula=$m ORDER by id_tarea;";
	$consulta = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
	mysqli_close($conexion);
	$n_tuplas=mysqli_num_rows($consulta);
	
	echo "<h3>Detalle Notas.</h3>";
	echo "<table border=1 cellpadding='1' cellspacing='0'><tr><td>Tarea</td><td>Nota</td><tr>";

	for($i=0;$i<$n_tuplas;$i++)
	{
		$fila=mysqli_fetch_array($consulta);
		echo "<tr><td align='center'>".$fila['id_tarea']."</td>";
		echo "<td align='center'>".$fila['nota']."</td></tr>";
	}
	echo "</table>";

}


?>
</body>
</html>