<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Category, ApplicationData, Field};

class CategoryFields extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'category_fields';

    protected $fillable = [
        'app_id',
        'category_id',
        'key',
        'value',
        'field_id',
        'status'
    ];
    protected $dates = ['deleted_at'];

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
    public function application(){
        return $this->hasOne(ApplicationData::class,'id','app_id');
    }
    public function fields(){
        return $this->hasOne(Field::class,'id','field_id');
    }
}
