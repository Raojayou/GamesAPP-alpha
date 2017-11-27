<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distro extends Model {
    protected $table = 'distro';
    protected $fillable = ['image', 'name', 'ostype', 'basedon', 'origin', 'arch', 'desktop', 'category', 'status', 'version', 'web', 'doc', 'forums', 'error_tracker', 'description'];
}