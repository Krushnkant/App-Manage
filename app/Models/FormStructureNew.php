<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormStructureNew extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'form_structure_new';
    protected $fillable= [
        'app_id','parent_id','category_id','form_title','status','created_by','updated_by'
    ];
}
