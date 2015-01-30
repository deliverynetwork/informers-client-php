Informers client PHP library
=============================

## Installation

#### Through composer:

```json
"deliverynetwork/informers-client-php": "dev-master",
```


#### Through including files:

```php
<?php
include_once "<PATH_TO_LIBRARY>/src/Client.php";
include_once "<PATH_TO_LIBRARY>/src/FileCache.php";
include_once "<PATH_TO_LIBRARY>/src/ClientException.php";
include_once "<PATH_TO_LIBRARY>/src/MemoryCache.php";
include_once "<PATH_TO_LIBRARY>/src/TemplateEngine.php";
```

## Usage

### Usage with file cache:

```php 
<?php
try {
    $client = new \informers\client\Client(
        array(
            'site_id' => <YOUR_SITE_ID>,
            'api_key' => '<YOUR_SITE_API_KEY>',
            'api_url' => '<PLATFORM_API_URL>',
            'cache'   => new \informers\client\FileCache(
                '<PATH_TO_CACHE_DIRECTORY>',
                '<CACHE_PERIOD_IN_SECONDS>'
            )
        )
    );
    $currentUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";// current page URL
    echo $client->render($currentUrl); // rendering informer
} catch (\informers\client\ClientException $e) { /* do something if needed */ } 
```

### Usage with Memcached:

```php 
<?php
try {
    $client = new \informers\client\Client(
        array(
            'site_id' => <YOUR_SITE_ID>,
            'api_key' => '<YOUR_SITE_API_KEY>',
            'api_url' => '<PLATFORM_API_URL>',
            'cache'   => new \informers\client\MemoryCache(             
                array(
                    'host' => 'localhost',  // Memcached  host
                    'port' => 11211,        // Memcached  port
                ), '<CACHE_PERIOD_IN_SECONDS>'
            ),
        )
    );
    $currentUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; // current page URL    
    echo $client->render($currentUrl); // rendering informer
} catch (\informers\client\ClientException $e) { /* do something if needed */ } 
```

### Usage with custom cache

```php
try {
    $client = new \informers\client\Client(
        array(
            'site_id' => <YOUR_SITE_ID>,
            'api_key' => '<YOUR_SITE_API_KEY>',
            'api_url' => '<PLATFORM_API_URL>',
            'cache'   => new \informers\client\CustomCache(
                    function($key){
                        return your_cache_get_function($key);
                    },
                    function($key, $value, $period){
                        return your_cache_set_function($key, $value, $period);
                    }, '<CACHE_PERIOD_IN_SECONDS>', '<CACHE_PREFIX>')
        )
    );
    $currentUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; // current page URL    
    echo $client->render($currentUrl); // rendering informer
} catch (\informers\client\ClientException $e) { /* do something if needed */ }
```
