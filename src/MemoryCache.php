<?php

namespace informers\client;


require_once "Cache.php";

class MemoryCache implements Cache
{

    const CACHE_PREFIX = 'informers';

    /**
     * Cache instance
     * @var \Memcached
     */
    private $cache;

    /**
     * Expire period (sec)
     * @var int
     */
    private $period;

    /**
     * Cache prefix
     * @var string
     */
    private $cachePrefix;


    /**
     * @param $cache
     * @param $period
     * @param string $cachePrefix
     * @throws \Exception
     */
    public function __construct($cache, $period, $cachePrefix = 'informers')
    {
        $this->period = $period;
        $this->cachePrefix = $cachePrefix;

        if($cache instanceof \Memcached) {
            $this->cache = $cache;
        } elseif(is_array($cache)) {
            $this->cache = new \Memcached();
            $this->cache->addserver($cache['host'], $cache['port']);
        } else {
            throw new ClientException('Incorrect cache configuration');
        }
    }

    /**
     * @inheritdoc
     */
    function get($key)
    {
        return $this->cache->get($key);
    }

    /**
     * @inheritdoc
     */
    function set($key, $value)
    {
        return $this->cache->set($key, $value, time() + $this->period);
    }

    public function key($key)
    {
        return self::CACHE_PREFIX . "_" .md5($key);
    }
}