<?php

namespace App\Controller;

use Exception;
use App\Requests\ScheduleRequest;
use App\Helpers\MountErrorMessage;
use App\Requests\PaginatorRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\School\Secretary\UseCases\Schedules\ReadSchedule;
use App\School\Secretary\UseCases\Schedules\CreateSchedule;
use App\School\Secretary\UseCases\Schedules\DeleteSchedule;
use App\School\Secretary\UseCases\Schedules\UpdateSchedule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Requirement\Requirement;

class ScheduleController extends AbstractController
{
    public function __construct(
        private readonly CreateSchedule $createSchedule,
        private readonly UpdateSchedule $updateSchedule,
        private readonly DeleteSchedule $deleteSchedule,
        private readonly ReadSchedule $readSchedule
    ) {
    }

    #[Route('/schedule', methods: ['POST'], name: 'schedule.create')]
    public function create(ScheduleRequest $request): Response
    {
        try {
            $this->createSchedule->execute($request->getDto());

            return $this->json([
                'status' => 'success',
                'message' => 'schedule created with success',
            ], Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in create schedule'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/schedule/{id}', name: 'schedule.update', methods: ['PUT'], requirements: ['id' => Requirement::UUID_V4])]
    public function update(ScheduleRequest $request, string $id): Response
    {
        try {
            $this->updateSchedule->execute($request->getDto(), $id);

            return $this->json([
                'status' => 'success',
                'message' => 'schedule updated with success',
            ], Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in update schedule'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/schedule/{id}', name: 'schedule.delete', methods: ['DELETE'], requirements: ['id' => Requirement::UUID_V4])]
    public function delete(string $id): Response
    {
        try {
            $this->deleteSchedule->execute($id);

            return $this->json([
                'status' => 'success',
                'message' => 'schedule deleted with success',
            ], Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in deleted schedule'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/schedule/{id}', name: 'schedule.find.one', methods: ['GET'], requirements: ['id' => Requirement::UUID_V4])]
    public function findOne(string $id): Response
    {
        try {
            $schedule = $this->readSchedule->findOneById($id);

            if (is_null($schedule)) {
                return $this->json([
                    'status' => 'not found',
                ], Response::HTTP_NOT_FOUND);
            }

            return $this->json([
                'status' => 'success',
                'schedule' => $schedule->toArray(),
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in find schedule'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/schedule', name: 'schedule.index', methods: ['GET'])]
    public function findBy(PaginatorRequest $request): Response
    {
        try {
            $result = $this->readSchedule->findBy($request->getDto());

            return $this->json([
                'status' => 'success',
                'rooms' => $result->toArray(),
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            dd($exception);
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in find schedules'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
