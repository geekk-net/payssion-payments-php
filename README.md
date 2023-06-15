
Payssion payments
============



## Prerequisites

   * PHP 8.1 or above (from enums)
   * curl, guzzlehttp/guzzle, json & openssl extensions must be enabled



## Usage



### Create an order

``` php
$payssion = new PayssionApiClient('your api key', 'your secretkey', !$testMode);

try {
    $params = [
        'amount' => '10.95',
        'currency' => 'USD',
        'pm_id' => PayssionPaymentMethodEnum::payssion_test->name,
        'description' => 'Some goods',
        'order_id' => 'your order id',
        'return_url' => 'https://your-return-url.net/...'
        'payer_email' => 'your-user@mail.net'
    ];
    
    $response = $payssion->create($params);

    $apiResponse = new PayssionApiResponse($response);

} catch (Exception $e) {
    // log error
    echo sprintf("Error: %s", $e->getMessage());

    return;
}

if (! $apiResponse->isSuccess()) {
    // log error
    echo sprintf("Ошибка: %s", $apiResponse->getResultCode());

    return;
}

// log redirect URL (to payment form)
echo $apiResponse->getRedirectUrl();
// Code for redirecting user to payment form

```



### Handle payment notification

```php
$data = $_POST;

$webhookService = new PayssionWebhookService($data, 'your api key', 'your secretkey');

if(! $webhookService->hasCorrectSignature()) {
    echo 'Incorrect signature';
    
    return;
}

$paymentId = $webhookService->getPaymentId();
$invoiceId = $webhookService->getOrderId();
$status = $webhookService->getState();

if (in_array($status, [
    PayssionPaymentStatusEnum::cancelled,
    PayssionPaymentStatusEnum::failed,
    PayssionPaymentStatusEnum::expired,
    PayssionPaymentStatusEnum::error,
    ])) {
    
    echo 'failded payment';
    // Core for failed payment
    return;
}

if (in_array($status, [
    PayssionPaymentStatusEnum::refunded,
    PayssionPaymentStatusEnum::chargeback,
    ])) {
    
    echo 'refunded payment';
    // Code for refunded payment
    return;
}

if ($status == PayssionPaymentStatusEnum::completed) {
    echo 'completed payment';
    // Code for completed payment
    return;
}
```

