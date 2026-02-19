<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //

    public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}
}
