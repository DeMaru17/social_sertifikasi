<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'id_post',
        'content',
        'image',
    ];

    public function post()
    {
        return $this->belongsTo(Posts::class, 'id_post','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user','id');
    }

}
