<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow the default convention
    protected $table = 'property_image';

    // Specify the primary key column if it doesn't follow the default convention
    protected $primaryKey = 'image_id';

    // Allow mass assignment for specific columns
    protected $fillable = ['property_id', 'path', 'caption'];

    // Define relationship with the Property model (optional)
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'property_id');
    }
}
