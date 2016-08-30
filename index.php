<?php
//use \Psr\Http\Message\ServerRequestInterface as Request;
//use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;
require 'vendor/autoload.php';

//Obtiene los valores ambientales mediante el uso de la librería Dotenv
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();



$config = [
    'settings' => [
        //'displayErrorDetails' => true,
        'displayErrorDetails' => false,
        'logger' => [
            'name' => 'slim-app',
            'level' => Monolog\Logger::DEBUG,
            'path' => __DIR__ . '/../logs/app.log',
        ],
    ],
];

$c = new \Slim\Container($config);
$app = new \Slim\App($c);

//$app = new Slim\App($config);
/******************************************************************/
//CONFIGURACION
/******************************************************************/
//require __DIR__ . "/binn/inc/conf.sql.php";


include ("binn/templates/maquinas.php");
include ("binn/templates/marcas.php");

//Definiendo las variables de la autenticación con JWT
$app->add(new \Slim\Middleware\JwtAuthentication([
     "path"     => "/",
     "algorithm" => ["HS256"],
     "secure" => false,
    //"secure" => true, //Indico que usaré HTTPS, en la segunda línea indico las excepciones a esto
    "relaxed" => ["localhost"], //Indico que servidor no cumplirá con la regla anterior.
    "secret" => getenv("JWT_SECRET"), //La palabra secreta que enviaré para autenticar mi token recibido.
    //"secret"   => "1dfg2gsd34gsdf56fg7bhrc534gdf4gvc35fdg4fg5",
    "rules"    => [
          new \Slim\Middleware\JwtAuthentication\RequestPathRule([
               "path"        => "/",
               "passthrough" => ["/hello", "/sesion/crear"]
               ]),
        new \Slim\Middleware\JwtAuthentication\RequestMethodRule([
            "passthrough" => ["OPTIONS"]
        ])
     ],
    "callback" => function ($options) use ($app) {
        $app->jwt = $options["decoded"];
    },
    "error" => function ($request, $response, $arguments) {
        return $response->write("Error: No fue posible ingresar.");
    }
]));


//Se requiere coonfigurar CORS para envío de datos entre diferentes dominios
$app->add(new \Tuupola\Middleware\Cors([
    "origin" => ["*"],
    "methods" => ["GET","OPTIONS", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => ["Authorization", "X-Requested-With", "content-type","accept"],
    "headers.expose" => ["Etag"],
    "credentials" => true,
    "cache" => 86400
]));

/*function DBConnection(){
    return new PDO('mysqli:dbhost=localhost;dbname=dbcontrolmaquinas','root','');
}*/
$dsn = 'mysql:host=localhost;dbname=dbcontrolmaquinas;charset=utf8';
$usr = 'root';
$pwd = '';

$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);


/******************************************************************/
//ROUTES
/******************************************************************/
$app->get('/', function ($request, $response) {
	$body = $response->getBody();
	$body->write(json_encode(array('estado'=>true,'mensaje'=>'API Sistema Gestion de Maquinas','version'=>1.2)));
	return $response->withHeader('Content-Type','application/json')->withBody($body);
});

