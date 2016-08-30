<?php
include_once ("conf.sql.php"); //Clase con la Configuracion de la Conexion a MySql

class clsLogin{
	function __construct() { }  //  CONSTRUCTOR   

	//  METODOS  
	public static function CargaLogin($User,$Pass){
		$obj_Menu=new sQuery();
		$Sql = "CALL SP_USERValida('" .$User ."','" .$Pass ."');";
		$obj_Menu->executeQuery($Sql);
		$Datos = $obj_Menu->fetchAll();	
	   // $obj_Menu->Clean();   libera la consulta
		return $Datos;	
	}
}





class clsLogin {
 	public function login(){
		if(!$this->input->post("email") || !$this->input->post("password")){
			echo json_encode(array("code" => 1, "response" => "Datos insuficientes"));
			}
		$email = $this->input->post("email");
		$password = sha1($this->input->post("password"));
		$this->load->model("auth_model");
		$user = $this->auth_model->login($email, $password);
		if($user !== false){
			//ha hecho login
			$user->iat = time();
			$user->exp = time() + 300;
			$jwt = JWT::encode($user, '');
			echo json_encode(
				array(
					"code" => 0, 
					"response" => array(
						"token" => $jwt
					)
				)
			);
		}
			
	}
}

?>