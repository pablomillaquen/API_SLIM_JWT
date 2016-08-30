<?php
/****** GCA_PARametros ************/
include_once ("conf.sql.php"); //Clase con la Configuracion de la Conexion a MySql


class clsMaquinas
{
//  VARIABLES DE CLASE ###################################################
//  CONSTRUCTOR        ###################################################
function __construct() { }
//  METODOS            ###################################################



    public static function Lista($Id)
    {
    	$obj_Menu=new sQuery();
    	$Sql = "CALL SP_MAQUINAS_Sel('" .$Id ."');";

    	$obj_Menu->executeQuery($Sql);
    	$Datos = $obj_Menu->fetchAll();
    	return $Datos;	
    }







    // public static function Graba($id, $rut, $dv, $razonsocial, $giro, $idgiro, $logo, $direccion, $idcomuna)
    // {
    //     $obj_Menu=new sQuery();
    //     $Sql = "CALL SP_CLIENTE_Ins('" .$id ."','" .$rut ."','" .$dv ."','" .$razonsocial ."','" .$giro ."','" .$idgiro ."','" .$logo ."','" .$direccion ."','" .$idcomuna ."');";

    //     $obj_Menu->executeQuery($Sql);
    //     $Datos = $obj_Menu->fetchAll();
    //     return $Datos;  
    // }



}

?>
