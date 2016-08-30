 <?php
 //Iniciar una sesión de PHP de una manera segura
function sec_session_start() {
        $session_name = 'sec_session_id'; // Establecer un nombre de sesión personalizado 
        $secure = false; // Set en true si el uso de https
        $httponly = true; // Esto evita que javascript poder acceder el identificador de sesión
 
        //ini_set('session.use_only_cookies', 1); // Fuerzas el utilizar sólo cookies
        $cookieParams = session_get_cookie_params(); // Obtiene las cookies actuales 
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
        session_name($session_name); 	//Establece el nombre de la sesión a la establecida anteriormente.
        session_start(); 				// Inicia la session
        session_regenerate_id(true); 	// regenerar la sesión, borrar el anterior   
		
		
}
//include 'logErrores.php';

//$GLOBALS["Ruta"] = 'C:/xampp/htdocs/notasnew/';

// formatear una fecha de tipo datetime
// @uthor: Robert Galeano Fernandez - rgfpy - www.sourcepy.com
#Convierte fecha con el metodo publico de php datetime::format
function formato_fecha($fecha, $formato = 'j-m-Y H:i'){
	$fecha = str_replace("/", "-", $fecha); //reemplazamos el separador a guión medio (-)
	
	if($fecha){
	$class_date = new DateTime($fecha);
	return $class_date->format($formato);
	} else {
	return '';
	}
}



function limpiarString($string) //función para limpiar strings
   {
      $string = strip_tags($string);
      $string = htmlentities($string);
      return stripslashes($string);  
   }
   
function cleanString($string)
{
    $string=trim($string);
    $string=mysql_escape_string($string);
	$string=htmlspecialchars($string);
	
    return $string;
}
function quitarAcentos($text)
	{
		$text = htmlentities($text, ENT_QUOTES, 'UTF-8');
		$text = strtolower($text);
		$patron = array (
			// Espacios, puntos y comas por guion
			'/[\., ]+/' => '-',
 
			// Vocales
			'/&agrave;/' => 'a',
			'/&egrave;/' => 'e',
			'/&igrave;/' => 'i',
			'/&ograve;/' => 'o',
			'/&ugrave;/' => 'u',
 
			'/&aacute;/' => 'a',
			'/&eacute;/' => 'e',
			'/&iacute;/' => 'i',
			'/&oacute;/' => 'o',
			'/&uacute;/' => 'u',
 
			'/&acirc;/' => 'a',
			'/&ecirc;/' => 'e',
			'/&icirc;/' => 'i',
			'/&ocirc;/' => 'o',
			'/&ucirc;/' => 'u',
 
			'/&atilde;/' => 'a',
			'/&etilde;/' => 'e',
			'/&itilde;/' => 'i',
			'/&otilde;/' => 'o',
			'/&utilde;/' => 'u',
 
			'/&auml;/' => 'a',
			'/&euml;/' => 'e',
			'/&iuml;/' => 'i',
			'/&ouml;/' => 'o',
			'/&uuml;/' => 'u',
 
			'/&auml;/' => 'a',
			'/&euml;/' => 'e',
			'/&iuml;/' => 'i',
			'/&ouml;/' => 'o',
			'/&uuml;/' => 'u',
 
			// Otras letras y caracteres especiales
			'/&aring;/' => 'a',
			'/&ntilde;/' => 'n',
 
			// Agregar aqui mas caracteres si es necesario
 
		);
 
		$text = preg_replace(array_keys($patron),array_values($patron),$text);
		return $text;
	}
//#############################################################################3

