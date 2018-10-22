<?php

namespace Kika\ApiClient;

use Exception;


final class BadRequestException extends Exception
{
    /** @var ConstraintViolation[] */
    private $violations;

    public function __construct($message, array $violations)
    {
        parent::__construct($message);
        $this->violations = $violations;
    }


    /**
     * @return ConstraintViolation[]
     */
    public function getViolations()
    {
        return $this->violations;
    }


    public static function fromResponse(array $data)
    {
        $violations = [];

        foreach ($data['violations'] as $propertyName => $propertyViolations) {
            foreach ($propertyViolations as $propertyViolation) {
                $violations[$propertyName][] = new ConstraintViolation(
                    $propertyName,
                    $propertyViolation['code'],
                    $propertyViolation['message']
                );
            }
        }

        return new self($data['message'], $violations);
    }
}