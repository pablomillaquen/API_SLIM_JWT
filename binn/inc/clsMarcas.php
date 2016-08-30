<?php
/****** GCA_MARcas ************/
include_once ("conf.sql.php"); //Clase con la Configuracion de la Conexion a MySql


class clsMarcas
{
//  VARIABLES DE CLASE ###################################################
//  CONSTRUCTOR        ###################################################
function __construct() { }
//  METODOS            ###################################################



    public static function Lista($Id)
    {
    	$obj_Menu=new sQuery();
    	$Sql = "CALL SP_MARCAS_Sel('" .$Id ."');";

    	$obj_Menu->executeQuery($Sql);
    	$Datos = $obj_Menu->fetchAll();
    	return $Datos;	
    }







    public static function NewRegistro($Nombre)
    {
        $obj_Menu=new sQuery();
        $Sql = "CALL SP_MARCAS_Ins('" .$Nombre ."');";

        $obj_Menu->executeQuery($Sql);
        $Datos = $obj_Menu->fetchAll();
        return $Datos;  
    }



}

?>
