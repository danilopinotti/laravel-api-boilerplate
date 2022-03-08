<?php

namespace App\Domains\Shared\QueryBuilderCriteria;

class OrderResolvedByUrlCriteria extends Criterion
{
    private $defaultOrderBy;

    public function __construct($defaultOrderBy)
    {
        $this->defaultOrderBy = $defaultOrderBy;
    }

    public function apply($queryBuilder)
    {
        $field = \Request::input('field') ?? $this->defaultOrderBy['field'] ?? 'updated_at';
        $order = \Request::input('order') ?? $this->defaultOrderBy['order'] ?? 'desc';

        return $queryBuilder->orderBy($field, $order);
    }
}
