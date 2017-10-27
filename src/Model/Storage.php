<?php
namespace Cookies\Model;

class Storage
{
    /** @var Cookie[] $cookies */
    private $cookies = [];

    /** @var bool $shouldReorder */
    private $shouldReorder = true;

    /**
     * @param Cookie $cookie
     */
    public function add(Cookie $cookie)
    {
        $this->cookies[$cookie->getId()] = $cookie;
        $this->shouldReorder = true;
    }

    /**
     * @return array
     */
    public function getCookies(): array
    {
        return $this->cookies;
    }

    /**
     * @return Cookie
     */
    public function retrieveACookie(): Cookie
    {
        $totalCookies = count($this->cookies);

        if ($totalCookies == 1) {
            $cookie = reset($this->cookies);
            return $this->getAndRemoveCookie($cookie);
        }

        if ($this->shouldReorder) {
            $this->orderCookiesByDiameter();
        }

        $slice1 = array_slice($this->cookies, 0, $totalCookies/2, true);
        $slice2 = array_slice($this->cookies, $totalCookies/2, null, true);

        /** @var Cookie $medianA */
        $medianA = end($slice1);

        /** @var Cookie $medianB */
        $medianB = reset($slice2);

        if ($medianA->getDiameter() > $medianB->getDiameter()) {
            return $this->getAndRemoveCookie($medianA);
        }

        return $this->getAndRemoveCookie($medianB);
    }

    /**
     * @param Cookie $cookie
     * @return Cookie
     */
    private function getAndRemoveCookie(Cookie $cookie): Cookie
    {
        unset($this->cookies[$cookie->getId()]);

        return $cookie;
    }

    private function orderCookiesByDiameter()
    {
        uasort($this->cookies, function (Cookie $cookie1, Cookie $cookie2) {
            return $cookie1->getDiameter() > $cookie2->getDiameter();
        });

        $this->shouldReorder = false;
    }
}
