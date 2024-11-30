<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyFacility extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'property_facilities';
    // protected $primarykey = 'property_id';
    protected $primaryKey = 'facility_type';
    // Define the fillable attributes
    protected $fillable = [
        'property_id',
        'facility_type',
        'facilty_name',
        'value',
        'img',
        'icon',
        'isactive',
        'serialno',
    ];

    // Enable timestamps (created_at and updated_at)
    public $timestamps = true;

    // Define the relationship if there's a foreign key relationship with the property table
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'property_id');
    }
    public function icons()
    {
        return $this->belongsTo(Icon::class, 'icon', 'id');
    }
}
