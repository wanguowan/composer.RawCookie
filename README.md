# composer.RawCookie

## 简介
Laravel框架下，设置Raw Cookie

Laravel 5.3及5.4框架Cookie::queue已支持setrawcookie，但是5.1及5.2中暂不支持。
通过安装这个包后，简单配置后即可实现同样功能。

## 优势：
相对于原生的setcookie及setrawcookie，使用该包后可以优雅的使用切面编程，对已经设置的cookie进行取消操作。而不需要侵入到业务代码中，根据业务逻辑判断是否设置该cookie

## 安装：

```
composer require wan/raw-cookie
```

## 配置：

### 配置Providers

修改config/app.php配置文件，在providers数组中，添加服务提供者

```
'providers' => [
    // ...
    \Wan\RawCookie\Providers\RawCookieServiceProvider::class,
]
```

### 配置Class Aliases

修改config/app.php配置文件，在aliases数组中，添加别名

```
'aliases' => [
    'RawCookie' => \Wan\RawCookie\Facade\RawCookie::class,
]
```

### 配置Middleware

修改app/Http/Kernel.php

Laravel5.2：在$middlewareGroups=>web中添加

```
protected $middlewareGroups = [
    'web' => [
       // ...
       \Wan\RawCookie\Middleware\AddQueuedRawCookiesToResponse::class,
   ],
    // ...
];
```

Laravel5.1:在$middleware中添加

```
protected $middleware =
	[
	   // ...
		\Wan\RawCookie\Middleware\AddQueuedRawCookiesToResponse::class,
	];
```

## 使用

在需要添加cookie的地方，使用下面代码添加

```
use RawCookie;

// ...
RawCookie::queue( $key, $value, $expire, $path, $domain, $secure, $httponly, $raw )
```

在需要取消添加cookie的地方，使用下面代码

```
use RawCookie;

// ...
RawCookie::unqueue( $key );
```

判断是否添加了cookie

```
use RawCookie;

// ...
RawCookie::queued( $key );
```

