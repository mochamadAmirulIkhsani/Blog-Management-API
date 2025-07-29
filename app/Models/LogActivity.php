<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $table = 'log_activities';

    protected $fillable = [
        'user_id',
        'action',
        'entity',
        'entity_id',
        'details',
        'status',
        'error_message',
        'ip_address',
        'user_agent',
        'request_method',
        'url_accessed',
    ];

    protected $casts = [
        'details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
