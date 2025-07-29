<?php

namespace App\Models\Traits;

use App\Models\LogActivity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    protected static function bootLogsActivity(): void
    {
        static::created(function (Model $model) {
            static::logActivity($model, 'create');
        });

        static::updated(function (Model $model) {
            static::logActivity($model, 'update', [
                'old' => $model->getOriginal(),
                'new' => $model->getChanges(),
            ]);
        });

        static::deleted(function (Model $model) {
            static::logActivity($model, 'delete');
        });
    }

    protected static function logActivity(Model $model, string $action, ?array $details = null): void
    {
        try {
            LogActivity::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'entity' => get_class($model),
                'entity_id' => $model->getKey(),
                'details' => $details,
                'status' => 'success',
                'ip_address' => request()->ip(),
                'user_agent' => substr(request()->userAgent() ?? '', 0, 100),
                'request_method' => request()->method(),
                'url_accessed' => request()->fullUrl(),
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to log activity: " . $e->getMessage());
        }
    }
}
