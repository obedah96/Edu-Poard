<?php

// app/Models/Document.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'document_date',
        'version',
        'type',
        'service_type',
        'file_path',
        'file_size_bytes',
        'uploaded_by',
        'is_active',
        'notes',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
