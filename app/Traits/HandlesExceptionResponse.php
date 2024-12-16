<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HandlesExceptionResponse
{
    use ApiResponseTrait;
    protected string $msg = 'An error occurred';
    protected int $status = 500;
    protected array $errors = [];

    /**
     * Set a custom error message.
     *
     * @param string $message
     * @return self
     */
    public function setMessage(string $message): self
    {
        $this->msg = $message;
        return $this;
    }

    /**
     * Set a custom HTTP status code.
     *
     * @param int $code
     * @return self
     */
    public function setCode(int $code): self
    {
        $this->status = $code;
        return $this;
    }

    /**
     * Set custom error details.
     *
     * @param array $errors
     * @return self
     */
    public function setErrors(array $errors): self
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * Render the exception to an HTTP response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render(): JsonResponse
    {
        return $this->errorResponse($this->msg, $this->status, $this->errors);
    }
}
