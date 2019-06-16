<?php

return [
    'result' => [
        'success' => 'success',
        'failure' => 'failed'
    ],
    'user_roles' => [
        'user' => 'User',
        'admin' => 'Admin'
    ],
    'user_functions' => [
        'user' => ['Contributor','Educator','Subscriber','Demo'],
        'admin' => ['Editor', 'Chief Editor']
    ],
    'statuses' => [
        'controlling' => 'Controlling',
        'not_controlling' => 'Not Controlling',
        'reinstated'=> 'Reinstated',
        'repealed' => 'Repealed'
    ],
    'payment_methods' => [
        'paypal' => 'Paypal',
        'google' => 'Google',
        'other' => 'Other'
    ],
    'auth_types' => [
        'google' => 'Google',
        'facebook' => 'Facebook',
        'normal' => 'Normal',
        'multiple' => 'Multiple (Web/App)'
    ],
    'fulltxt_path' => '/files/fulltxts/',
    'version' => '5.0.1'
];

?>
