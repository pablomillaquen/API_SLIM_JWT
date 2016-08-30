<?php

class ErrorMsg {
    public static function display($mensaje, $tipo = 0, $nombreDeClase = 'alert', $titulo = '') {
        $tipos = array(array('¡Advertencia!', 'block'), array('Error', 'error'), array('¡Ok!', 'success'), array('Información', 'info'));
        return '<div class="'.$nombreDeClase.' alert-'.$tipos[$tipo][1].'">
            <a class="close" data-dismiss="alert" href="#">×</a>
            <h4 class="alert-heading">'.((empty($titulo)) ? $tipos[$tipo][0] : $titulo).'</h4>
            '.$mensaje.'</div>';
    }
}

class Error
{
static $ErrorHolder;

	static function init($new)	{
		self::$ErrorHolder  =$new;
	}
	
	static function Exception($Indice)
	{
		/***********************************************/
		switch (self::$ErrorHolder) {
		case 1:
        	$error = 'INGRESE USUARIO Y CLAVE PARA CONTINUAR';
        	break;
    	case 2:
			$error = 'ERROR DE AUTENTIFICACION';
			break;
		case 3:
			$error = 'PROBLEMAS CON EL SERVIDOR';
			break;
	    case 4:
			$error = 'NO ESTA AUTORIZADO PARA VISITAR ESTA PAGINA';
			break;
		case 5:
			$error = 'INVALID REQUEST';
			break;
		case 6:
			$error = 'HASTA LUEGO';
			break;
		/*case 7:
			$error = 'PROBLEMAS CON EL SERVIDOR';
			break;
		case 8:
			$error = 'PROBLEMAS CON EL SERVIDOR';
			break;
		case 9:
			$error = 'PROBLEMAS CON EL SERVIDOR';
			break;
		case 10:
			$error = 'PROBLEMAS CON EL SERVIDOR';
			break;
		case 11:
			$error = 'PROBLEMAS CON EL SERVIDOR';
			break;*/
										
		default:
		   $error = "";
		}
		/***********************************************/
		return $error; 		
	}
	
	
	static function MsgAlerta($Indice)
	{
		/***********************************************/
		switch (self::$ErrorHolder) {
		case 0:
        	$error = 'ACCESO CORRECTO, BIENVENIDO ';
        	break;	
		case 1:
        	$error = 'REGISTRO INGRESADO CORRECTAMENTE';  	//
        	break;
    	case 2:
			$error = 'REGISTRO ACTUALIZADO CORRECTAMENTE';  //
			break;
		case 3:
			$error = 'REGISTRO ELIMINADO CORRECTAMENTE';  //
			break;
	    case 11:
			$error = 'ERROR AL INGRESAR EL REGISTRO';
			break;
		case 12:
			$error = 'ERROR AL ACTUALIZAR EL REGISTRO';
			break;
		case 13:
			$error = 'ERROR AL ELIMINAR EL REGISTRO';
			break;
		
										
		default:
		   $error = "";
		}
		/***********************************************/
		return $error; 		
	}
	
	
}

?>
