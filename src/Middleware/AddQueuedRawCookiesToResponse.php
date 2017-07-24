<?php
/**
 * Created by PhpStorm.
 * User: wan
 * Date: 7/24/17
 * Time: 7:09 PM
 */
namespace Wan\RawCookie\Middleware;

use Wan\RawCookie\Facade\RawCookie;
use Closure;

class AddQueuedRawCookiesToResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        foreach ( RawCookie::getQueuedCookies() as $cookie )
        {
            if ( $cookie->isRaw() )
            {
                setrawcookie($cookie->getName(), $cookie->getValue(), $cookie->getExpiresTime(), $cookie->getPath(), $cookie->getDomain(), $cookie->isSecure(), $cookie->isHttpOnly());
            }
            else
            {
                setrawcookie($cookie->getName(), $cookie->getValue(), $cookie->getExpiresTime(), $cookie->getPath(), $cookie->getDomain(), $cookie->isSecure(), $cookie->isHttpOnly());
            }
        }

        return $response;
    }
}