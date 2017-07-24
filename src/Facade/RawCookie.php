<?php
/**
 * Created by PhpStorm.
 * User: wan
 * Date: 7/24/17
 * Time: 7:06 PM
 */
namespace Wan\RawCookie\Facade;

use Illuminate\Support\Facades\Facade;

class RawCookie extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'rawcookie';
    }
}