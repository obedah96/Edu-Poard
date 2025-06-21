<?php
return [
    'resource' => [
        'label' => 'Tasks',
        'plural_label' => 'Tasks',
    ],
    'fields' => [
        'name' => 'Task Name',
        'description' => 'Description',
        'status' => 'Status',
        'priority' => 'Priority',
        'due_date' => 'Due Date',
        'assigned_to' => 'Assigned To',
        'created_by' => 'Created By',
        'created_at' => 'Created At',
    ],
    'status' => [
        'pending' => 'Pending',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ],
    'priority' => [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
    ],
];
