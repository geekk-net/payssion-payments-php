<?php

namespace Geekk\PayssionPayments;

class PayssionWebhookService
{
    public function __construct(private ?array $data, private string $apiKey, private string $secretKey)
    {
    }

    public function getPaymentMethodId(): ?PayssionPaymentMethodEnum
    {
        return PayssionPaymentMethodEnum::tryFromName($this->data['pm_id']);
    }

    public function getAmount(): ?float
    {
        return $this->data['amount'];
    }

    public function getRawAmount(): ?string
    {
        return $this->data['amount'];
    }

    public function getCurrency(): ?string
    {
        return $this->data['currency'];
    }

    public function getOrderId(): ?string
    {
        return $this->data['order_id'];
    }

    public function getPaymentId(): ?string
    {
        return $this->data['transaction_id'];
    }

    public function getState(): ?PayssionPaymentStatusEnum
    {
        return PayssionPaymentStatusEnum::tryFrom($this->data['state']);
    }

    public function hasCorrectSignature(): bool
    {
        $checkArray = array(
            $this->apiKey,
            $this->getPaymentMethodId()->name,
            $this->getRawAmount(),
            $this->getCurrency(),
            $this->getOrderId(),
            $this->getState()->name,
            $this->secretKey
        );

        $checkSignature = md5(implode('|', $checkArray));

        return (strtolower($this->data['notify_sig']) === strtolower($checkSignature));
    }
}
