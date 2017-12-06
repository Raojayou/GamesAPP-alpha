<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $table = 'comment';
    protected $fillable = ['id_distro', 'user', 'email', 'ip', 'text', 'approved'];

}