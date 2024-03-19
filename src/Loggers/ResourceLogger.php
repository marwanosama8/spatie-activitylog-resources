<?php

namespace Marwanosama8\SpatieActivitylogResources\Loggers;

class ResourceLogger extends AbstractModelLogger
{
    protected function getLogName(): string
    {
        return config('spatie-activitylog-resources.resources.log_name');
    }
}
