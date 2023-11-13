<?php

namespace App\School\DomainService;

use App\School\Secretary\Dto\PaginatorRequestDto;

class Paginator
{
    public int $limit = 0;
    private int $offset = 0;
    public string $search = '';
    public string $sortField = '';
    public string $sort = '';

    private function __construct()
    {
    }

    /**
     * @var ColumnSearch[]
     */
    private array $columnSearch = [];

    public function setPage(int $page): void
    {
        if ($page == 0) {
            $page = 1;
        }

        $this->offset = ($page * $this->limit) - $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function addColumnSearch(array $columns): void
    {
        foreach ($columns as $column) {
            $this->columnSearch[] = new ColumnSearch($column['column'], $column['value']);
        }
    }

    /**
     * @return ColumnSearch[]
     */
    public function getColumnSearch(): array
    {
        return $this->columnSearch;
    }

    public static function create(PaginatorRequestDto $dto): self
    {
        $paginator = new self();
        $paginator->limit = $dto->limit ?? 5;
        $paginator->setPage($dto->page);
        $paginator->search = $dto->search ?? '';
        $paginator->sort = $dto->sort ?? 'ASC';
        $paginator->sortField = $dto->sortField ?? 'created_at';
        $paginator->addColumnSearch($dto->columnSearch);

        return $paginator;
    }
}
