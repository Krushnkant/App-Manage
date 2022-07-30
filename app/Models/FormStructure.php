<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{SubformStructure};

class FormStructure extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'application_id',
        'field_name',
        'field_type',
        'estatus',
    ];

    public function sub_form(){
        return $this->hasMany(SubformStructure::class,'form_id','id');
    }
}
