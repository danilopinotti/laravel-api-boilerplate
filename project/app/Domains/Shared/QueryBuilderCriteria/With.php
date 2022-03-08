<?php

namespace App\Domains\Shared\QueryBuilderCriteria;

class With extends Criterion
{
    public function apply($queryBuilder)
    {
        return $queryBuilder->with(...$this->arguments);
    }
}
