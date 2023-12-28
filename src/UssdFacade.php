<?php

namespace Bluteki\Ussd;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Bluteki\Ussd\Skeleton\SkeletonClass
 */
class UssdFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ussd';
    }
}
