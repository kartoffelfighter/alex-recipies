<?php

// error reporting
// development:
//ini_set('display_errors','1');
//error_reporting(E_ALL);
// production:
error_reporting(0);

define("VERSION", "1.0");

// timezone
date_default_timezone_set('Europe/Berlin');

$default_language = "en";

// Settings for JSON WEB TOKEN user identification
// do not change these vars
$key = "wqWNi8rql2";
$iss = "alex-recipes";
$aud = "alex-recipes";
$iat = 1356999524;
$nbf = 1357000000;
$alg = array("HS256");

// valid time for login (in days)
$valid_login_time = 7;

// base url to api 
$base_url = "http://localhost/api/v1/";

$password_algorithmus = PASSWORD_DEFAULT;