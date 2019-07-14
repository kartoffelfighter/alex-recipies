<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../../class/user.php';
include_once '../../class/recipe.php';
include_once '../../config/config.php';
include_once '../../config/database.php';

// jwt:
include_once '../../lib/php-jwt-master/src/BeforeValidException.php';
include_once '../../lib/php-jwt-master/src/ExpiredException.php';
include_once '../../lib/php-jwt-master/src/JWT.php';
include_once '../../lib/php-jwt-master/src/SignatureInvalidException.php';

use \Firebase\JWT\JWT;

$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->getConnection();

$user = new USER($db, $password_algorithmus);
$recipe = new RECIPE($db);

$token  = isset($data->token) ? $data->token : false;

// token login
try {
    if ($token === false) {
        throw new Exception('No token sent!');
    }

    $user->token = $token;

    if (!$user->validateToken()) {       // check if the token is stored in the database
        throw new Exception('No token like this stored.');
    }
    $decoded = JWT::decode($token, $key, $alg);

    // check if token is already expired

    if ($decoded->data->expires < time()) {
        throw new Exception('Token expired');
    }
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(
        array(
            "bool" => false,
            "message" => "Access denied, token invalid",
            "error" => $e->getMessage()
        )
    );
    die();
}

$list = $recipe->list();

if ($list) {
    http_response_code(200);
    echo json_encode(
        array(
            "bool" => true,
            "data" => $list
        )
    );
} else {
    http_response_code(401);
    echo json_encode(
        array(
            "bool" => false,
            "message" => "Something failed while searching for a list of recipes",
            "error" => $recipe->error
        )
    );
}
