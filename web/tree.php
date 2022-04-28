<?php


include __DIR__ . '/../autoload.php';

use TestApp\DB;
use TestApp\Model\Record;



jsonResponse(Record::asTree());


