<?php

namespace Clockwork\HolidayPark\Responses;

class PaymentGatewayApiResponse
{
    public bool $valid;
    public string $message;
    public array $errors;
    public array $data;
    public function __construct(bool $valid, array $data = null, string $message = null, array $errors = null)
    {
        $this->valid = $valid ?? false;
        $this->message = $message ?? "";
        $this->errors = $errors ?? [];
        $this->data = $data ?? [];
    }

    public function getData() : array {
        return $this->data;
    }

}
