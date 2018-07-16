<?php

use PHPUnit\Framework\TestCase;
use FcPhp\SHttp\SHttp;
use FcPhp\SHttp\Interfaces\ISHttp;

class SHttpUnitTest extends TestCase
{
    private $instance;

    public function setUp()
    {
        $server = [

        ];
        $session = $this->createMock('FcPhp\Session\Interfaces\ISession');

        $this->instance = new SHttp($server, $session);
    }

    public function testInstance()
    {
        $this->assertTrue($this->instance instanceof ISHttp);
    }
}