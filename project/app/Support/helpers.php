<?php
/**
 * All files in this folder will be included in the application.
 */

if (!function_exists('with_error')) {
    /**
     *  Caso exista algum erro para o campo passado como parâmetro, é retornada
     * a classe 'form-control-danger'.
     *
     * @param  string  $field  Nome do campo do formulário
     * @param  callable|string|null  $output
     * @return string
     */
    function with_error(string $field, $output = 'has-danger'): string
    {
        $errors = \Session::get('errors');

        if (empty($errors)) {
            return '';
        }

        return $errors->has($field) ? value($output) : '';
    }
}

if (!function_exists('mask')) {
    /**
     *  Aplica uma máscara à uma string.
     *
     * @param  string  $value  Valor a ser mascarado
     * @param  string  $mask  Máscara
     * @param  string  $mask_character  Caractere que representará os valores preenchíveis
     * @return string
     */
    function mask($value, $mask, $mask_character = '#')
    {
        $value = str_replace(' ', '', $value);
        for ($i = 0; $i < strlen($value); $i++) {
            $mask[strpos($mask, $mask_character)] = $value[$i];
        }

        return $mask;
    }
}

if (!function_exists('pagination')) {
    /**
     * Retorna uma instância do builder de paginação.
     *
     * @return \App\Support\PaginationBuilder
     */
    function pagination($subject): \App\Support\PaginationBuilder
    {
        return \App\Support\PaginationBuilder::for($subject);
    }
}

if (!function_exists('current_user')) {
    /**
     * Retorna uma instância do usuário corrente.
     *
     * @return \App\Domains\User\Models\User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    function current_user()
    {
        return auth()->user();
    }
}

if (!function_exists('apply_params')) {
    /**
     * Aplica argumentos em parâmetros de uma string
     *
     * @return string
     */
    function apply_params(string $string, array $params, $before = ':', $after = '')
    {
        $regex = '/'.$before.'[a-z_]+'.$after.'/';
        return preg_replace_array($regex, $params, $string);
    }
}

if (!function_exists('in_production')) {
    /**
     * Retorna se a aplicação está em produção.
     *
     * @return bool
     */
    function in_production()
    {
        $actualEnv = config('app.env', 'local');
        return (\Illuminate\Support\Str::startsWith($actualEnv, 'prod'));
    }
}

if (!function_exists('milliseconds')) {
    /**
     * Retorna o timestamp atual em milisegundos
     *
     * @return int
     */
    function milliseconds()
    {
        $microTime = explode(' ', microtime());
        return ((int) $microTime[1]) * 1000 + ((int) round($microTime[0] * 1000));
    }
}

if (!function_exists('stress')) {
    /**
     * Retorna o tempo, em milisegundos, que um método é executado.
     *
     * @param  callable  $function  Método a ser estressado
     * @param  int  $times  Quatidade de vezes que o método será executado
     * @param  bool  $dumpAndDie  Encerrar a aplicação com o resultado do teste
     * @return int tempo de execução
     */
    function stress(callable $function, int $times = 1000, bool $dumpAndDie = true)
    {
        return \App\Support\Debug::stress($function, $times, $dumpAndDie);
    }
}

if (!function_exists('is_valid_url')) {
    /**
     * Validate if param is a valid URL;
     *
     * @param  string  $uil
     * @return bool
     */
    function is_valid_url(string $url)
    {
        return (bool) filter_var($url, FILTER_VALIDATE_URL);
    }
}

if (!function_exists('cache_manager')) {
    /**
     *  Resolve o resultado de uma chave de cache e retorna seu valor. Caso chamado
     * sem nenhum argumento, retorna uma instancia de \App\Helpers\CacheManager.
     *
     * @param  string|callable  $key  Chave de cache
     * @param  string  $ttl  Tempo de duração do cache. Ver guia de formatos
     * relativos em http://php.net/manual/pt_BR/datetime.formats.relative.php
     * @param  callable  $value  Valor a ser criado cache
     * @param  array  $tags  Marcações para a chave de cache
     * @return \App\Support\CacheManager | mixed
     */
    function cache_manager()
    {
        $args = func_get_args();
        $cacheManager = app(\App\Support\CacheManager::class);

        if (empty($args)) {
            return $cacheManager;
        }

        return $cacheManager->remember(...$args);
    }
}
