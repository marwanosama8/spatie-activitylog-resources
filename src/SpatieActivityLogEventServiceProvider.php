<?php

namespace Marwanosama8\SpatieActivitylogResources;

use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Events\NotificationSent;

class SpatieActivityLogEventServiceProvider extends ServiceProvider
{
    
    public function listens()
    {
        $listen = array_merge(
            config('spatie-activitylog-resources.access.enabled') ? [
                Login::class => [
                    config('spatie-activitylog-resources.access.logger'),
                ],
            ] : [],
            config('spatie-activitylog-resources.notifications.enabled') ? [
                NotificationSent::class => [
                    config('spatie-activitylog-resources.notifications.logger'),
                ],
                NotificationFailed::class => [
                    config('spatie-activitylog-resources.notifications.logger'),
                ],
            ] : []
        );
        return $listen;
    }
}
