<?php
return [
    'resource' => [
        'label' => 'وثيقة',
        'plural_label' => 'الوثائق',
    ],
    'fields' => [
        'client' => 'العميل',
        'name' => 'اسم الوثيقة',
        'document_date' => 'تاريخ الوثيقة',
        'version' => 'الإصدار',
        'type' => 'النوع',
        'service_type' => 'نوع الخدمة',
        'file_path' => 'مسار الملف',
        'uploaded_by' => 'تم رفعها بواسطة',
        'is_active' => 'نشطة',
        'notes' => 'الملاحظات',
        'file_upload_helper' => 'رفع ملف الوثيقة',
        'created_at' => 'تاريخ الإنشاء',
    ],
    'types' => [
        'proposal' => 'اقتراح',
        'contract' => 'عقد',
        'invoice' => 'فاتورة',
        'report' => 'تقرير',
        'presentation' => 'عرض',
        'certificate' => 'شهادة',
        'other' => 'آخر',
    ],
    'service_types' => [
        'software' => 'برمجيات',
        'design' => 'تصميم',
        'marketing' => 'تسويق',
        'business' => 'أعمال',
    ],
    'actions' => [
        'download' => 'تحميل',
    ],
];
