<?php

namespace Geekk\PayssionPayments;

enum PayssionPaymentMethodEnum: string
{

    /**
     * Для отладки. В params-local нужно использовать dev подключение (sandbox) и платеку payssion_test
     * https://payssion.com/en/docs/#api-reference-pm-id
     */
    case payssion_test = 'Test';
    case paysafecard = 'Paysafecard';
    case sofort = 'Sofort';
    case giropay_de = 'Giropay';
    case eps_at = 'EPS';
    case p24_pl = 'Przelewy24';
    case bancontact_be = 'Bancontact';
    case promptpay_th = 'Promptpay';

    public static function tryFromName(string $name): ?static
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }

        return null;
    }
}
