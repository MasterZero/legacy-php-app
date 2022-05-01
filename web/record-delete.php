<?php


include __DIR__ . '/../autoload.php';



use TestApp\Auth;
use TestApp\Model\Record;


if (!Auth::user()) {
    return jsonResponse(['error' => 'not auth']);
}


$record = Record::find(isset($_POST['id']) ? $_POST['id'] : '');
if (!$record) {
    return jsonResponse(['error' => 'no such record by id']);
}
$record->delete();
return jsonResponse(['status' => 'OK']);
