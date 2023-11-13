<?php

namespace App\School\Secretary\UseCases\ClassRoom;

use App\School\Secretary\Dto\ClassRoomDto;
use App\School\Secretary\Entities\ClassRoom;
use App\School\Secretary\Exeptions\ClassRoomException;
use App\School\Secretary\Repository\ClassRoomRepositoryInterface;

class CreateClassRoom
{
    public function __construct(
        private readonly ClassRoomRepositoryInterface $classRoomRepository
    ) {
    }

    /**
     * @throws ClassRoomException
     */
    public function execute(ClassRoomDto $dto): void
    {
        $classRoom = ClassRoom::create(
            $dto->identification,
            $dto->vacanciesQuantity,
            $dto->shift,
            $dto->level,
            $dto->schoolYearId,
            $dto->scheduleId,
            $dto->type,
            $dto->roomId,
            $dto->localization
        );

        $this->classRoomRepository->create($classRoom);
    }
}
