<?php

class Eliti_Cache
{
    private $cache;
    private $key;

    public function __construct($key, $lifetime = 15)
    {
        $frontendOptions = [
            'lifetime' => $lifetime, // seconds
            'automatic_serialization' => true,
        ];

        $backendOptions = [
            'cache_dir' => CACHE_PATH, // Directory where to put the cache files
        ];

        // getting a Zend_Cache_Core object
        $this->cache = Zend_Cache::factory(
            'Core',
            'File',
            $frontendOptions,
            $backendOptions
        );

        $this->key = $key;
    }

    public function carregar()
    {
        return $this->cache->load($this->key);
    }

    public function salvar($data)
    {
        $this->cache->save($data);
        // demora 2 segundos só para "sentir" que teve que ir ao banco
    }
}
