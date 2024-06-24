<?php

$matches = [];
// error_log(print_r($_SERVER['PATH_INFO']));
// error_log(print_r($_SERVER["REQUEST_URI"]));
// error_log(print_r(preg_match('/\/([^\/]+)\/([^\/]+)/', $_SERVER["REQUEST_URI"], $matches)));
if (preg_match('/\/([^\/]+)\/([^\/]+)/', $_SERVER["REQUEST_URI"], $matches)) {
    $_GET['resource_type'] = $matches[1];
    $_GET['resource_id'] = $matches[2];
    error_log(print_r($matches, 1));
    require 'server.php';
} else if (preg_match('/\/([^\/]+)\/?/', $_SERVER["REQUEST_URI"], $matches)) {
    $_GET['resource_type'] = $matches[1];
    error_log(print_r($matches, 1));
    require 'server.php';
} else {
    error_log('No matches');
    http_response_code(404);
}
