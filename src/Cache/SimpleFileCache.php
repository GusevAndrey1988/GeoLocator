<?php

declare(strict_types = 1);

namespace Feature\GeoLocator\Cache;

use DateInterval;
use Psr\SimpleCache\CacheInterface;

class SimpleFileCache implements CacheInterface
{
    public function __construct(private string $cacheDir)
    {
        if (!is_dir($this->cacheDir)) {
            if (!mkdir($this->cacheDir)) {
                throw new \RuntimeException('Can\'t create cache dir '.$this->cacheDir);
            }
        } 
    }

    public function has(string $key): bool
    {
        $fileName = $this->makeCacheFileName($key);
        if (!is_file($fileName)) {
            return false;
        }

        if (empty(file_get_contents($fileName))) {
            return false;
        }

        return true;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $fileName = $this->makeCacheFileName($key);
        if (!is_file($fileName)) {
            return $default;
        }

        $cacheData = file_get_contents($fileName);
        if (empty($cacheData)) {
            return $default;
        }

        return unserialize($cacheData);
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $generator = function() use ($keys, $default) {
            foreach ($keys as $key) {
                yield $this->get($key, $default);
            }
        };

        return $generator();
    }

    public function set(string $key, mixed $value, null|int|DateInterval $ttl = null): bool
    {
        $fileName = $this->makeCacheFileName($key); 
        return (file_put_contents($fileName, serialize($value)) === false);
    }

    public function setMultiple(iterable $values, null|int|DateInterval $ttl = null): bool
    {
        $status = true;
        foreach ($values as $key => $value) {
            if (!$this->set($key, $value)) {
                $status = false;
            }
        }

        return $status;
    }

    public function clear(): bool
    {
        $status = true;
        if (is_dir($this->cacheDir)){
            $di = new \RecursiveDirectoryIterator($this->cacheDir, \FilesystemIterator::SKIP_DOTS);
            $ri = new \RecursiveIteratorIterator($di, \RecursiveIteratorIterator::CHILD_FIRST);
            
            foreach ($ri as $file) {
                if ($file->isFile()) {
                    if (!unlink($file)) {
                        $status = false;
                    }
                }
            }
        }

        return $status;
    }

    public function delete(string $key): bool
    {
        $fileName = $this->makeCacheFileName($key);
        return unlink($fileName);
    }

    public function deleteMultiple(iterable $keys): bool
    {
        $status = true;
        foreach ($keys as $key) {
            if (!$this->delete($key)) {
                $status = false;
            }
        }

        return $status;
    }

    private function makeCacheFileName(string $key): string
    {
        return $this->cacheDir.'/'.$key.'.cache';
    }
}