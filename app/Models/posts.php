<?php

namespace App\Models;

use App\Models\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Testing\Fluent\Concerns\Has;

class posts extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'user_id',
        'thumbnail',
        'status',
        'meta_title',
        'meta_description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsTo(categories::class);
    }

    public function tags()
    {
        return $this->belongsToMany(tags::class, 'posts_tags', 'posts_id', 'tag_id');
    }

    public function thumbnail(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => url('/storage/' . $image),
        );
    }
}
