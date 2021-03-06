<?php

class Conexion  // se declara una clase para hacer la conexion con la base de datos
{
	var $con;
	function Conexion()
	{
		// se definen los datos del servidor de base de datos 
		$conection['server']=getenv("DB_SERVER");  //host
		$conection['user']=getenv("DB_USER");
		$conection['pass']=getenv("DB_PASSWORD");
		$conection['base']=getenv("DB_NAME");
		
		// crea la conexion pasandole el servidor , usuario y clave
		// $conect= mysql_connect($conection['server'],$conection['user'],$conection['pass']);
		$conect= mysqli_connect($conection['server'],$conection['user'],$conection['pass'],$conection['base']);
		
		if (mysqli_connect_error())	
		//if ($conect) // si la conexion fue exitosa , selecciona la base
		{
			//mysql_select_db($conection['base']);			
			//$this->con=$conect;
		}else{ $this->con=$conect; }
	}
	function getConexion() // devuelve la conexion
	{
		return $this->con;
	}
	function Close()  // cierra la conexion
	{
		//mysql_close($this->con);
		mysqli_close($this->con);
	}	

}
class sQuery   // se declara una clase para poder ejecutar las consultas, esta clase llama a la clase anterior
{

	var $coneccion;
	var $consulta;
	var $resultados;
	function sQuery()  // constructor, solo crea una conexion usando la clase "Conexion"
	{
		$this->coneccion= new Conexion();
	}
	function executeQuery($cons)  // metodo que ejecuta una consulta y la guarda en el atributo $pconsulta
	{
		//$this->consulta= mysql_query($cons,$this->coneccion->getConexion());
		$this->consulta= mysqli_query($this->coneccion->getConexion(),$cons);
		return $this->consulta;
	}	
	function getResults()   // retorna la consulta en forma de result.
	{return $this->consulta;}
	
	function Close()		// cierra la conexion
	{$this->coneccion->Close();}	
	
	function Clean() // libera la consulta
	{ //mysql_free_result($this->consulta);
		mysqli_free_result($this->consulta); }
	
	function getResultados() // debuelve la cantidad de registros encontrados
	{ //return mysql_affected_rows($this->coneccion->getConexion()) ;
		return mysqli_affected_rows($this->coneccion->getConexion()) ;}
	
	function getAffect() // devuelve las cantidad de filas afectadas
	{ //return mysql_affected_rows($this->coneccion->getConexion()) ;
		return mysqli_affected_rows($this->coneccion->getConexion()) ; }

    function fetchAll()
    {
        $rows=array();
		if ($this->consulta)
		{
			//while($row=  mysql_fetch_array($this->consulta))
				while ($row=  mysqli_fetch_array($this->consulta))
			{
				$rows[]=$row;
			}
		}
        return $rows;
    }
}


?>
