<?php
namespace CookiesTest;

use Cookies\Model\Cookie;
use PHPUnit\Framework\TestCase;

class CookieTest extends TestCase
{
    public function testCookieGeneratesUniqueIdOnCreate()
    {
        $cookie = new Cookie(100);
        $this->assertNotNull($cookie->getId());
    }
}
