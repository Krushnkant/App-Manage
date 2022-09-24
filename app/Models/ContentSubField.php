<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentSubField extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'content_sub_field';
    protected $fillable= [
        'app_id','content_field_id','field_value','file_type','status','created_by','updated_by'
    ];
}
