<?php

namespace Kika\ApiClient;


final class ConstraintViolation
{
    /** @var string */
    private $code;

    /** @var string */
    private $message;

    /** @var string */
    private $property;


    public function __construct($property, $code, $message)
    {
        $this->property = $property;
        $this->message = $message;
        $this->code = $code;
    }


    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }


    /**
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }
}
