<?php

namespace App\Models;

use App\Models\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class categories extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name' ,
        'slug',
    ];

    public function post()
    {
        return $this->hasMany(posts::class);
    }
}
