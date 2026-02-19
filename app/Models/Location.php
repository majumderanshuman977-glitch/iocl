<?php

namespace App\Models;

use App\Models\CylinderCategories;
use App\Models\LocationCylinderCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';


    public function locationCylinderCategories()
    {
        return $this->hasMany(LocationCylinderCategory::class, 'location_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
