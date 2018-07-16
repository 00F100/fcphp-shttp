<?php

use PHPUnit\Framework\TestCase;
use FcPhp\SHttp\SEntity;
use FcPhp\SHttp\Interfaces\ISEntity;

class SEntityUnitTest extends TestCase
{
    private $instance;

    public function setUp()
    {
        $this->instance = new SEntity();
    }

    public function testInstance()
    {
        $this->assertTrue($this->instance instanceof ISEntity);
    }

    public function testSetId()
    {
        $this->instance->setId('123');
        $this->assertEquals($this->instance->getId(), '123');
    }

    public function testSetName()
    {
        $this->instance->setName('name');
        $this->assertEquals($this->instance->getName(), 'name');
    }

    public function testSetEmail()
    {
        $this->instance->setEmail('email@email.com');
        $this->assertEquals($this->instance->getEmail(), 'email@email.com');
    }

    public function testSetUsername()
    {
        $this->instance->setUsername('username');
        $this->assertEquals($this->instance->getUsername(), 'username');
    }

    public function testSetTypeString()
    {
        $this->instance->setType('admin');
        $this->assertEquals($this->instance->getType(), 'admin');
    }

    public function testSetTypeInteger()
    {
        $this->instance->setType(2);
        $this->assertEquals($this->instance->getType(), 'user');
    }

    public function testSetPermissions()
    {
        $permissions = [
            'list.users'
        ];
        $this->instance->setPermissions($permissions);
        $this->assertEquals($this->instance->getPermissions(), $permissions);
    }

    public function testSetCustomData()
    {
        $arrayCustomData = [
            'content' => [
                'test' => [
                    'item' => 'value'
                ]
            ]
        ];
        $key = 'content.test.item';
        $customData = 'value';
        $this->instance->setCustomData($key, $customData);
        $this->assertEquals($this->instance->getCustomData(), $arrayCustomData);
        $this->assertEquals($this->instance->getCustomData('content.test.item'), 'value');
    }

    public function testSetErrors()
    {
        $message = 'error message';
        $this->instance->setError($message);
        $this->assertTrue($this->instance->haveErrors());
        $this->assertEquals($this->instance->getError(), [$message]);
    }

    public function testCheckPermissionAdmin()
    {
        $this->instance->setType('admin');
        $this->assertTrue($this->instance->check('list.all'));
    }

    public function testCheckPermissionUser()
    {
        $this->instance->setType('user');
        $this->instance->setPermissions(['list.all']);
        $this->assertTrue($this->instance->check('list.all'));
    }
}