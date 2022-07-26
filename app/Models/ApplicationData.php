<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationData extends Model
{
    use HasFactory;

    protected $table = "application_data";
    protected $fillable = ['name', 'icon', 'app_id', 'package_name','created_by','updated_by','status'];
}
