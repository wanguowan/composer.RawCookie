<?php
/**
 * Created by PhpStorm.
 * User: wan
 * Date: 7/24/17
 * Time: 7:03 PM
 */
namespace Wan\RawCookie;

use Illuminate\Cookie\CookieJar;
use Symfony\Component\HttpFoundation\Cookie;

class RawCookieJar extends CookieJar
{
    /**
     * Create a new cookie instance.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  int     $minutes
     * @param  string  $path
     * @param  string  $domain
     * @param  bool    $secure
     * @param  bool    $httpOnly
     * @param  bool    $raw
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public function make($name, $value, $minutes = 0, $path = null, $domain = null, $secure = false, $httpOnly = true, $raw = false )
    {
        list($path, $domain, $secure) = $this->getPathAndDomain($path, $domain, $secure);

        $time = ($minutes == 0) ? 0 : time() + ($minutes * 60);

        return new RawCookie($name, $value, $time, $path, $domain, $secure, $httpOnly, $raw );
    }

    /**
     * Queue a cookie to send with the next response.
     *
     * @param  mixed
     * @return void
     */
    public function queueWithDomain()
    {
        if (head(func_get_args()) instanceof Cookie) {
            $cookie = head(func_get_args());
        } else {
            $cookie = call_user_func_array([$this, 'make'], func_get_args());
        }
        $sKey = $this->_getQueueKey( $cookie->getName(), $cookie->getDomain() );
        $this->queued[ $sKey ] = $cookie;
    }

    /**
     * Remove a cookie from the queue.
     *
     * @param  string  $name
     * @return void
     */
    public function unqueueWithDomain($name, $sDomain )
    {
        $sKey = $this->_getQueueKey( $name, $sDomain );
        unset( $this->queued[ $sKey ] );
    }

    private function _getQueueKey( $sName, $sDomain )
    {
        return $sName . $sDomain;
    }
}