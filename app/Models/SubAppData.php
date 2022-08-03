<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ {SubformStructure};
use Illuminate\Database\Eloquent\SoftDeletes;

class SubAppData extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "sub_app_data";
    protected $fillable = ['app_id','category_id','sub_form_structure_id','value', 'UUID', 'app_uuid'];
    protected $dates = ['deleted_at'];

    public function fieldd(){
        return $this->hasOne(SubformStructure::class,'id','sub_form_structure_id');
    }
}
