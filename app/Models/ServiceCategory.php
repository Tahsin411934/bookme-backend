<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    // Specify the table name if it is not the pluralized form of the model name
    protected $table = 'service_category';  // In case the table name doesn't follow the default pluralization rule.

    // Specify the primary key if it's different from 'id'
    protected $primaryKey = 'category_id';  // If your primary key is not 'id'

    // Set this to false since you're managing 'created_at' and 'updated_at' manually
    public $timestamps = true; 

    // Define the fields that are mass assignable
    protected $fillable = [
        'category_name', 
        'description', 
        'img', 
        'serialno', 
        'isactive', 
        
    ];

    // Optionally, you can define any custom attributes or methods here
}
