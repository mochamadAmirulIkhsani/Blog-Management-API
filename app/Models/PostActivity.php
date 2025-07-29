<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostActivity extends Model
{
    protected $table = 'post_activities';

    protected $fillable = [
        'post_id',
        'ip',
        'user_agent',
    ];

    public function post()
    {
        return $this->belongsTo(posts::class, 'post_id');
    }
}
