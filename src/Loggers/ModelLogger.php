<?php

namespace Marwanosama8\SpatieActivitylogResources\Loggers;

class ModelLogger extends AbstractModelLogger
{
    protected function getLogName(): string
    {
        return config('filament-logger.models.log_name');
    }
}
