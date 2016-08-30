<?php
/****** GCA_PARametros ************/
include_once ("conf.sql.php"); //Clase con la Configuracion de la Conexion a MySql

class clsParametros
{
//  VARIABLES DE CLASE ###################################################
	static $_nPAR_Id = 0;
	static $_nPAR_Codigo = 0;
	static $_mPAR_Descrip1 = "";
	static $_mPAR_Descrip2 = "";
	static $_mPAR_Obs ="";
	static $_nPAR_Estado = "";
	
	
	
//  CONSTRUCTOR        ###################################################

function __construct() {
	}

//  METODOS            ###################################################


public static function ListParamENC($Estado)
{
	//EXTRAIGO TODOS LSO DATOS
	$obj_Menu=new sQuery();
	$obj_Menu->executeQuery("SELECT `PAR_Id`, `PAR_Obs`, `PAR_Estado` FROM `GCA_PARametros` WHERE `PAR_Estado` = 1 group by `PAR_Id`, `PAR_Obs`, `PAR_Estado` ORDER BY `PAR_Obs`"); //PAR_Id,PAR_Codigo

	$Datos = $obj_Menu->fetchAll();
	return $Datos; // retorna todos los registros
}



public static function DevCBOParametros($Id, $Estado,$NombreCBO,$ClassCBO="form-control")
{
	$obj_Menu=new sQuery();
	$Sql = "CALL SP_PARLista('" .$Id ."','" .$Estado ."');";
	$obj_Menu->executeQuery($Sql);
	$Datos = $obj_Menu->fetchAll();

	$Cbo="";

    $Cbo= "<select name='" .$NombreCBO ."' id='" .$NombreCBO ."' class='" .$ClassCBO ."'>";
    foreach ($Datos as $Row): 	
		$Cbo= $Cbo ."<option value=" .$Row['PAR_Codigo'];
		if ($IdComuna == $Row['PAR_Codigo']){ 
			$Cbo= $Cbo ." selected='selected' ";
		}
		$Cbo= $Cbo .">" .limpiarString($Row['PAR_Descrip1']) ."</option>";

	endforeach;
	$Cbo= $Cbo ."</select>";

	return $Cbo;	
}


// PARAMETROS PROPIOS ·····················································································

public static function DevCBOListParClientes($NombreCBO,$ClassCBO="form-control")
{
	$obj_Menu=new sQuery();
	$Sql = "CALL SP_PARClientes_cbo();";
	$obj_Menu->executeQuery($Sql);
	$Datos = $obj_Menu->fetchAll();
	$obj_Menu=new sQuery();

	$Cbo="";

   $Cbo= "<select name='" .$NombreCBO ."' id='" .$NombreCBO ."' class='" .$ClassCBO ."'>";
   foreach ($Datos as $Row): 	
			$Cbo= $Cbo ."<option value=" .$Row['Id'];
			// if ($IdComuna == $Row['Id']){ 
			// 	$Cbo= $Cbo ." selected='selected' ";
			// }
			$Cbo= $Cbo .">" .limpiarString($Row['Descrip1']) ."</option>";

	endforeach;
	$Cbo= $Cbo ."</select>";

	return $Cbo;	
}

public static function DevCBOListParCtaCorr($NombreCBO,$ClassCBO="form-control")
{
	$obj_Menu=new sQuery();
	$Sql = "CALL SP_PARCtaCorr_cbo();";
	$obj_Menu->executeQuery($Sql);
	$Datos = $obj_Menu->fetchAll();
	$obj_Menu=new sQuery();

	$Cbo="";

   $Cbo= "<select name='" .$NombreCBO ."' id='" .$NombreCBO ."' class='" .$ClassCBO ."'>";
   foreach ($Datos as $Row): 	
			$Cbo= $Cbo ."<option value=" .$Row['Id'];
			if ($IdComuna == $Row['Id']){ 
				$Cbo= $Cbo ." selected='selected' ";
			}
			$Cbo= $Cbo .">" .limpiarString($Row['Descrip1']) ."</option>";

	endforeach;
	$Cbo= $Cbo ."</select>";

	return $Cbo;	
}

public static function ListParamProc($Id, $Estado)
{
	$obj_Menu=new sQuery();
	$Sql = "CALL SP_PARLista('" .$Id ."','" .$Estado ."');";

	$obj_Menu->executeQuery($Sql);
	$Datos = $obj_Menu->fetchAll();
	return $Datos;	
}

public static function ListParam($Id, $Estado)
{
	//EXTRAIGO TODOS LSO DATOS
	$obj_Menu=new sQuery();
	$obj_Menu->executeQuery("SELECT
							`PAR_Id`, 
							`PAR_Codigo`, 
							`PAR_Descrip1`, 
							`PAR_Descrip2`, 
							`PAR_Obs`, 
							`PAR_Estado`
							FROM `GCA_PARametros`
							WHERE `PAR_Id` = $Id
							AND	  `PAR_Estado` = $Estado
							ORDER BY PAR_Descrip1 ASC "); //PAR_Id,PAR_Codigo

	$Datos = $obj_Menu->fetchAll();
	
 	foreach ($Datos as $Row): 		
		clsParametros::$_nPAR_Id = $Row['PAR_Id'];
		clsParametros::$_nPAR_Id = $Row['PAR_Codigo'];
		clsParametros::$_mPAR_Descrip1 = $Row['PAR_Descrip1'];
		clsParametros::$_mPAR_Descrip2 = $Row['PAR_Descrip2'];
		clsParametros::$_mPAR_Obs =  $Row['PAR_Obs'];
		clsParametros::$_nPAR_Estado =  $Row['PAR_Estado'];
		
	endforeach;   
	
	return $Datos; // retorna todos los registros
}

public static function DevTotalParam($Estado)
{
	$Total = 0;
	$obj_Menu=new sQuery();
	$obj_Menu->executeQuery("SELECT COUNT(*) as Total FROM `GCA_PARametros` WHERE `PAR_Id` = $Id AND `PAR_Estado` = $Estado");

	$Datos = $obj_Menu->fetchAll();
	
 	foreach ($Datos as $Row): 		
		$Total = $Row['Total'];			
	endforeach;   
	
	return $Total; // retorna todos los clientes
}


//  OTROS PARAMETROS               ###################################################
// public static function ListParCtaCorr()
// {
// 	$obj_Menu=new sQuery();
// 	$Sql = "CALL SP_PARCtaCorr_cbo();";
// 	$obj_Menu->executeQuery($Sql);
// 	$Datos = $obj_Menu->fetchAll();
// 	return $Datos;	
// }



// UF - UTM ###################################################



public static function ListParamUfUtm($Estado, $Ano)
{
	$obj_Menu=new sQuery();
	$Sql = "CALL SP_PARUFUTM_Lista('" .$Estado ."','" .$Ano ."');";

	$obj_Menu->executeQuery($Sql);
	$Datos = $obj_Menu->fetchAll();
	return $Datos;	
}

}
