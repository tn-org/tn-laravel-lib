<?php

namespace Tnlake\Api\Exceptions;

use Tnlake\Api\Enums\ApiErrorCode;
use Tnlake\Api\Enums\HttpStatus;
use Exception;

class ApiException extends Exception
{
    public function __construct(
        protected ApiErrorCode $errorCode,
        ?string $message = null,
        protected ?array $details = null,
        protected ?array $validationErrors = null
    ) {
        parent::__construct($message ?? $errorCode->getMessage());
    }

    public function getErrorCode(): ApiErrorCode
    {
        return $this->errorCode;
    }

    public function getHttpStatus(): HttpStatus
    {
        return $this->errorCode->getHttpStatus();
    }

    public function getDetails(): ?array
    {
        return $this->details;
    }

    public function getValidationErrors(): ?array
    {
        return $this->validationErrors;
    }
}
