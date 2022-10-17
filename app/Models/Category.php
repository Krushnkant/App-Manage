<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\{CategoryFields};

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'category';

    protected $fillable = [
        'app_id',
        'title',
        'status',
        'created_by',
        'updated_by'
    ];
    protected $dates = ['deleted_at'];

    public function category(){
        return $this->hasMany(CategoryFields::class,'category_id','id');
    }
    public function category_field(){
        return $this->hasMany(CategoryField::class,'category_id','id');
    }
    // public function categoryContent()
    // {
    //     return $this->hasMany(CategoryFields::class,'category_id','id');
    // }
}
