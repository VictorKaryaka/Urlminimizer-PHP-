<?php

class MainTest extends PHPUnit_Framework_TestCase
{
    private function getMainInstance()
    {
        return new \Application\Main();
    }

    public function testMinimize()
    {
        $this->expectOutputString(json_decode($this->getMainInstance()->minimize(
                'http://testlink/test', '0', 'test_storage_links')));
        print PHP_EOL . 'http://testlink/d457393a' . PHP_EOL;
    }

    public function testGetMinimizeCustomUrl()
    {
        $this->expectOutputString(json_decode($this->getMainInstance()->minimizeCustomUrl(
                'http://testlink/testcustom',
                '0', 'custom', 'test_storage_links')));
        print PHP_EOL . 'custom' . PHP_EOL;
    }

    public function testRedirect()
    {
        $this->expectOutputString($this->getMainInstance()->redirect('http://testlink/d457393a', 'test_storage_links'));
        print PHP_EOL . 'http://testlink/test';
    }
}