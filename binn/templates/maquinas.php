<?Php

include_once ("binn/inc/clsMaquinas.php");
//include_once ("../inc/clsMaquinas.php");  //DEBUG
class clsMaquinasVW
{



function __construct() { }  //  CONSTRUCTOR   

//  METODOS 
public static function vwLista($id)
{
    $Clase=new clsMaquinas();
    $Datos = $Clase->Lista($id);
    $respuesta  = array();

    $i=0;
    foreach ($Datos as $Rows):

	    $respuesta[$i]['idMaquina'] =   $Rows['MAQ_Id'];
        $respuesta[$i]['idProveedor'] =   $Rows['PRO_Id'];
        $respuesta[$i]['CodMaquina'] =   $Rows['MAQ_Codigo'];
	    $respuesta[$i]['patente'] =   utf8_encode($Rows['MAQ_Patente']);
        $respuesta[$i]['TipoCombustible'] =   $Rows['PAR_TipoCombustibe'];
        $respuesta[$i]['NombreMaq'] =   utf8_encode($Rows['PAR_NombreMaq']);
        $respuesta[$i]['IdMarca'] =   $Rows['MAR_Id'];
        $respuesta[$i]['Marca'] =   utf8_encode($Rows['Marca']);
        $respuesta[$i]['IdModelo'] =   $Rows['MOD_Id'];
        $respuesta[$i]['Modelo'] =   utf8_encode($Rows['Modelo']);
        $respuesta[$i]['Ano'] =   $Rows['PAR_Ano'];
        $respuesta[$i]['tcKmsMin'] =   $Rows['MAQ_tcKmsMin'];
        $respuesta[$i]['tcKmsValor'] =   $Rows['MAQ_tcKmsValor'];
        $respuesta[$i]['tcHrsMin'] =   $Rows['MAQ_tcHrsMin'];
        $respuesta[$i]['tcHrsValor'] =   $Rows['MAQ_tcHrsValor'];
        $respuesta[$i]['tcDiaMin'] =   $Rows['MAQ_tcDiaMin'];
        $respuesta[$i]['tcDiaValor'] =   $Rows['MAQ_tcDiaValor'];
        $respuesta[$i]['VencRevTec'] =   $Rows['MAQ_VencRevTec'];
        $respuesta[$i]['ProxMantHrs'] =   $Rows['MAQ_ProxMantHrs'];
        $respuesta[$i]['ProxMantKms'] =   $Rows['MAQ_ProxMantKms'];
        $respuesta[$i]['TipoMantencion'] =   $Rows['PAR_TipoMantencion'];
        $respuesta[$i]['ProxMantencion'] =   $Rows['MAQ_ProxMantencion'];
        $respuesta[$i]['RenHoras'] =   $Rows['MAQ_RenHoras'];
        $respuesta[$i]['RenKms'] =   $Rows['MAQ_RenKms'];
        $respuesta[$i]['RenDia'] =   $Rows['MAQ_RenDia'];
        $respuesta[$i]['EstadoMaq'] =   $Rows['PAR_EstadoMaq'];
        $respuesta[$i]['KmsInicio'] =   $Rows['MAQ_KmsInicio'];
        $respuesta[$i]['KmsActual'] =   $Rows['MAQ_KmsActual'];
        $respuesta[$i]['HrsInicio'] =   $Rows['MAQ_HrsInicio'];
        $respuesta[$i]['HrsActual'] =   $Rows['MAQ_HrsActual'];


     $i++;
    endforeach;  
    return $respuesta;	
}

/**********************************************************************************************
  LISTADO DE USUARIO
***********************************************************************************************/
}

/*
$oMaq = new clsMaquinasVW();
echo json_encode($oMaq->vwLista(0));
*/

?>
