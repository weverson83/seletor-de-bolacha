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
            $storage->add($diameter);
        }

        $this->assertEquals(3, $storage->get());
        $this->assertEquals(2, $storage->get());
        $this->assertEquals(4, $storage->get());
        $this->assertEquals(1, $storage->get());
    }

    public function testStress()
    {
        $storage = new Storage();
        $diameterList = range(1, 300000000, 500);

        foreach ($diameterList as $diameter) {
            $storage->add($diameter);
        }
        foreach ($diameterList as $diameter) {
            $storage->get();
        }

//        $expectation = fopen(__DIR__ . '/StorageTest/stressOutput.txt', 'r');
//
//        while (fscanf($expectation, '%d', $median) === 1) {
//            $this->assertEquals($median, $storage->retrieveACookie()->getDiameter());
//        }
//
//        fclose($expectation);
    }

    /**
     * @dataProvider sequenceProvider
     * @param Int $input
     * @param Int $output
     */
    public function testGetCookieRightAfterAddingIt(Int $input, Int $output)
    {
        $storage = new Storage();

        $storage->add($input);
        $this->assertEquals($output, $storage->get());
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

    public function testOne()
    {
        $inputFile = fopen(__DIR__ . '/StorageTest/cookieselection.07.in', 'r');

        $storage = new Storage();

        while (fscanf($inputFile, '%s', $input) === 1) {
            if (is_numeric($input)) {
                $storage->add($input);
            } else {
                fprintf(STDOUT, "%d\n", $storage->get());
            }
        }
    }
}
