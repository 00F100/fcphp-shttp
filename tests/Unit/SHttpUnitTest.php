<?php

use PHPUnit\Framework\TestCase;
use FcPhp\SHttp\SHttp;
use FcPhp\SHttp\Interfaces\ISHttp;
use FcPhp\SHttp\Interfaces\ISEntity;

class SHttpUnitTest extends TestCase
{
    private $entity;
    private $session;
    private $server;
    private $post;

    public function setUp()
    {
        $this->server = [];
        $this->post = [];
        $this->session = $this->createMock('FcPhp\Session\Interfaces\ISession');
        $this->entity = $this->createMock('FcPhp\SHttp\Interfaces\ISEntity');
    }

    public function testInstance()
    {
        $instance = new SHttp($this->post, $this->server, $this->session, $this->entity);
        $this->assertTrue($instance instanceof ISHttp);
    }

    public function testGetHeader()
    {
        $server = [
            SHttp::SHTTP_SERVER_KEY => 'content header'
        ];
        $instance = new SHttp($this->post, $server, $this->session, $this->entity);
        $instance->callback('authHeaderCallback', function(ISEntity $entity, $authHeader) {
            $this->assertEquals($authHeader, 'content header');
            return $entity;
        });
        $instance->get();
    }

    public function testGetSession()
    {
        $this->session
            ->expects($this->any())
            ->method('get')
            ->will($this->returnValue('content session'));

        $instance = new SHttp($this->post, $this->server, $this->session, $this->entity);
        $instance->callback('authSessionCallback', function(ISEntity $entity, $authSession) {
            $this->assertEquals($authSession, 'content session');
            return $entity;
        });
        $instance->get();
    }

    public function testGetUserPass()
    {
        $this->post = [
            'content' => 'post'
        ];
        $instance = new SHttp($this->post, $this->server, $this->session, $this->entity);
        $instance->callback('authUserPassCallback', function(ISEntity $entity, $authUserPass) {
            $this->assertEquals($authUserPass, $this->post);
            return $entity;
        });
        $instance->get();
    }

    public function testGetGuest()
    {
        $this->post = [];
        $instance = new SHttp($this->post, $this->server, $this->session, $this->entity);
        $instance->callback('authGuestCallback', function(ISEntity $entity) {
            $this->assertTrue(true);
            return $entity;
        });
        $instance->get();
    }
}