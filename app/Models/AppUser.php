<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppUser extends Model
{
    use HasFactory;
    protected $table = 'appuser';
    protected $fillable = [
        'app_id',
        'user_id',
      
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

}
