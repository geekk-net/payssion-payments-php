<?php

namespace Geekk\PayssionPayments;

enum PayssionPaymentStatusEnum: string
{
    case refunded = 'refunded';
    case chargeback = 'chargeback';
    case failed = 'failed';
    case cancelled = 'cancelled';
    case expired = 'expired';
    case error = 'error';
    case completed = 'completed';
}
