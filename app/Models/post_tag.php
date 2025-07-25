<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class post_tag extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'post_id',
        'tag_id',
    ];

    public function post()
    {
        return $this->belongsTo(posts::class);
    }

    public function tags()
    {
        return $this->belongsTo(tags::class);
    }
}
