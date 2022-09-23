<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{ Category, ApplicationData };

class CategoryField extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'category_field';
    protected $fillable= [
        'app_id','category_id','field_type','field_key','field_value','file_type','status','created_by','updated_by'
    ];

    protected $dates = ['deleted_at'];

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
    public function application(){
        return $this->hasOne(ApplicationData::class,'id','app_id');
    }
    // public function fields(){
    //     return $this->hasOne(Field::class,'id','field_id');
    // }
}
