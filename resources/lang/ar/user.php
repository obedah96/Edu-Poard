<?php
return [
    'resource' => [
        'label' => 'المستخدم',
        'plural_label' => 'المستخدمين',
    ],
    'fields' => [
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'type' => 'النوع',
        'email_verified_at' => 'تاريخ التحقق من البريد',
        'created_at' => 'تاريخ الإنشاء',
    ],
    'type' => [
        'admin' => 'مشرف',
        'client' => 'عميل',
        'owner' => 'مالك',
    ],
];
