<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../../class/user.php';
include_once '../../config/config.php';
include_once '../../config/database.php';

$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->getConnection();

$user = new USER($db, $password_algorithmus);

$user->token = $data->token;    // this is the currently logged in users token

// this is the new users information
$user->email = $data->email;
$user->password = $data->password;
$user->firstname = $data->firstname;
$user->lastname = $data->lastname;

if($user->create()){
    http_response_code(201);
    echo json_encode(
        array(
            "bool" => true,
            "message" => "User successfully created",
            "id" => $user->id,
        )
    );
} else {
    http_response_code(400);
    echo json_encode(
        array(
            "bool" => false,
            "message" => "Error while creating user",
            "error" => $user->error,
        )
    );
}