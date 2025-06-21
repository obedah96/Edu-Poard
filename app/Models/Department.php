<?php
// app/Models/Department.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['service_type'];

    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_department');
    }
}

