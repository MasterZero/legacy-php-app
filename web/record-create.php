<?php


include __DIR__ . '/../autoload.php';



use TestApp\Auth;
use TestApp\Model\Record;


if (!Auth::user()) {
    return jsonResponse(['error' => 'not auth']);
}


if (!isset($_POST['name'])) {
    return jsonResponse(['error' => ' name variable is not set']);
}

if (!isset($_POST['description'])) {
    return jsonResponse(['error' => ' description variable is not set']);
}

if (!isset($_POST['parent_id'])) {
    return jsonResponse(['error' => ' parent_id variable is not set']);
}



/**
 * @TODO: add check is parent id is correct
 */

Record::create([
    'parent_id' => $_POST['parent_id'],
    'name' => $_POST['name'],
    'description' => $_POST['description'],
]);



return jsonResponse(['status' => 'OK']);
