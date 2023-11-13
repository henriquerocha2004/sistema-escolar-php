<?php

namespace App\Tests\Unit\School\Secretary\UseCases\ClassRoom;

use App\School\Secretary\Repository\ClassRoomRepositoryInterface;
use App\School\Secretary\UseCases\ClassRoom\DeleteClassRoom;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class DeleteClassRoomTest extends TestCase
{
    public function testShouldDeleteClassRomWithSuccess(): void
    {
        $repository = $this->createMock(ClassRoomRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('delete');

        $deleteClassRoom = new DeleteClassRoom($repository);
        $deleteClassRoom->execute(Uuid::v4()->__toString());
    }
}
