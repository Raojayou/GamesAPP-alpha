<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distro extends Model {
    protected $table = 'distro';
    protected $fillable = ['image', 'name', 'ostype', 'basedon', 'origin', 'architecture', 'desktop', 'category', 'status', 'version', 'web', 'doc', 'forums', 'error_tracker', 'description'];

    public function comments(){
        return $this->hasMany('\App\Models\Comment')->orderBy('created_at', 'asc');
    }
}