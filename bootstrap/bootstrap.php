<?php

require __DIR__ . '/../../../autoload.php';

$lambdaRuntime = \Bref\Runtime\LambdaRuntime::fromEnvironmentVariable('remi-collect-php-experiment');

$function = require getenv('_HANDLER');

$loopMax = 10;
$loops = 0;

while (true) {
    if (++$loops > $loopMax) {
        exit(0);
    }
    $success = $lambdaRuntime->processNextEvent($function);
    // In case the execution failed, we force starting a new process regardless of BREF_LOOP_MAX
    // Why: an exception could have left the application in a non-clean state, this is preventive
    if (! $success) {
        exit(0);
    }
}