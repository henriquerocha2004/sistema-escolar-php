<?php

namespace App\Tests\Unit\School\Secretary\Entities;

use App\Helpers\MountErrorMessage;
use App\Requests\ClassRoomRequest;
use App\Requests\PaginatorRequest;
use App\School\Secretary\UseCases\ClassRoom\CreateClassRoom;
use App\School\Secretary\UseCases\ClassRoom\DeleteClassRoom;
use App\School\Secretary\UseCases\ClassRoom\ReadClassRoom;
use App\School\Secretary\UseCases\ClassRoom\UpdateClassRoom;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class ClassRoomController extends AbstractController
{
    public function __construct(
        private readonly CreateClassRoom $createClassRoom,
        private readonly UpdateClassRoom $updateClassRoom,
        private readonly DeleteClassRoom $deleteClassRoom,
        private readonly ReadClassRoom $readClassRoom
    ) {
    }

    #[Route('/classRoom', name: 'classRoom.create', methods: ['POST'])]
    public function create(ClassRoomRequest $request): Response
    {
        try {
            $this->createClassRoom->execute($request->getDto());

            return $this->json([
                'status' => 'success',
                'message' => 'classRoom created with success',
            ], Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in create classRoom'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route(
        '/classRoom/{id}',
        name: 'classRoom.update',
        requirements: ['id' => Requirement::UUID_V4],
        methods: ['PUT']
    )]
    public function update(ClassRoomRequest $request, string $id): Response
    {
        try {
            $this->updateClassRoom->execute($request->getDto(), $id);

            return $this->json([
                'status' => 'success',
                'message' => 'classRoom updated with success',
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in create classRoom'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route(
        '/classRoom/{id}',
        name: 'classRoom.delete',
        requirements: ['id' => Requirement::UUID_V4],
        methods: ['DELETE']
    )]
    public function delete(string $id): Response
    {
        try {
            $this->deleteClassRoom->execute($id);

            return $this->json([
                'status' => 'success',
                'message' => 'classRoom deleted with success',
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in delete classRoom'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route(
        '/classRoom/{id}',
        name: 'classRoom.findById',
        requirements: ['id' => Requirement::UUID_V4],
        methods: ['GET']
    )]
    public function findOneById(string $id): Response
    {
        try {
            $classRoom = $this->readClassRoom->findByOne($id);

            if (is_null($classRoom)) {
                return $this->json([
                    'status' => 'not found',
                ], Response::HTTP_NOT_FOUND);
            }

            return $this->json([
                'status' => 'success',
                'room' => $classRoom->toArray(),
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in search classRoom'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    #[Route('/classRoom', name: 'classRoom.search', methods: ['GET'])]
    public function findBy(PaginatorRequest $request): Response
    {
        try {
            $result = $this->readClassRoom->findBy($request->getDto());

            return $this->json([
                'status' => 'success',
                'rooms' => $result->toArray(),
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in search classRooms'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
