<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Synergist\PlayWithGoogle;

$cmd = trim(strtolower( readline("\n> Input Address: ") ));
readline_add_history($cmd);

$result = PlayWithGoogle::run($cmd);

print_r($result);
