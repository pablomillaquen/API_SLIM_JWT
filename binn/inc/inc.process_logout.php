<?
error_reporting(E_ERROR);
ob_start();



	$_SESSION['Id'] = "0";
	$_SESSION['UserNom'] =  "";
	$_SESSION['UserEmail'] = "";
	$_SESSION['UserAcceso'] = "";
	$_SESSION['UserEsAlumno'] = "";
	//INFORMACION DEL USUARIO	
	$_SESSION['userAgent'] = "";
	$_SESSION['SKey'] = "";
	$_SESSION['IPaddress'] = "";
	$_SESSION['LastActivity'] = "";
	$_SESSION['registered'] = "0";
	
$_SESSION = array();
//Borramos cada cookie que tengamos
setcookie("Id","",time()-3600,"/","");
setcookie("UserNom","",time()-3600,"/","");
setcookie("UserEmail","",time()-3600,"/","");
setcookie("UserAcceso","",time()-3600,"/","");
setcookie("UserEsAlumno","",time()-3600,"/","");

setcookie("userAgent","",time()-3600,"/","");
setcookie("SKey","",time()-3600,"/","");
setcookie("IPaddress","",time()-3600,"/","");
setcookie("LastActivity","",time()-3600,"/","");
setcookie("registered","",time()-3600,"/","");



session_unset();
session_destroy();
session_start();
session_regenerate_id(true);


//session_start();
// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["Id"], $params["UserNom"],
        $params["IPaddress"], $params["LastActivity"]
    );
}

// Finally, destroy the session.
session_destroy();



header('Location: ../../index.php?error=6');// 'INGRESE USUARIO Y CLAVE PARA CONTINUAR';
//exit();
ob_flush();
?>