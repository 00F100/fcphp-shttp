<?php

use PHPUnit\Framework\TestCase;
use FcPhp\SHttp\SHttp;
use FcPhp\SHttp\SEntity;
use FcPhp\SHttp\Interfaces\ISHttp;
use FcPhp\SHttp\Interfaces\ISEntity;
use FcPhp\Session\Facades\SessionFacade;

class SHttpIntegrationTest extends TestCase
{
    private $entity;
    private $session;
    private $server;
    private $post;

    public function setUp()
    {
        $this->server = $_SERVER;
        $this->post = $_POST;
        $this->entity = new SEntity();
    }

    public function testInstance()
    {
        $instance = new SHttp($this->post, $this->server, $this->entity);
        $this->assertTrue($instance instanceof ISHttp);
    }

    public function testGetHeader()
    {
        $server = [
            SHttp::SHTTP_SERVER_KEY => 'content header'
        ];
        $instance = new SHttp($this->post, $server, $this->entity, $this->session);
        $instance->callback('authHeaderCallback', function(ISEntity $entity, $authHeader) {
            $this->assertEquals($authHeader, 'content header');
            return $entity;
        });
        $instance->get();
    }

    public function testGetSession()
    {
        $session = SessionFacade::getInstance($_COOKIE);
        $session->set('sentity', 'content session');
        $instance = new SHttp($this->post, $this->server, $this->entity, $session);
        $instance->callback('authSessionCallback', function(ISEntity $entity, $authSession) {
            $this->assertEquals($authSession, 'content session');
            $entity->setType('admin');
            return $entity;
        });
        $entity = $instance->get();
        $this->assertEquals($entity->getType(), 'admin');
    }

    public function testGetUserPass()
    {
        $post = [
            'content' => 'post'
        ];
        $instance = new SHttp($post, $this->server, $this->entity, $this->session);
        $instance->callback('authUserPassCallback', function(ISEntity $entity, $authUserPass) use ($post) {
            $this->assertEquals($authUserPass, $post);
            $entity->setType('user');
            return $entity;
        });
        $entity = $instance->get();
        $this->assertEquals($entity->getType(), 'user');
    }

    public function testGetGuest()
    {
        $this->post = [];
        $instance = new SHttp($this->post, $this->server, $this->entity, $this->session);
        $instance->callback('authGuestCallback', function(ISEntity $entity) {
            $this->assertTrue(true);
            return $entity;
        });
        $entity = $instance->get();
        $this->assertEquals($entity->getType(), 'guest');
    }
}