<?php

namespace App\Requests;

use App\School\DomainService\ConverterStringFormat;
use ReflectionClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractJsonResponse
{
    public function __construct(
        protected ValidatorInterface $validator,
        protected RequestStack $requestStack
    ) {
        $this->populate();
        $this->validate();
    }

    public function getRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    protected function populate(): void
    {
        $dataRequest = [];
        $request = $this->getRequest();
        $reflection = new ReflectionClass($this);

        if ($request->isMethod('POST') or $request->isMethod('PUT')) {
            $dataRequest = $request->toArray();
        }

        if ($request->isMethod('GET')) {
            $dataRequest = $request->query->all();
        }

        foreach ($dataRequest as $property => $value) {
            $attribute = self::camelCase($property);
            if (property_exists($this, $attribute)) {
                $reflectionProperty = $reflection->getProperty($attribute);
                $reflectionProperty->setValue($this, $value);
            }
        }
    }

    protected function validate(): void
    {
        $violations = $this->validator->validate($this);
        if (count($violations) < 1) {
            return;
        }

        $errors = [];

        /** @var \Symfony\Component\Validator\ConstraintViolation */
        foreach ($violations as $violation) {
            $attribute = self::snakeCase($violation->getPropertyPath());
            $errors[] = [
                'property' => $attribute,
                'value' => $violation->getInvalidValue(),
                'message' => $violation->getMessage(),
            ];
        }

        $response = new JsonResponse(['errors' => $errors], 400);
        $response->send();
    }

    private static function camelCase(string $attribute): string
    {
        return ConverterStringFormat::snakeCaseToCamelCase($attribute);
    }

    private static function snakeCase(string $attribute): string
    {
        return ConverterStringFormat::camelCaseToSnakeCase($attribute);
    }

    abstract function getDto(): mixed;
}
