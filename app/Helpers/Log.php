<?php

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

if (!function_exists('log_activity')) {
    /**
     * Helper to log an activity.
     *
     * @param Model $subject The model that is the subject of the log.
     * @param string $action A description of the action.
     * @param array|null $properties Additional properties to store as JSON.
     */
    function log_activity(Model $subject, string $action, ?array $properties = null): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'subject_id' => $subject->getKey(),
            'subject_type' => $subject->getMorphClass(),
            'properties' => $properties,
        ]);
    }
}
