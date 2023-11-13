<?php

namespace App\Requests;

use App\School\Secretary\Dto\PaginatorRequestDto;

class PaginatorRequest extends AbstractJsonResponse
{
    public int $limit = 5;
    public int $page = 1;
    public string $search = '';
    public string $sort_field = 'created_at';
    public string $sort = 'DESC';
    public string $columnSearch = '';

    public function getDto(): PaginatorRequestDto
    {
        $dto = new PaginatorRequestDto();
        $dto->limit = $this->limit;
        $dto->page = $this->page;
        $dto->search = $this->search;
        $dto->sort = $this->sort;
        $dto->sortField = $this->sort_field;
        $dto->columnSearch = json_decode($this->columnSearch, true) ?? [];

        return $dto;
    }
}
