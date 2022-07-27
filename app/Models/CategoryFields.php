<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryFields extends Model
{
    use HasFactory;
    protected $table = 'category_fields';

    protected $fillable = [
        'app_id',
        'category_id',
        'key',
        'value',
        'field_id'
    ];
}
