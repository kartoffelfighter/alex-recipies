<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
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

$user->token = $data->token;    // this is the currently logged in users token

// this is the new users information
$user->email = $data->email;
$user->password = $data->password;


$token  = isset($data->token) ? $data->token : "";



// token login
if ($token) {
    $user->token = $token;
    if ($user->validateToken()) {       // check if the token is stored in the database
        try {
            $decoded = JWT::decode($token, $key, $alg);
                                                         // check if token is already expired
            if ($decoded->data->expires < time()) {
                throw new Exception('token expired');
            }
            http_response_code(200);
            echo json_encode(
                array(
                    "bool" => true,
                    "message" => "Access granted, TOKEN valid",
                    "data" => $decoded->data,
                )
            );
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(
                array(
                    "bool" => false,
                    "message" => "Access denied, token invalid",
                    "error" => $e->getMessage()
                )
            );
        }
    } else {
        http_response_code(401);
        echo json_encode(
            array(
                "bool" => false,
                "message" => "Access denied, token invalid"
            )
        );
    }
} else {
    // email + password login

    if ($user->login()) {
        // log in the user, generate a token, store the token, give the token and the users information to the requestor

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
                "message" => "Login succeed",
                "token" => $jwt,
            )
        );
    } else {
        http_response_code(401);
        echo json_encode(
            array(
                "bool" => false,
                "messsage" => "Login failed",
                "error" => $user->error,
            )
        );
    }
}
