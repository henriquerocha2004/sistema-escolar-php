<?php

namespace App\Repository;

use App\School\DomainService\ColumnSearch;
use App\School\DomainService\Paginator;

abstract class BaseRepository
{
    public function mountSql(Paginator $paginator): string
    {
        $sql = " ";

        if (count($paginator->getColumnSearch()) >= 1) {
            /** @var ColumnSearch $columnSearch */
            foreach ($paginator->getColumnSearch() as $columnSearch) {
                $sql .= "AND {$columnSearch->getColumn()} = {$columnSearch->getValue()} ";
            }
        }

        if (!empty($paginator->sort) && !empty($paginator->sortField)) {
            $sql .= "ORDER BY {$paginator->sortField} {$paginator->sort} ";
        }

        if ($paginator->limit > 0) {
            $sql .= "LIMIT {$paginator->limit} ";
        }

        if (!empty($paginator->getOffset())) {
            $sql .= "OFFSET {$paginator->getOffset()}";
        }

        $sql .= ";";

        return $sql;
    }
}
