<?php

namespace App\Support;

class Debug
{
    /**
     * Retorna o tempo, em milissegundos, que um método é executado.
     *
     * @param  callable  $function  Método a ser estressado
     * @param  int  $times  Quantidade de vezes que o método será executado
     * @param  bool  $dumpAndDie  Encerrar a aplicação com o resultado do teste
     * @return int tempo de execução
     */
    public static function stress(callable $function, int $times = 1000, bool $dumpAndDie = true)
    {
        $initialTIme = milliseconds();

        for ($i = 0; $i < $times; $i++) {
            $function();
        }

        $resultTime = milliseconds() - $initialTIme;

        if ($dumpAndDie) {
            dd("{$resultTime}ms");
        }

        return "{$resultTime}ms";
    }

    /**
     *  Retorna o SQL já com os parâmetros associados
     *  Atenção! Só utilizar este método com finalidade de debug. Não utilizar para
     * outros fins.
     *
     * @param $queryBuilder
     * @param  bool  $dumpAndDie  Encerrar a aplicação com o resultado do método
     * @return string
     */
    public static function eloquentSqlWithBindings($queryBuilder, bool $dumpAndDie = true): string
    {
        $handledBindings = array_map(function ($binding) {
            return (is_numeric($binding))
                ? $binding
                : '\''.str_replace(['\\', "'"], ['\\\\', "\'"], $binding).'\'';
        }, $queryBuilder->getConnection()
            ->prepareBindings($queryBuilder->getBindings()));

        $sql = str_replace(['%', '?'], ['%%', '%s'], $queryBuilder->toSql());
        $fullSql = vsprintf($sql, $handledBindings);

        return ($dumpAndDie)
            ? dd($fullSql)
            : $fullSql;
    }
}
