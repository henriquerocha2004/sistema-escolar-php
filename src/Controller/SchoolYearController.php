<?php

namespace App\Controller;

use Exception;
use App\Helpers\MountErrorMessage;
use App\Requests\SchoolYearRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\School\Secretary\UseCases\SchoolYear\CreateSchoolYear;
use App\School\Secretary\UseCases\SchoolYear\DeleteSchoolYear;
use App\School\Secretary\UseCases\SchoolYear\ReadSchoolYear;
use App\School\Secretary\UseCases\SchoolYear\UpdateSchoolYear;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Requirement\Requirement;

class SchoolYearController extends AbstractController
{
    public function __construct(
        private readonly CreateSchoolYear $createSchoolYear,
        private readonly UpdateSchoolYear $updateSchoolYear,
        private readonly DeleteSchoolYear $deleteSchoolYear,
        private readonly ReadSchoolYear $readSchoolYear
    ) {
    }

    #[Route('/school-year', name: 'schoolYear.create', methods: ['POST'])]
    public function create(SchoolYearRequest $request): Response
    {
        try {
            $this->createSchoolYear->execute($request->getDto());

            return $this->json([
                'status' => 'success',
                'message' => 'school year created with success',
            ], Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in create school year'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route(
        '/school-year/{id}',
        name: 'schoolYear.update',
        methods: ['PUT'],
        requirements: ['id' => Requirement::UUID_V4]
    )]
    public function update(SchoolYearRequest $request, string $id): Response
    {
        try {
            $this->updateSchoolYear->execute($request->getDto(), $id);

            return $this->json([
                'status' => 'success',
                'message' => 'school year updated with success',
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in update school year'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route(
        '/school-year/{id}',
        name: 'schoolYear.delete',
        methods: ['DELETE'],
        requirements: ['id' => Requirement::UUID_V4]
    )]
    public function delete(string $id): Response
    {
        try {
            $this->deleteSchoolYear->execute($id);

            return $this->json([
                'status' => 'success',
                'message' => 'school year deleted with success',
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in delete school year'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route(
        '/school-year/{id}',
        name: 'schoolYear.find.one',
        methods: ['GET'],
        requirements: ['id' => Requirement::UUID_V4]
    )]
    public function findOne(string $id): Response
    {
        try {
            $schoolYear = $this->readSchoolYear->byId($id);

            if (is_null($schoolYear)) {
                return $this->json([
                    'status' => 'not found',
                ], Response::HTTP_NOT_FOUND);
            }

            return $this->json([
                'status' => 'success',
                'schoolYear' => $schoolYear->toArray(),
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in get school year'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/school-year', name: 'schoolYear.index', methods: ['GET'])]
    public function findAll(): Response
    {
        try {
            $schoolYears = $this->readSchoolYear->findAll();

            return $this->json([
                'status' => 'success',
                'schoolYears' => $schoolYears->toArray(),
            ]);
        } catch (Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => MountErrorMessage::getMessage(
                    $exception,
                    'error in get school years'
                ),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
