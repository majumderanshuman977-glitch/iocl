<?php

namespace App\Models;

use App\Models\CylinderCategories;
use App\Models\Location;
use Illuminate\Database\Eloquent\Model;

class LocationCylinderCategory extends Model
{
    protected $table = 'location_cylinder_category';
    protected $fillable = ['location_id', 'cylinder_category_id', 'price'];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(CylinderCategories::class, 'cylinder_category_id', 'id');
    }
}
