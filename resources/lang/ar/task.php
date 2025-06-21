<?php
return [
    'resource' => [
        'label' => 'المهام',
        'plural_label' => 'المهام',
    ],
    'fields' => [
        'name' => 'اسم المهمة',
        'description' => 'الوصف',
        'status' => 'الحالة',
        'priority' => 'الأولوية',
        'due_date' => 'تاريخ الاستحقاق',
        'assigned_to' => 'مكلف به',
        'created_by' => 'تم إنشاؤه بواسطة',
        'created_at' => 'تاريخ الإنشاء',
    ],
    'status' => [
        'pending' => 'معلق',
        'in_progress' => 'قيد التنفيذ',
        'completed' => 'مكتمل',
        'cancelled' => 'ملغى',
    ],
    'priority' => [
        'low' => 'منخفض',
        'medium' => 'متوسط',
        'high' => 'عالي',
    ],
];
