<?php

include 'autoload.php';

use TestApp\DB;
use TestApp\Auth;


$users = [
    [
        'login' => 'admin',
        'password' => Auth::hash('heallyhardpassword1337'),
    ],
    [
        'login' => 'admin2',
        'password' => Auth::hash('heallyhardpassword1337_2'),
    ],
    [
        'login' => 'admin3',
        'password' => Auth::hash('heallyhardpassword1337_3'),
    ],
];


$records = [
    [
        'data' => [
            'name' => 'Animals',
            'description' => 'Animals category',
        ],
        'childrens' => [
            [
                'data' => [
                    'name' => 'Birds',
                    'description' => 'Birds category',
                ],
                'childrens' => [
                    [
                        'data' => [
                            'name' => 'Flying birds',
                            'description' => 'Flying birds category',
                        ],
                        'childrens' => [],
                    ],
                    [
                        'data' => [
                            'name' => 'Non-flying birds',
                            'description' => 'Non-flying birds category',
                        ],
                        'childrens' => [],
                    ],
                ],
            ],
            [
                'data' => [
                    'name' => 'Land animals',
                    'description' => 'land category',
                ],
                'childrens' => [],
            ],
            [
                'data' => [
                    'name' => 'Fish',
                    'description' => 'fish category',
                ],
                'childrens' => [],
            ],
        ],
    ],
    [
        'data' => [
            'name' => 'Plants',
            'description' => 'Plants category',
        ],
        'childrens' => [
            [
                'data' => [
                    'name' => 'Trees',
                    'description' => 'Birds category',
                ],
                'childrens' => [
                    [
                        'data' => [
                            'name' => 'Binary',
                            'description' => 'binary category',
                        ],
                        'childrens' => [],
                    ],
                    [
                        'data' => [
                            'name' => 'Nested sets',
                            'description' => 'Nested sets category',
                        ],
                        'childrens' => [],
                    ],
                    [
                        'data' => [
                            'name' => 'Simple',
                            'description' => 'Simple tree category',
                        ],
                        'childrens' => [],
                    ],
                ],
            ],
            [
                'data' => [
                    'name' => 'Grass',
                    'description' => 'Grass category',
                ],
                'childrens' => [],
            ],
            [
                'data' => [
                    'name' => 'Seaweed',
                    'description' => 'Seaweed category',
                ],
                'childrens' => [],
            ],
        ],
    ],
];

foreach($users as $user) {
    DB::insert('users', $user);
}


function insert_nested_record($records_array, $parent_id = null)
{
    foreach($records_array as $record) {
        $data = $record['data'];
        if (!is_null($parent_id)) {
            $data['parent_id'] = $parent_id;
        }
        $current_id = DB::insert('records', $data);
        insert_nested_record($record['childrens'], $current_id);
    }
}


insert_nested_record($records);

