<?php

namespace Marwanosama8\SpatieActivitylogResources;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Marwanosama8\SpatieActivitylogResources\Resources\ActivityResource;

class SpatieActivitylogResourcesPlugin implements Plugin
{
    public function getId(): string
    {
        return 'spatie-activitylog-resources';
    }

    public function register(Panel $panel): void
    {
        $panel
        ->resources([
            ActivityResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
