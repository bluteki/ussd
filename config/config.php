<?php

/*
 * You can place your custom package configuration in here.
 */


return [
    "handlers" => [
        Bluteki\Ussd\Gateway\TruTeq\Handler::class,
        Bluteki\Ussd\Gateway\Flares\Handler::class,
    ]
];