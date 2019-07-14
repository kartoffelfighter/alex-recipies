<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../../class/user.php';
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

$user->token = $data->token;

$token  = isset($data->token) ? $data->token : "";



// token login
try {
    if (!$token) {
        throw new Exception('token invalid, no token sent!');
    }

    $user->token = $token;

    if (!$user->validateToken()) {       // check if the token is stored in the database
        throw new Exception('token invalid, no token like this stored.');
    }
    $decoded = JWT::decode($token, $key, $alg);

    // check if token is already expired

    if ($decoded->data->expires < time()) {
        throw new Exception('token expired');
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

$user->id = $decoded->data->id;
$user->firstname = isset($data->firstname) ? $data->firstname : $decoded->data->firstname;
$user->lastname  = isset($data->lastname) ? $data->lastname : $decoded->data->lastname;
$user->email = isset($data->email) ? $data->email : $decoded->data->email;
$user->password = isset($data->password) ? $data->password : null;

if ($user->update()) {

    // generate new jwt:

    $token = array(
        "iss" => $iss,
        "aud" => $aud,
        "iat" => $iat,
        "nbf" => $nbf,
        "data" =>
        array(
            "id" => $user->id,
            "firstname" => $user->firstname,
            "lastname" => $user->lastname,
            "email" => $user->email,
            "expires" => strtotime("+ " . $valid_login_time . " days")
        )
    );

    $jwt = JWT::encode($token, $key);

    $user->token = $jwt;
    $user->updateToken();   // write new token to database


    http_response_code(200);
    echo json_encode(
        array(
            "bool" => true,
            "message" => "New parameters have been stored.",
            "token" => $jwt
        )
    );
} else {
    http_response_code(500);
    echo json_encode(
        array(
            "bool" => false,
            "message" => "Error while storing the new user data",
            "error" => $user->error
        )
    );
}
