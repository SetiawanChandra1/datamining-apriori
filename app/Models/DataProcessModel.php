<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataProcessModel extends Model
{
    use HasFactory;
    
    protected $fillable = ['username', 'start_date', 'end_date', 'min_support', 'min_confidence']; 
}
