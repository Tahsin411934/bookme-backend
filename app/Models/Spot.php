<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    use HasFactory;

    protected $table = 'spots';
    public $timestamps = false; 
    protected $fillable = ['name', 'country'];
}
