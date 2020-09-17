
<h1 align="left"><a href="#">WechatPayPoint</a></h1>

📦 基于<a href="https://pay.weixin.qq.com/wiki/doc/apiv3/wxpay/payscore/chapter1_1.shtml">微信支付分</a>的文档开发的PHP SDK



## Requirement


1. PHP >= 7.2
2. **[Composer](https://getcomposer.org/)**
3. openssl 拓展
4. fileinfo 拓展（素材管理模块需要用到）

## Installation

```shell
$ composer require "" 
```

## Usage

基本使用（以服务端为例）:

```php
<?php

use EasyWeChat\Factory;

$options = [
    'app_id'    => 'wx3cf0f39249eb0exxx',
    'secret'    => 'f1c242f4f28f735d4687abb469072xxx',
    'token'     => 'easywechat',
    'log' => [
        'level' => 'debug',
        'file'  => '/tmp/easywechat.log',
    ],
    // ...
];

$app = Factory::officialAccount($options);

$server = $app->server;
$user = $app->user;

$server->push(function($message) use ($user) {
    $fromUser = $user->get($message['FromUserName']);

    return "{$fromUser->nickname} 您好！欢迎关注 overtrue!";
});

$server->serve()->send();
```

更多请参考 [微信支付分通用文档](https://pay.weixin.qq.com/wiki/doc/apiv3/wxpay/payscore/chapter1_1.shtml)。








