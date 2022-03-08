<?php

namespace App\Domains\Shared\QueryBuilderCriteria;

class Where extends Criterion
{
    public function apply($queryBuilder)
    {
        return $queryBuilder->where(...$this->arguments);
    }
}