/**********************************************************************
LOGIN
*********************************************************************/
$app->post('/sesion/crear', function ($request, $response, $args) use ($app,$pdo) {
    $allPostPutVars = $request->getParsedBody();
    $form_data = $allPostPutVars;
    $e = $form_data['email'];
    $p = $form_data['password'];
    //$p = sha1($p); //La password debe estar codificada en sha1, de lo contrario, comentar esta línea
    
    //Obtengo los datos de la db
    $selectStatement = $pdo->select()
                       ->from('GCA_EMPleados')
                       //->whereMany(array('EMP_User'=>'".$u."','EMP_Pass'=>'".$p."'),'=');
                       //->whereMany(array('EMP_User'=>:email,'EMP_Pass'=>:password),'=');
                       ->where('EMP_User','=',$e);
                       //->where('EMP_Pass','=',$p);
                       //->whereMany(array('EMP_User' => $e, 'EMP_Pass' => $p), '=',);
    //$selectStatement->bindParam(':email', $e);
    //$selectStatement->bindParam(':password', $p);
    $stmt = $selectStatement->execute();
    $data = $stmt->fetch();
    //print_r($data);
    //Comparo los datos y conecto
    if ($data) {
        if($data['EMP_Pass']==$p){
            $key = getenv("JWT_SECRET");
            $token = array(
                "id" => $data['EMP_Id'],
                "Nombres" => $data['EMP_Nombres'],
                "ApePat" => $data['EMP_ApePat'],
                "ApeMat" => $data['EMP_ApeMat'],
                "Acceso" => $data['EMP_Acceso'],
                "exp" => time() + (60)
            );
            $jwt = JWT::encode($token, $key);
            $response->withHeader('Content-type', 'application/json');
            echo json_encode(array("token" => $jwt));
        }
    }else{
        //return echo "No es posible conectar con el servidor, compruebe sus credenciales";
        return json_encode(array('data'=>'Error'));
    }
});




//____________________________________________________________________________
//MAQUINAS  linea 40
$oMaq = new clsMaquinasVW();

$app->group('/maquinas', function () use($app, $oMaq){

    $this->get('/', function ($req, $res, $args) use($app, $oMaq){
        $body = $res->getBody();
        $body->write(json_encode(array($oMaq->vwLista(0))));
	return $res->withHeader('Content-Type','application/json;charset=utf-8');
    });
    $this->get('/{id}', function ($req, $res, $args) use($app, $oMaq){
    	$body = $res->getBody();
        $body->write( json_encode(array($oMaq->vwLista($args['id']))) );
        return $res->withHeader('Content-Type','application/json;charset=utf-8');
    });

});



/*
$app->get('/maquinas', function ($request, $response) use($app, $oMaq) {
    try
    {
	$body = $response->getBody();
        $body->write( json_encode(array($oMaq->vwLista(0))) ); 

    return $response->withHeader('Content-Type','application/json;charset=utf-8');
    } catch(Exception $e) { $app->response()->setStatus(404); echo '{"error":{"text":'. $e->getMessage() .'}}'; }
});


$app->get('/maquin/{id}', function ($req, $res, $args) use($app, $oMaq) {
    try
    {
$um = new  UserModel();     
   $body = $response->getBody();
       // $id = $request->getAttribute('id');
	$body->write( json_encode(array( $oMaq->vwLista($um->Get($args['id'])) )) );

    return $response->withHeader('Content-Type','application/json;charset=utf-8');
    } catch(Exception $e) { $app->response()->setStatus(404); echo '{"error":{"text":'. $e->getMessage() .'}}'; }
});

$app->post('/maquinas', function ($request, $response) use($app) {
   try
   {
        $oClase = new clsMaquinasVW();
        $body = $response->getBody();
        $body->write( json_encode(array($oClase->vwLista(0))) );

   return $response->withHeader('Content-Type','application/json;charset=utf-8');
   } catch(Exception $e) { $app->response()->setStatus(404); echo '{"error":{"text":'. $e->getMessage() .'}}'; }
});
*/
//____________________________________________________________________________
//MARCAS

/*
$app->get('/maquinas/{id:[0-9]+}', function ($request, $response) {
        echo $response->write(json_encode(array('estado'=>true,'mensaje'=>'API Sistema de Reservas de Canchas','version'=>1)));
    return $response;
});
*/

/*$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});
*/

$app->get('/hello', function ($request, $response, $args) use($app) {
    //$name = $request->getAttribute('name');
    $response->getBody()->write("Hola, al fin funciono!");

    return $response;
});



//$app->response()->header("Content-Type", "application/json");
/******************************************************************/
$app->run();
/******************************************************************/







?>
