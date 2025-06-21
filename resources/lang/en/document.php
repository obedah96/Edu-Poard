<?php
return [
    'resource' => [
        'label' => 'Document',
        'plural_label' => 'Documents',
    ],
    'fields' => [
        'client' => 'Client',
        'name' => 'Document Name',
        'document_date' => 'Document Date',
        'version' => 'Version',
        'type' => 'Type',
        'service_type' => 'Service Type',
        'file_path' => 'File Path',
        'uploaded_by' => 'Uploaded By',
        'is_active' => 'Active',
        'notes' => 'Notes',
        'file_upload_helper' => 'Upload the document file',
        'created_at' => 'Created At',
    ],
    'types' => [
        'proposal' => 'Proposal',
        'contract' => 'Contract',
        'invoice' => 'Invoice',
        'report' => 'Report',
        'presentation' => 'Presentation',
        'certificate' => 'Certificate',
        'other' => 'Other',
    ],
    'service_types' => [
        'software' => 'Software',
        'design' => 'Design',
        'marketing' => 'Marketing',
        'business' => 'Business',
    ],
    'actions' => [
        'download' => 'Download',
    ],
];
