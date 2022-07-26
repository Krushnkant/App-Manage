<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ApplicationData extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "application_data";
    protected $fillable = ['name', 'icon', 'app_id', 'package_name', 'created_by', 'updated_by', 'status', 'total_request', 'token', 'cat_total_request', 'is_url', 'icon_url', 'test_token', 'is_new'];
    protected $dates = ['deleted_at'];
}
