<?php

return [
    /**
     * Define the tables and how they should be created.
     * In this example, the 'users' table requires the 'create_users_table' and 'create_roles_table'
     * migrations from the 'User' module to be ran.
     */
    'tables' => [
        'users' => [
            'module' => 'User',
            'migrations' => [
                '2016_04_04_085247_create_users_table',
                '2016_04_04_085523_create_roles_table',
            ],
        ],
    ],
];
