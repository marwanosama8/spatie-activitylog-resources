<?php

namespace Marwanosama8\SpatieActivitylogResources\Loggers;

class ModelLogger extends AbstractModelLogger
{
    protected function getLogName(): string
    {
        return config('spatie-activitylog-resources.models.log_name');
    }
}