//#############################################################################
//Esta función será comprobar el correo electrónico y la contraseña de la base de datos, devolverá verdadero si hay una coincidencia
/* 
function login($User,$Pass)
{
	 //if ($stmt = $mysqli->prepare("SELECT id, username, password, salt, nombre FROM members WHERE email = ? LIMIT 1")) { 
	
	
	 GENERACION DEL MENU  

include_once ("clasePersonas.php");
$view= new stdClass(); // creo una clase standard para contener la vista
$view->Login=Persona::getPersonaLogin(0); // Retorna los padre

	foreach ($view->Login as $ItemLogin): 

		$_SESSION['UserNom'] = $ItemLogin['MEN_Nombre'] ." " .$ItemLogin['PER_ApePat'] ." " .$ItemLogin['PER_ApeMat'];
		$_SESSION['UserEmail'] = $ItemLogin['PER_Email'];
		$_SESSION['UserAcceso'] = $ItemLogin['PER_Acceso'];
		$_SESSION['UserEsAlumno'] = $ItemLogin['PER_EsAlumno'];
		
		$cont= $cont+1;
	endforeach;    
	

	if ($cont >= 1)
	{
		return true;	
	}else{
		return false;
	}

}
*/
/*
function login($email, $password, $mysqli) {
   // Using prepared Statements means that SQL injection is not possible. 
   if ($stmt = $mysqli->prepare("SELECT id, username, password, salt, nombre FROM members WHERE email = ? LIMIT 1")) { 
      $stmt->bind_param('s', $email); // Bind "$email" to parameter.
      $stmt->execute(); // Execute the prepared query.
      $stmt->store_result();
      $stmt->bind_result($user_id, $username, $db_password, $salt, $nombre); // get variables from result.
      $stmt->fetch();
      $password = hash('sha512', $password.$salt); // hash the password with the unique salt.
 
      if($stmt->num_rows == 1) { // If the user exists
         // We check if the account is locked from too many login attempts
         if(checkbrute($user_id, $mysqli) == true) { 
            // Account is locked
            // Send an email to user saying their account is locked
            return false;
         } else {
         if($db_password == $password) { // Check if the password in the database matches the password the user submitted. 
            // Password is correct!
 
 
               $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
 
               $user_id = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
               $_SESSION['user_id'] = $user_id; 
               $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
               $_SESSION['username'] = $username;
			   $_SESSION['nombre'] = $nombre;
			   
               $_SESSION['login_string'] = hash('sha512', $password.$user_browser);
               // Login successful.
               return true;    
         } else {
            // Password is not correct
            // We record this attempt in the database
            $now = time();
            $mysqli->query("INSERT INTO login_attempts (user_id, time) VALUES ('$user_id', '$now')");
            return false;
         }
      }
      } else {
         // No user exists. 
         return false;
      }
   }
}
*/
//#############################################################################
// Solo permite 5 intentos, es para chequear que un Hacker no haga pruebas de Fuerza bruta intentando hacer login 1000 veces por ejemplo
function checkbrute($user_id, $mysqli) {
   // Get timestamp of current time
   $now = time();
   // All login attempts are counted from the past 2 hours. 
   $valid_attempts = $now - (2 * 60 * 60); 
 
   if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) { 
      $stmt->bind_param('i', $user_id); 
      // Execute the prepared query.
      $stmt->execute();
      $stmt->store_result();
      // If there has been more than 5 failed logins
      if($stmt->num_rows > 5) {
         return true;
      } else {
         return false;
      }
   }
}

//#############################################################################
//Hacemos la Verificacion utilizando la Información que tiene el Navegador
function login_check($mysqli) {
   // Check if all session variables are set
   if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
     $user_id = $_SESSION['user_id'];
     $login_string = $_SESSION['login_string'];
     $username = $_SESSION['username'];
 
     $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
 
     if ($stmt = $mysqli->prepare("SELECT password FROM members WHERE id = ? LIMIT 1")) { 
        $stmt->bind_param('i', $user_id); // Bind "$user_id" to parameter.
        $stmt->execute(); // Execute the prepared query.
        $stmt->store_result();
 
        if($stmt->num_rows == 1) { // If the user exists
           $stmt->bind_result($password); // get variables from result.
           $stmt->fetch();
           $login_check = hash('sha512', $password.$user_browser);
           if($login_check == $login_string) {
              // Logged In!!!!
              return true;
           } else {
              // Not logged in
              return false;
           }
        } else {
            // Not logged in
            return false;
        }
     } else {
        // Not logged in
        return false;
     }
   } else {
     // Not logged in
     return false;
   }
}





?>