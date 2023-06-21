<?php

namespace Geekk\PayssionPayments;

enum PayssionPaymentMethodEnum: string
{

    /**
     * Для отладки. В params-local нужно использовать dev подключение (sandbox) и платежку payssion_test
     * https://payssion.com/en/docs/#api-reference-pm-id
     */
    case payssion_test = 'Test';
    case fpx_my = 'FPX Malaysia';
    case enets_sg = 'eNets Singapore';
    case paynow_sg = 'PayNow Singapore';
    case ebanking_th = 'E-banking Thailand';
    case promptpay_th = 'Promptpay Thailand';
    case doku_id = 'Doku Indonesia';
    case atm_id = 'ATM Indonesia';
    case alfamart_id = 'Alfamart Indonesia';
    case dragonpay_ph = 'Dragonpay Philippines';
    case gcash_ph = 'Globe Gcash Philippines';
    case cherrycredits = 'CherryCredits Global including South East';
    case molpoints = 'MOLPoints Global including South East';
    case molpointscard = 'MOLPoints card Global including South East';
    case alipay_cn = 'Alipay China';
    case tenpay_cn = 'Tenpay China';
    case unionpay_cn = 'Unionpay China';
    case gash_tw = 'Gash Taiwan';
    case upi_in = 'UPI India';
    case wallet_in = 'Indian Wallets India';
    case ebanking_in = 'India Netbanking India';
    case bankcard_in = 'India Credit/Debit Card India';
    case creditcard_kr = 'South Korea Credit Card South Korea';
    case ebanking_kr = 'South Korea Internet Banking South Korea';
    case kakaopay_kr = 'KakaoPay South Korea';
    case payco_kr = 'PAYCO South Korea';
    case ssgpay_kr = 'SSG Pay South Korea';
    case samsungpay_kr = 'Samsung Pay South Korea';
    case onecard = 'onecard Middle East & North Africa';
    case fawry_eg = 'Fawry Egypt';
    case santander_ar = 'Santander Rio Argentina';
    case pagofacil_ar = 'Pago Fácil Argentina';
    case rapipago_ar = 'Rapi Pago Argentina';
    case bancodobrasil_br = 'bancodobrasil Brazil';
    case itau_br = 'itau Brazil';
    case boleto_br = 'Boleto Brazil';
    case bradesco_br = 'bradesco Brazil';
    case caixa_br = 'caixa Brazil';
    case santander_br = 'Santander Brazil';
    case bancomer_mx = 'BBVA Bancomer Mexico';
    case santander_mx = 'Santander Mexico';
    case oxxo_mx = 'oxxo Mexico';
    case spei_mx = 'SPEI Mexico';
    case redpagos_uy = 'redpagos Uruguay';
    case abitab_uy = 'Abitab Uruguay';
    case bancochile_cl = 'Banco de Chile Chile';
    case redcompra_cl = 'RedCompra Chile';
    case webpay_cl = 'WebPay plus Chile';
    case servipag_cl = 'Servipag Chile';
    case santander_cl = 'Santander Chile';
    case efecty_co = 'Efecty Colombia';
    case pse_co = 'PSE Colombia';
    case bcp_pe = 'BCP Peru';
    case interbank_pe = 'Interbank Peru';
    case bbva_pe = 'BBVA Peru';
    case pagoefectivo_pe = 'Pago Efectivo Peru';
    case boacompra = 'BoaCompra Latin America';
    case qiwi = 'QIWI CIS countries';
    case yamoney = 'Yandex.Money CIS countries';
    case webmoney = 'Webmoney CIS countries';
    case yamoneyac = 'Bank Card (Yandex.Money) CIS countries';
    case yamoneygp = 'Cash (Yandex.Money) Russia';
    case moneta_ru = 'Moneta Russia';
    case alfaclick_ru = 'Alfa-Click Russia';
    case promsvyazbank_ru = 'Promsvyazbank Russia';
    case faktura_ru = 'Faktura Russia';
    case banktransfer_ru = 'Russia Bank transfer Russia';
    case bankcard_tr = 'Turkish Credit/Bank Card Turkey';
    case ininal_tr = 'ininal Turkey';
    case bkmexpress_tr = 'bkmexpress Turkey';
    case banktransfer_tr = 'Turkish Bank Transfer Turkey';
    case paysafecard = 'Paysafecard Global';
    case sofort = 'Sofort Europe';
    case giropay_de = 'Giropay Germany';
    case eps_at = 'EPS Austria';
    case bancontact_be = 'Bancontact/Mistercash Belgium';
    case dotpay_pl = 'Dotpay Poland';
    case p24_pl = 'P24 Poland';
    case payu_pl = 'PayU Poland';
    case payu_cz = 'PayU Czech Republic';
    case ideal_nl = 'iDeal Netherlands';
    case multibanco_pt = 'Multibanco Portugal';
    case neosurf = 'Neosurf France';
    case polipayment = 'Polipayment Australia & New Zealand';

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
