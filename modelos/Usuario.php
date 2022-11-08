<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Usuario
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$permisos)
	{
		$sql="INSERT INTO usuario(nombre,num_documento,direccion,telefono,email,cargo,login,clave,imagen,condicion)
		VALUES ('$nombre','$num_documento','$direccion','$telefono','$email','$cargo','$login','$clave','$imagen','1')";
		//return ejecutarConsulta($sql);
		//necesito el id del usuario que se ha registrado
		$idusuarionew=ejecutarConsulta_retornarID($sql);
		//numero de permisos asignados a este usuario
		$num_elementos=0;
		//bandera que me va a mostrar si todo se ha registrado correctamente
		$sw=true;
		//while para registrar los permisos
		while ($num_elementos < count($permisos)) 
		{
			$sql_detalle= "INSERT INTO usuario_permiso(idusuario,idpermiso) VALUES ('$idusuarionew','$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw=false;
			$num_elementos=$num_elementos + 1;	
		}
		return $sw;
	}
	//Implementamos un método para editar registros
	public function editar($idusuario,$nombre,$num_documento,$direccion,$telefono,$email,$cargo,$login, $clave,$imagen,$permisos)
	{
		$sql="UPDATE usuario SET nombre='$nombre',num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email',cargo='$cargo',login='$login',clave='$clave',imagen='$imagen' WHERE idusuario='$idusuario'";
		ejecutarConsulta($sql);
		
		//eliminamos todos los permisos asignados para volverlos a registrar
		$sqldel="DELETE FROM usuario_permiso WHERE idusuario='$idusuario'";
		ejecutarConsulta($sqldel);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($permisos)) 
		{
			$sql_detalle= "INSERT INTO usuario_permiso(idusuario,idpermiso) VALUES ('$idusuario','$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw=false;
			$num_elementos=$num_elementos + 1;	
		}
		return $sw;
	}

	//Implementamos un método para desactivar usuarios
	public function desactivar($idusuario)
	{
		$sql="UPDATE usuario SET condicion='0' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idusuario)
	{
		$sql="UPDATE usuario SET condicion='1' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idusuario)
	{
		$sql="SELECT * FROM usuario WHERE idusuario='$idusuario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM usuario";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los permisos marcados en la consulta
	public function listarmarcados($idusuario)
	{
		$sql="SELECT * FROM usuario_permiso WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}
	//funcion para ver si el usuario tiene acceso al sistema
	public function verificar($login,$clave)
	{
		$sql="SELECT idusuario,nombre,tipo_documento,num_documento,telefono,email,cargo,imagen,login FROM usuario WHERE login='$login' AND clave='$clave' AND condicion='1'";
			return ejecutarConsulta($sql);
	}

	public function verificarOlvido($login,$dni)
	{
		$sql="SELECT idusuario,login FROM usuario WHERE login='$login' AND num_documento='$dni' AND condicion='1'";
			return ejecutarConsulta($sql);
	}

	public function cambiarContrasena($login,$clave)
	{
		$sql="UPDATE usuario SET clave='$clave' WHERE login='$login' AND condicion='1'";
			return ejecutarConsulta($sql);
	}
	
}

?>