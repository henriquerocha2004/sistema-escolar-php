<?php

namespace App\School\Secretary\Dto;

class PaginatorRequestDto
{
    public int $limit = 0;
    public string $search = '';
    public string $sortField = '';
    public string $sort = '';
    public int $page;
    public array $columnSearch = [];
}
