<?php
ob_start();
include("conf.clsLogin.php");
include("conf.functions.php");
session_start();




if(isset($_POST['user_login'], $_POST['user_pass'])) 
{ 


	if($_POST['user_login'] == '') 
	{ 
		header('Location: ../../index.php?error=1');
	}

	if( !get_magic_quotes_gpc() ) 
	{	
		$Usuario = addslashes( $_POST['user_login']);
		
	}else {	
		$Usuario = $_POST['user_login'];
	}
   		
		$Password = sha1($_POST['user_pass'].'apgca') ; // Aplico encryptado hashed a la Password.
		$Clase = new clsLogin;


		$Item=$Clase->CargaLogin($_POST['user_login'],$Password);
		foreach ($Item as $Rows): 
			$_SESSION['Id'] = $Rows['EMP_Id'];
			$_SESSION['UserNom'] = $Rows['EMP_Nombres'] ." " .$Rows['EMP_ApePat'] ." " .$Rows['EMP_ApeMat'];
			$_SESSION['UserRut'] = $Rows['EMP_Rut'] ." - " .$Rows['EMP_Dv'];
			$_SESSION['UserEmail'] = $Rows['EMP_Email'];
			$_SESSION['UserAcceso'] = $Rows['EMP_Acceso'];
		 endforeach;
		
		if ($_SESSION['UserAcceso'] > "0" || $_SESSION['Id'] > "0" )
		{
			//INFORMACION DEL USUARIO	
			$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
			$_SESSION['SKey'] = uniqid(mt_rand(), true);
			$_SESSION['IPaddress'] = $_SERVER["REMOTE_ADDR"];
			$_SESSION['LastActivity'] = $_SERVER['REQUEST_TIME'];			
			$_SESSION['registered'] = 1;
		
			header('Location: ../../home.php');
			
		}else{
			
			header('Location: ../../index.php?error=2');// 'INGRESE USUARIO Y CLAVE PARA CONTINUAR';
			
			}









}else{
		header('Location: ../../index.php?error=1'); 
}

ob_flush();
?>