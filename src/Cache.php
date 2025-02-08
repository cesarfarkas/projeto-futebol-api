<?php

class Cache {
    private $cacheDir = '../src/cache/';
    private $cacheDuration = 86400; // 1 dia em segundos

    public function __construct() {
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    public function setCache($key, $data) {
        $cacheFile = $this->cacheDir . md5($key) . '.json';
        file_put_contents($cacheFile, json_encode(['data' => $data, 'timestamp' => time()]));
    }

    public function getCache($key) {
        $cacheFile = $this->cacheDir . md5($key) . '.json';
        if (file_exists($cacheFile)) {
            $cacheData = json_decode(file_get_contents($cacheFile), true);
            if (time() - $cacheData['timestamp'] < $this->cacheDuration) {
                return $cacheData['data'];
            }
        }
        return null;
    }
}