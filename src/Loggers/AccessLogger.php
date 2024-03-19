<?php

namespace Marwanosama8\SpatieActivitylogResources\Loggers;

use Filament\Facades\Filament;
use Illuminate\Auth\Events\Login;
use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\ActivityLogStatus;

class AccessLogger
{
    /**
     * Log user login
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $description = Filament::getUserName($event->user).' logged in';

        app(ActivityLogger::class)
            ->useLog(config('spatie-activitylog-resources.access.log_name'))
            ->setLogStatus(app(ActivityLogStatus::class))
            ->withProperties(['ip' => request()->ip(), 'user_agent' => request()->userAgent()])
            ->event('Login')
            ->log($description);
    }
}