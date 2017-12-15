<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model {
    protected $table = 'game';
    protected $fillable = ['name','image','platform','description',
                           'forums','web','doc','forums','error_tracker'];

    public function comments(){
        return $this->hasMany('\App\Models\Comment')->orderBy('created_at', 'asc');
    }
}