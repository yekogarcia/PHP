<?php

//Autentication por  http
// $user = array_key_exists('PHP_AUTH_USER', $_SERVER) ? $_SERVER['PHP_AUTH_USER'] : '';
// $pwd = array_key_exists('PHP_AUTH_PW', $_SERVER) ? $_SERVER['PHP_AUTH_PW'] : '';

//AUTH HMAC
// if (
//     !array_key_exists('HTTP_X_HASH', $_SERVER) ||
//     !array_key_exists('HTTP_X_TIMESTAMP', $_SERVER) ||
//     !array_key_exists('HTTP_X_UID', $_SERVER)
// ) {
//     die;
// }
// list($hash, $uid, $timestamp) = [
//     $_SERVER["HTTP_X_HASH"],
//     $_SERVER["HTTP_X_TIMESTAMP"],
//     $_SERVER["HTTP_X_UID"]
// ];
// $secret = "prueba";

// $newHash = sha1($uid . $timestamp . $secret);

// if ($newHash != $hash) {
//     die;
// }


// AUTH ACCESS TOKEN
if (!array_key_exists('HTTP_X_TOKEN', $_SERVER)) {
    die;
}

$url = "http://apirest.local/";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-Token: {$_SERVER['HTTP_X_TOKEN']}"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$ret = curl_exec($ch);

if($ret !== 'true'){
    die;
}

$allowedResourceTypes = [
    'books',
    'authors',
    'generes'
];

$resourceType = $_GET['resource_type'];

if (!in_array($resourceType, $allowedResourceTypes)) {
    die;
}

$books = [
    1 => [
        'titulo' => 'Lo que el viento se llevo',
        'id_autor' => 2,
        'id_genero' => 2,
    ],
    2 => [
        'titulo' => 'La Iliada',
        'id_autor' => 1,
        'id_genero' => 1,
    ],
    3 => [
        'titulo' => 'La Odisea',
        'id_autor' => 1,
        'id_genero' => 1,
    ],
];

header('Content-Type: application/json');

$resourceId = array_key_exists('resource_id', $_GET) ? $_GET['resource_id'] : "";


switch (strtoupper($_SERVER['REQUEST_METHOD'])) {
    case 'GET';
        if (empty($resourceId)) {
            echo json_encode($books);
        } else {
            if (array_key_exists($resourceId, $books)) {
                echo json_encode($books[$resourceId]);
            }
        }
        break;
    case 'POST';
        $json = file_get_contents(('php://input'));
        $books[] = json_decode($json, true);
        echo array_keys($books)[count($books) - 1];
        break;
    case 'PUT';
        if (!empty($resourceId) && array_key_exists($resourceId, $books)) {
            $json = file_get_contents(('php://input'));
            $books[$resourceId] = json_decode($json, true);
            echo json_encode($books);
        }
        break;
    case 'DELETE';
        if (!empty($resourceId) && array_key_exists($resourceId, $books)) {
            unset($books[$resourceId]);
            echo json_encode($books);
        }
        break;
}
