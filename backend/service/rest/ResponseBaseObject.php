<?php

namespace app\service\rest;

class ResponseBaseObject implements ResponseObjectInterface
{
    /**
     * {@inheritDoc}
     */
    public static function make(array $response, ResponseObjectInterface $responseObject = null): ResponseObjectInterface
    {
        if (!isset($responseObject)) {
            $responseObject = new self;
        }
        foreach ($response as $key => $value) {
            if (property_exists($responseObject, $key)) {
                $responseObject->$key = $value;
            }
        }
        return $responseObject;
    }

    /**
     * @param array|null $response
     */
    public function __construct(?array $response = null)
    {
        if (isset($response)) {
            foreach ($response as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function resultToArray(): array
    {
        return get_object_vars($this);
    }
}