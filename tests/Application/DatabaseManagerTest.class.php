<?php

class DatabaseManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * DatabaseManagerTest constructor.
     */
    public function __construct()
    {
        $this->getDatabaseManager()->getConnection()->query('TRUNCATE TABLE test_redirect_statistic');
        $this->getDatabaseManager()->getConnection()->query('TRUNCATE TABLE test_storage_links');
    }

    private function getDatabaseManager()
    {
        return new \Application\DatabaseManager();
    }

    public function testGetConnection()
    {
        $this->assertInternalType('object', $this->getDatabaseManager());
    }

    /**
     * @depends testGetConnection
     */
    public function testAddLink()
    {
        $this->getDatabaseManager()->addLink('1234test', '0', 'www.testurl.com', 'test_storage_links');
        $sql = 'SELECT * FROM test_storage_links;';
        $state = $this->getDatabaseManager()->getConnection()->query($sql);
        $row = $state->fetchAll(PDO::FETCH_COLUMN);
        $this->assertNotEmpty($row);
    }

    /**
     * @depends testAddLink
     */
    public function testGetUrl()
    {
        $test_url = $this->getDatabaseManager()->getURl('1234test', 'test_storage_links');
        $this->assertEquals('www.testurl.com', $test_url['link_url']);
    }

    public function testAddRedirectLink()
    {
        $this->getDatabaseManager()->addRedirectLink('Chrome', 'www.redirecttest.com', 'test_redirect_statistic');
        $sql = 'SELECT * FROM test_redirect_statistic;';
        $state = $this->getDatabaseManager()->getConnection()->query($sql);
        $row = $state->fetchAll(PDO::FETCH_COLUMN);
        $this->assertNotEmpty($row);
    }

    /**
     * @depends testAddRedirectLink
     */
    public function testGetRedirectLinks()
    {
        $links = $this->getDatabaseManager()->getRedirectLinks('test_redirect_statistic');
        $this->assertNotEmpty($links);
    }

    public function testIsHasHash()
    {
        $this->assertTrue($this->getDatabaseManager()->isHasHash('1234test', 'test_storage_links'));
    }
}