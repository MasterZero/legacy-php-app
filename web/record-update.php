<?php


include __DIR__ . '/../autoload.php';



use TestApp\Auth;
use TestApp\Model\Record;


if (!Auth::user()) {
    return jsonResponse(['error' => 'not auth']);
}


$record = Record::find($_POST['id'] ?? '');

if (!isset($_POST['name'])) {
    return jsonResponse(['error' => ' name variable is not set']);
}

if (!isset($_POST['description'])) {
    return jsonResponse(['error' => ' description variable is not set']);
}

if (!isset($_POST['parent_id'])) {
    return jsonResponse(['error' => ' parent_id variable is not set']);
}


if (!$record) {
    return jsonResponse(['error' => 'no such record by id']);
}


/**
 * @TODO: add check is parent id is correct
 */

$record->update([
    'parent_id' => $_POST['parent_id'],
    'name' => $_POST['name'],
    'description' => $_POST['description'],
]);



return jsonResponse(['status' => 'OK']);
