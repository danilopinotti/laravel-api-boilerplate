<?php

namespace App\Domains\Shared\QueryBuilderCriteria;

abstract class Criterion
{
    /** @var mixed[] */
    protected $arguments;

    /**
     * Add a basic where clause to the query.
     *
     * @return $this
     */
    public function __construct()
    {
        $this->arguments = func_get_args();
    }

    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param $queryBuilder
     * @return mixed
     */
    abstract public function apply($queryBuilder);
}
