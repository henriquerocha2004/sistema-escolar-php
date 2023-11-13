<?php

namespace App\Controller;

use Exception;
use App\Requests\RoomRequest;
use App\Helpers\MountErrorMessage;
use App\Requests\PaginatorRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\School\Secretary\UseCases\Room\ReadRoom;
use App\School\Secretary\UseCases\Room\CreateRoom;
use App\School\Secretary\UseCases\Room\DeleteRoom;
use App\School\Secretary\UseCases\Room\UpdateRoom;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;

class RoomController extends AbstractController
{
    public function __construct(
        private readonly CreateRoom $createRoom,
        private readonly UpdateRoom $updateRoom,
        private readonly DeleteRoom $deleteRoom,
        private readonly ReadRoom $readRoom
    ) {
    }

    #[Route('/room', name: 'room.create', methods: ['POST'])]
    public function create(RoomRequest $request): Response
    {
        try {
            $this->createRoom->execute($request->getDto());

            return $this->json([
                'status' => 'success',
                'messate' => 'room created with success',
            ], Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in create room'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    #[Route('/room', methods: ['OPTIONS'])]
    public function createRoomInfo(): Response
    {
        $response = new Response();
        $response->headers->set('Allow', 'POST', 'OPTIONS');

        return $response;
    }


    #[Route('/room/{id}', name: 'room.update', requirements: ['id' => Requirement::UUID_V4], methods: ['PUT'])]
    public function update(RoomRequest $request, string $id): Response
    {
        try {
            $this->updateRoom->execute($request->getDto(), $id);

            return $this->json([
                'status' => 'success',
                'messate' => 'room updated with success',
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in update room'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/room/{id}', name: "room.delete", requirements: ['id' => Requirement::UUID_V4], methods: ['DELETE'])]
    public function delete(string $id): Response
    {
        try {
            $this->deleteRoom->execute($id);

            return $this->json([
                'status' => 'success',
                'message' => 'room deleted with success',
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in delete room'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/room/{id}', name: 'room.find.one', requirements: ['id' => Requirement::UUID_V4], methods: ['GET'])]
    public function findById(string $id): Response
    {
        try {
            $room = $this->readRoom->findOneById($id);

            if (is_null($room)) {
                return $this->json([
                    'status' => 'not found',
                ], Response::HTTP_NOT_FOUND);
            }

            return $this->json([
                'status' => 'success',
                'room' => $room->toArray(),
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in find room'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/room', name: 'room.search', methods: ['GET'])]
    public function findAll(PaginatorRequest $request): Response
    {
        try {
            $result = $this->readRoom->findByCriteria($request->getDto());

            return $this->json([
                'status' => 'success',
                'rooms' => $result->toArray(),
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in find rooms'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
