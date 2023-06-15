<?php

namespace Geekk\PayssionPayments;

class PayssionApiResponse
{

    public function __construct(private readonly ?array $response)
    {
    }

    public function isSuccess(): bool
    {
        return (isset($this->response['result_code']) && 200 == $this->response['result_code']);
    }

    public function getResultCode(): ?int
    {
        return $this->response['result_code'];
    }

    public function getRedirectUrl(): string
    {
        return $this->response['redirect_url'];
    }
}
