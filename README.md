# FcPhp Security HTTP

Library to manipulate auth of user into HTTP env

[![Build Status](https://travis-ci.org/00F100/fcphp-shttp.svg?branch=master)](https://travis-ci.org/00F100/fcphp-shttp) [![codecov](https://codecov.io/gh/00F100/fcphp-shttp/branch/master/graph/badge.svg)](https://codecov.io/gh/00F100/fcphp-shttp) [![Total Downloads](https://poser.pugx.org/00F100/fcphp-shttp/downloads)](https://packagist.org/packages/00F100/fcphp-shttp)

## How to install

Composer:
```sh
$ composer require 00f100/fcphp-shttp
```

or add in composer.json
```json
{
    "require": {
        "00f100/fcphp-shttp": "*"
    }
}
```

## How to use

```php
<?php

use FcPhp\SHttp\SHttp;
use FcPhp\SHttp\SEntity;
use FcPhp\Session\Facades\SessionFacade;

$session = SessionFacade::getInstance($_COOKIE);
$entity = new SEntity();

$instance = new SHttp($_POST, $_SERVER, $entity, $session);

$instance->callback('authHeaderCallback', function(ISEntity $entity, $authHeader) {
    $entity->setName('Header Auth');
    return $entity;
});

$instance->callback('authSessionCallback', function(ISEntity $entity, $authSession) {
    $entity->setName('Session Auth');
    return $entity;
});

$instance->callback('authUserPassCallback', function(ISEntity $entity, $authUserPass) {
    $entity->setName('User Pass Auth');
    return $entity;
});

$entity = $instance->get();

// PRINT:
// IF HEADER AUTH: Header Auth
// IF SESSION AUTH: Session Auth
// IF POST AUTH: User Pass Auth
echo $entity->getName();
```