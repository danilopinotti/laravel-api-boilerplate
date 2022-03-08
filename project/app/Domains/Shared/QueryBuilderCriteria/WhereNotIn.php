<?php

namespace App\Domains\Shared\QueryBuilderCriteria;

class WhereNotIn extends Criterion
{
    public function apply($queryBuilder)
    {
        return $queryBuilder->whereNotIn(...$this->arguments);
    }
}
