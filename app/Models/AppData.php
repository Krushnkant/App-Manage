<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ {FormStructure, Category, ApplicationData};

class AppData extends Model
{
    use HasFactory;
    protected $table = "app_data";
    protected $fillable = ['app_id','category_id','form_structure_id','value','UUID'];

    public function fieldd(){
        return $this->hasOne(FormStructure::class,'id','form_structure_id');
    }
    public function application(){
        return $this->hasOne(ApplicationData::class,'id','app_id');
    }
    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
}
