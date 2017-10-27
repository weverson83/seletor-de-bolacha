<?php
namespace CookiesTest;

use Cookies\Model\Cookie;
use Cookies\Model\Storage;
use PHPUnit\Framework\TestCase;

class StorageTest extends TestCase
{
    public function testCookieIsStored()
    {
        $storage = new Storage();
        $cookie = new Cookie(1);
        $storage->add($cookie);

        $this->assertContains($cookie, $storage->getCookies());
    }

    public function testGetCookieReturnsTheMedian()
    {
        $storage = new Storage();

        $diameterList = [1, 2, 3, 4];

        foreach ($diameterList as $diameter) {
            $storage->add(new Cookie($diameter));
        }

        $this->assertEquals(3, $storage->retrieveACookie()->getDiameter());
        $this->assertEquals(2, $storage->retrieveACookie()->getDiameter());
        $this->assertEquals(4, $storage->retrieveACookie()->getDiameter());
        $this->assertEquals(1, $storage->retrieveACookie()->getDiameter());
    }

    public function testStress()
    {
        $storage = new Storage();
        $diameterList = range(1, 300000, 500);

        foreach ($diameterList as $diameter) {
            $storage->add(new Cookie($diameter));
        }

        $expectation = fopen(__DIR__ . '/StorageTest/stressOutput.txt', 'r');

        while (fscanf($expectation, '%d', $median) === 1) {
            $this->assertEquals($median, $storage->retrieveACookie()->getDiameter());
        }

        fclose($expectation);
    }

    /**
     * @dataProvider sequenceProvider
     * @param Int $input
     * @param Int $output
     */
    public function testGetCookieRightAfterAddingIt(Int $input, Int $output)
    {
        $storage = new Storage();

        $storage->add(new Cookie($input));
        $this->assertEquals($output, $storage->retrieveACookie()->getDiameter());
    }

    /**
     * @return array
     */
    public function sequenceProvider(): array
    {
        return [
            [1, 1],
            [2, 2],
            [3, 3],
            [4, 4],
        ];
    }
}
