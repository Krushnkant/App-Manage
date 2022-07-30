<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ {FormStructure};

class AppData extends Model
{
    use HasFactory;
    protected $table = "app_data";
    protected $fillable = ['app_id','category_id','form_structure_id','value'];

    public function fieldd(){
        return $this->hasOne(FormStructure::class,'id','form_structure_id');
    }
}
