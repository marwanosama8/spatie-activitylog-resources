<?php

namespace Marwanosama8\SpatieActivitylogResources\Resources\ActivityResource\Pages;

use Filament\Resources\Pages\ListRecords;

class ListActivities extends ListRecords
{
    public static function getResource(): string
    {
        return config('spatie-activitylog-resources.activity_resource');
    }
}
