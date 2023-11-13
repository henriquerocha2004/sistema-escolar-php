<?php

namespace App\Tests\Feature\School\Secretary\Repository;

use App\DataFixtures\RoomFixures;
use App\Repository\Secretary\RoomRepository;
use App\School\DomainService\Paginator;
use App\School\Secretary\Dto\PaginatorRequestDto;
use App\School\Secretary\Entities\Room;
use App\Tests\Feature\BaseFeatureTest;

class RoomRepositoryTest extends BaseFeatureTest
{
    private RoomRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new RoomRepository($this->entityManager);
    }

    public function testShouldSaveRoom(): void
    {
        $room = Room::Create('TN-01', 20, 'Sala apos o refeitorio');
        $this->repository->create($room);
        $roomDb = $this->repository->findOneById($room->getId());
        $this->assertEquals($room->getCode(), $roomDb->getCode());
    }

    public function testShouldUpdateRoom(): void
    {
        $room = Room::Create('TN-01', 20, 'Sala apos o refeitorio');
        $this->repository->create($room);

        $room->setCode('TN-02');
        $this->repository->update($room);

        $roomDB = $this->repository->findOneById($room->getId());
        $this->assertEquals($room->getCode(), $roomDB->getCode());
    }


    public function testShouldDeleteRoom(): void
    {
        $room = Room::Create('TN-01', 20, 'Sala apos o refeitorio');
        $this->repository->create($room);

        $this->repository->delete($room->getId());
        $roomDB = $this->repository->findOneById($room->getId());

        $this->assertNull($roomDB);
    }

    public function testShouldFindByCriteria(): void
    {
        $connection = $this->entityManager->getConnection();
        $fixure = new RoomFixures($connection);
        $fixure->load($this->entityManager);
        $paginationDto = new PaginatorRequestDto();
        $paginationDto->limit = 5;
        $paginationDto->page = 1;
        $paginationDto->sort = 'DESC';
        $pagination = Paginator::create($paginationDto);
        $result = $this->repository->findBy($pagination);

        $this->assertCount(5, $result->rooms);
    }
}
