<?php

namespace Marwanosama8\SpatieActivitylogResources\Loggers;

use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Activitylog\ActivityLogStatus;
use Spatie\Activitylog\ActivityLogger;

class NotificationLogger
{
    /**
     * Log the notification
     *
     * @param  NotificationSent|NotificationFailed  $event
     * @return void
     */
    public function handle(NotificationSent|NotificationFailed $event)
    {
        $notification = class_basename($event->notification);

        if ($event instanceof NotificationSent) {
            $description = $notification.' Notification sent';
        } else {
            $description = $notification.' Notification failed';
        }
        
        $receipent = $this->getRecipient($event->notifiable, $event->channel);
        
        if($receipent) {
             $description .= ' to '.$receipent;
        }

        app(ActivityLogger::class)
            ->useLog(config('spatie-activitylog-resources.notifications.log_name'))
            ->setLogStatus(app(ActivityLogStatus::class))
            ->causedByAnonymous()
            ->event(Str::of(class_basename($event))->headline())
            ->log($description);
    }

    public function getRecipient(mixed $notifiable, string $channel): ?string
    {
        $notificationRoute = $notifiable->routeNotificationFor($channel);
        return is_string($notificationRoute) ? $notificationRoute : null;
    }
}
