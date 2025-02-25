<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use App\Models\Log;

class DatabaseLogger extends AbstractProcessingHandler
{
    protected function write(array|\Monolog\LogRecord $record): void
    {
        Log::create([
            'level' => $record['level_name'],
            'message' => $record['message'],
            'context' => json_encode($record['context']),
        ]);
    }
}
