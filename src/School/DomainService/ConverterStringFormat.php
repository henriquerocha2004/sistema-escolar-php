<?php

namespace App\School\DomainService;

class ConverterStringFormat
{
    public static function camelCaseToSnakeCase(string $camelCaseString): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $camelCaseString));
    }

    public static function snakeCaseToCamelCase(string $snakeCaseString): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $snakeCaseString))));
    }
}
