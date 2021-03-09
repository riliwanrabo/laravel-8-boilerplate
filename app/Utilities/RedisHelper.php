<?php
namespace App\Utilities;


use Illuminate\Support\Facades\Redis;

class RedisHelper
{
    private $redis;
    public function __construct()
    {
        $this->redis = Redis::connection();
    }

    /**
     * fetch an item from the redis store
     *
     * @param string $key An identifier for retrieving an item from the redis store
     *
     */
    public function get($key)
    {
        return $this->redis->get($key);
    }

    /**
     * stores data to the redis store with a given key
     *
     * @param string $key An identifier for the record to be added in the redis store
     * @param string $data The data to be stored
     *
     */
    public function set($key, $data)
    {
        return $this->redis->set($key, $data);
    }

    /**
     * stores data to the redis store with a given key
     *
     * @param string $key An identifier for the record to be added in the redis store
     * @param string $data The data to be stored
     * @param int $time expiry time in seconds e.g for 24 hours do 60*60*24
     *
     */
    public function putFor($key, $data, $time)
    {
        return $this->redis->setex($key, $time, $data);
    }

    /**
     * Delete an item from the redis store
     *
     * @param string $key The redis item to be destroyed/deleted from the redis store
     *
     */
    public function delete($key)
    {
        return $this->redis->del($key);
    }
}
