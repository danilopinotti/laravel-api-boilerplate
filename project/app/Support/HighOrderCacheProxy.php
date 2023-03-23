<?php

namespace App\Support;

class HighOrderCacheProxy
{
    protected string $ttl = '15 minutes';

    protected array $tags = [];

    public function __construct(
        protected $target,
        protected string $cachePrefix = '',
        protected string $cacheSuffix = '',
    ) {
    }

    public function ttl(string $ttl): self
    {
        $this->ttl = $ttl;

        return $this;
    }

    public function tags(array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function __call($method, $args)
    {
        $result = function () use ($method, $args) {
            return $this->target->$method(...$args);
        };

        $prefix = trim($this->cachePrefix, ':')
            ?: get_class($this->target);

        $hashFeed = '';
        foreach ($args as $arg) {
            if (is_bool($arg)) {
                $hashFeed .= strbool($arg) . ':';
            }

            if ($arg instanceof Hasheable) {
                $hashFeed .= $arg->toHash() . ':';

                continue;
            }

            if ($arg instanceof \JsonSerializable) {
                $hashFeed .= \json_encode($arg) . ':';

                continue;
            }

            $hashFeed .= serialize($arg);
        }

        $argsHash = substr(\sha1(trim($hashFeed, ':')), 0, 8);
        $key = sprintf(
            '%s:%s:%s',
            $prefix,
            "$method@$argsHash",
            trim($this->cacheSuffix, ':')
        );

        return cache_manager($key, $this->ttl, $result, $this->tags);
    }
}
