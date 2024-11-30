<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $table = 'property';
    
    protected $primaryKey = 'property_id'; // Set the primary key

    public $incrementing = true; // Disable auto-increment if necessary

    protected $keyType = 'int'; // Set key type, e.g., 'string' for UUIDs or 'int' for integers

    protected $fillable = [
        'category_id',
        'destination_id',
        'property_name',
        'description',
        'district_city',
        'address',
        'lat_long',
        'main_img',
        'isactive',
    ];
    // Property.php
public function facilities()
{
    return $this->hasMany(PropertyFacility::class, 'property_id', 'property_id');
}
public function property_uinit()
{
    return $this->hasMany(PropertyUnit::class, 'property_id', 'property_id');
}
public function images()
{
    return $this->hasMany(PropertyUnit::class, 'property_id', 'property_id');
}

public function propertySummaries()
    {
        return $this->hasMany(PropertySummary::class, 'property_id', 'property_id');
    }

}
