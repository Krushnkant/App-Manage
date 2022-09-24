<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormStructureFieldNew extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'form_structure_field_new';
    protected $fillable= [
        'app_id','form_structure_id','field_type','field_name','status','created_by','updated_by'
    ];
}
