<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
