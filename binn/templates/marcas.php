<?Php

include_once ("binn/inc/clsMarcas.php");
//include_once ("../inc/clsClientes.php");  //DEBUG


class clsmarcasVW
{




function __construct() { }  //  CONSTRUCTOR   

//  METODOS 
public static function vwLista($id)
{
    $Clase=new clsMarcas();
    $Datos = $Clase->Lista($id);

    $i=0;
    foreach ($Datos as $Rows):
    	$respuesta[$i]['id'] =   $Rows['MAR_Id'];
    	$respuesta[$i]['nombre'] =   utf8_encode($Rows['MAR_Nombre']);
        $respuesta[$i]['idEstado'] =   $Rows['MAR_Estado'];
     $i++;
    endforeach;  
    return $respuesta;	
}


public static function vwNewRegistro($nombre)
{
    $Clase=new clsMarcas();
    $Datos = $Clase->NewRegistro($nombre);

    $i=0;
    foreach ($Datos as $Rows):
        $respuesta[$i]['id'] =   $Rows['id'];
        $respuesta[$i]['msg'] =   utf8_encode($Rows['msg']);
     $i++;
    endforeach;  
    return $respuesta;  
}


 
// public static function vwNewRegistro($nombre)
// {
//     $Datos = $Clase->NewRegistro($nombre);

//     $i=0;
//     foreach ($Datos as $Rows):
//         $respuesta[$i]['id'] =   $Rows['id'];
//         $respuesta[$i]['msg'] =   utf8_encode($Rows['msg']);
//      $i++;
//     endforeach;  
//     return $respuesta;  
// }


/**********************************************************************************************
  LISTADO DE USUARIO
***********************************************************************************************/
}

?>
