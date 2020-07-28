<?php

return [
    'roles' => ['root', 'admin', 'customer', 'customer_service'],

    'permissions' => [
        'backend.gift.index' => ['root', 'admin'],
        'backend.gift.show' => ['root', 'admin'],
        'backend.user.index' => ['root', 'admin'],
        'backend.user.show' => ['root', 'admin']
    ],
];
