<?php
return [
    'resource' => [
        'label' => 'User',
        'plural_label' => 'Users',
    ],
    'fields' => [
        'name' => 'Name',
        'email' => 'Email',
        'password' => 'Password',
        'type' => 'Type',
        'email_verified_at' => 'Email Verified At',
        'created_at' => 'Created At',
    ],
    'type' => [
        'admin' => 'Admin',
        'client' => 'Client',
        'owner' => 'Owner',
    ],
];
