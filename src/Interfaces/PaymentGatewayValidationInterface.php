<?php

namespace Clockwork\HolidayPark\Interfaces;


interface PaymentGatewayValidationInterface
{
    public function isValid() : bool;
    public function getErrors() : array;
}