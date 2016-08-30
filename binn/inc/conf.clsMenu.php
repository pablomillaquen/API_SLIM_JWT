<?php
include_once ("conf.sql.php"); //Clase con la Configuracion de la Conexion a MySql

class clsMenu
{

	function __construct() { }  //  CONSTRUCTOR   

	//  METODOS           
	/**********************************************************************************************
	  MENU CON ACCESOS
	***********************************************************************************************/
	public static function ListMenuEmp($IdEmp)
	{
		$obj_Menu=new sQuery();
		$Sql = "CALL SP_MENu('" .$IdEmp ."');";

		$obj_Menu->executeQuery($Sql);
		$Datos = $obj_Menu->fetchAll();	
	   // $obj_Menu->Clean();   libera la consulta
		return $Datos;	
	}


}
?>