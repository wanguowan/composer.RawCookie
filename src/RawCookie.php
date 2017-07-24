<?php
/**
 * Created by PhpStorm.
 * User: wan
 * Date: 7/24/17
 * Time: 7:03 PM
 */
namespace Wan\RawCookie;

use Symfony\Component\HttpFoundation\Cookie;

class RawCookie extends Cookie
{
    protected $raw;

    /**
     * Constructor.
     *
     * @param string                                  $name     The name of the cookie
     * @param string                                  $value    The value of the cookie
     * @param int|string|\DateTime|\DateTimeInterface $expire   The time the cookie expires
     * @param string                                  $path     The path on the server in which the cookie will be available on
     * @param string                                  $domain   The domain that the cookie is available to
     * @param bool                                    $secure   Whether the cookie should only be transmitted over a secure HTTPS connection from the client
     * @param bool                                    $httpOnly Whether the cookie will be made accessible only through the HTTP protocol
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($name, $value = null, $expire = 0, $path = '/', $domain = null, $secure = false, $httpOnly = true, $raw = false )
    {
        parent::__construct( $name, $value, $expire, $path, $domain, $secure, $httpOnly );

        $this->raw = (bool) $raw;
    }

    /**
     * Returns the cookie as a string.
     *
     * @return string The cookie
     */
    public function __toString()
    {
        $str = urlencode($this->getName()).'=';

        if ('' === (string) $this->getValue()) {
            $str .= 'deleted; expires='.gmdate('D, d-M-Y H:i:s T', time() - 31536001);
        } else {
            $str .= $this->isRaw() ? $this->getValue() : urlencode($this->getValue());

            if (0 !== $this->getExpiresTime()) {
                $str .= '; expires='.gmdate('D, d-M-Y H:i:s T', $this->getExpiresTime());
            }
        }

        if ($this->path) {
            $str .= '; path='.$this->path;
        }

        if ($this->getDomain()) {
            $str .= '; domain='.$this->getDomain();
        }

        if (true === $this->isSecure()) {
            $str .= '; secure';
        }

        if (true === $this->isHttpOnly()) {
            $str .= '; httponly';
        }

        return $str;
    }


    public function isRaw()
    {
        return $this->raw;
    }
}