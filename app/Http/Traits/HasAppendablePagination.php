<?php

namespace App\Http\Traits;

use App\Resources\AppendablePaginator;

trait HasAppendablePagination
{
    public function ScopePaginateWithAppend($query, $append, $paginateNumber = 5)
    {
        return $this->ScopePaginateWithAppends($query, [$append], $paginateNumber);
    }

    public function ScopePaginateWithAppends($query, $appendList, $paginateNumber = 5)
    {
        return (new AppendablePaginator($query->paginate($paginateNumber)))->modelAppend($appendList);
    }
}
