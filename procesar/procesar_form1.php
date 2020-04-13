<?php
/*include('conexion.php') incorpora a este código las variables de conexión al servidor y base de datos
$host= dirección servidor
$user=usuario
$pw=contraseña servidor
$db=base 
*/
	include('conexion.php');

	//Recibe los datos del formulario mediante le metodo post
	$matricula=$_POST['matricula'];
	$F_nombres=$_POST['F_nombres'];
	$F_apellidos=$_POST['F_apellidos'];
	$carrera=$_POST['carrera'];
	$seccion=$_POST['seccion'];
	$grupo=$_POST['grupo'];

	
	//Conecta con el servidor de lo contrario muestra un error.
	$conexion=mysqli_connect($host,$user,$pw)or die("Error al conectar con el servidor");
	//Selecciona la Base de datos del servidor de lo contrario muestra un error.
    mysqli_select_db($conexion,$db)or die("Error al conectar con la base de datos");
	
	//en mi bd el nombre de los alumnos se guarda en el formato APELIIDOS-NOMBRES, en este caso concatenaré los apellidos y nombre en la variable $nombre.
	$nombre=$F_apellidos." ".$F_nombres;
	
	//Al insertar todos los campos, puedes omitir el nombre de los campos, pero deben ser ingresados en el mismo orden que aparece en la tabla,
	$sql="INSERT INTO alumno  values($matricula,'$nombre','$seccion','$carrera',$grupo)";

	//ejecuta la sql
	mysqli_query($conexion,$sql );
	/* cerrar la conexión */
	mysqli_close($conexion);
	
	echo "El Alumno ".$nombre." ha sido registrado correctamente.";
	
	//empty() calcula si $_post es vacio.
    if(!empty($_POST['LP']))
	{
	
	//LP en el formulario puede tomar mas de un valor y se guardan en un arreglo normal
	$LP=$_POST['LP'];
		echo "<br><p>Lenguajes de Programación seleccionados:";
			/*a continuacion mostrare como recibir los datos de un checkbox
		Solo serán mostrados, pero uds podrian almacenarlos con el precedimiento anterior pero en el interior del ciclo for
		count calcula el largo del arreglo*/
		for ($i=0;$i<count($LP);$i++)    
		{    
			echo "<br>- " . $i . ": " . $LP[$i];    
		}
	
	}
	else
	{

		echo "<br><p>No has seleccionado un lenguaje de programación. ";
	}

	?>
	
	<!-- A continuacion el codigo del informe_ejemplo.php visto en el lab5, para mostrar los datos ingresados-->
	<br/><br/><h3 align="center">Datos ingresados previamente</h3>
	<table border=1 align="center">
		<tr>
		<td>
		Matricula
		</td>
		<td>
		Nombre
		</td>
		<td>
		Seccion
		</td>
		<td>
		Carrera
		</td>
		<td>
		grupo
		</td>
		</tr>
		<?php
		$con=mysqli_connect($host,$user,$pw) or die ("Error al conectar con el servidor");
		mysqli_select_db($con,$db) or die("Error al conectar con la base de datos");
		$sql="SELECT * FROM alumno, grupo where grupo.id_grupo=alumno.id_grupo;";
		$rs= mysqli_query($con,$sql) or die(mysqli_error($con));
		mysqli_close($con);
		$numeroTuplas=mysqli_num_rows($rs);
		$i=0;


		for($i=0;$i<$numeroTuplas;$i++)
		{
			$fila=mysqli_fetch_array($rs);
			echo "<tr>";
			echo "<td>";
			echo $fila['matricula'];
			echo "</td>";
			echo "<td>";
			echo $fila['nombre'];
			echo "</td>";
			echo "<td>";
			echo $fila['seccion'];
			echo "</td>";
			echo "<td>";
			echo $fila['carrera'];
			echo "</td>";
			echo "<td>";
			echo $fila['id_grupo']."-".$fila['empresa'];
			echo "</td>";
			echo "</tr>";
		}

?>


</table>
    




<div align="left"><a href="../index.html">volver</a></div><br/>