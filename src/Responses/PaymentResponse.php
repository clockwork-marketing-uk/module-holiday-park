<?php

namespace Clockwork\HolidayPark\Responses;

class PaymentResponse
{
    public bool $valid;
    public string $message;
    public string $paymentId;
    public array $errors;
    public $data;

    public function __construct(
        bool $valid,
        string $message = null,
        string $paymentId = null,
        array $errors = null,
        $data = null
    ) {
        $this->valid = $valid ?? false;
        $this->message = $message ?? "";
        $this->paymentId = $paymentId ?? "";
        $this->errors = $errors ?? [];
        $this->data = $data ?? [];
    }
}
