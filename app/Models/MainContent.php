<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainContent extends Model
{
    use HasFactory;
    protected $table = 'main_content';

    protected $fillable = [
        'form_structure_id'
    ];
}
