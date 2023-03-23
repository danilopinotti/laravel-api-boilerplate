<?php

namespace App\Support;

use Illuminate\Contracts\Cache\Repository;

class CacheManager
{
    private ?string $driver = null;

    public function __construct(?string $driver = null)
    {
        $this->driver = $driver;
    }

    /**
     * Define o driver do cache manager
     *
     * @param  string  $driver
     * @return $this
     */
    public function driver(string $driver): self
    {
        return new self($driver);
    }

    /**
     * Retorna o Cache Manager com o driver Array de cache
     *
     * @return $this
     */
    public function arrayDriver(): self
    {
        return new self('array');
    }

    /**
     * Resolve o resultado de uma chave de cache e retorna seu valor.
     *
     * @param  string|callable  $key  Chave de cache
     * @param  array  $tags  Marcações para a chave de cache
     * @return mixed
     */
    public function get($key, array $tags = [])
    {
        $key = (string) value($key);

        return $this->getCache($tags)
            ->get($key);
    }

    /**
     * Resolve o resultado de uma chave de cache e retorna seu valor.
     *
     * @param  callable|string  $key  Chave de cache
     * @param  string  $ttl  Tempo de duração do cache. Ver guia de formatos
     * relativos em http://php.net/manual/pt_BR/datetime.formats.relative.php
     * @param  callable  $value  Valor a ser criado cache
     * @param  array  $tags  Marcações para a chave de cache
     * @return mixed
     */
    public function remember(
        callable|string $key,
        string $ttl,
        callable $value,
        array $tags = []
    ): mixed {
        $applicationCacheIsEnabled = config('cache.enable_application_cache', true);

        if (! $applicationCacheIsEnabled) {
            return value($value);
        }

        $key = (string) value($key);
        $ttl = $this->resolveTtl($ttl);

        return $this->getCache($tags)
            ->remember($key, $ttl, $value);
    }

    /**
     * Armazena valor em cache forçando reescrita.
     *
     * @param  string|callable  $key  Chave de cache
     * @param  string  $ttl  Tempo de duração do cache. Ver guia de formatos
     * relativos em http://php.net/manual/pt_BR/datetime.formats.relative.php
     * @param  mixed  $value  Valor a ser criado cache
     * @param  array  $tags  Marcações para a chave de cache
     * @return mixed
     */
    public function put(
        string|callable $key,
        string $ttl,
        mixed $value,
        array $tags = []
    ) {
        $key = (string) value($key);
        $ttl = $this->resolveTtl($ttl);

        return $this->getCache($tags)
            ->put($key, value($value), $ttl);
    }

    public function forget($key)
    {
        $key = (string) value($key);

        return $this->getCache()
            ->forget($key);
    }

    /**
     * Converte o TTL de string para um objeto de intervalo de data.
     *
     * @param  string  $ttl  Tempo de duração do cache. Ver guia de formatos
     * relativos em http://php.net/manual/pt_BR/datetime.formats.relative.php
     * @return \DateInterval      TTL convertido
     */
    private function resolveTtl(string $ttl): \DateInterval
    {
        return \DateInterval::createFromDateString($ttl);
    }

    /**
     * Retorna o serviço de cache já configurado
     *
     * @param  array  $tags
     * @return \Illuminate\Contracts\Cache\Repository
     */
    private function getCache(array $tags = []): Repository
    {
        $cache = app('cache')
            ->driver($this->driver);

        return ($tags)
            ? $cache->tags($tags)
            : $cache;
    }
}
