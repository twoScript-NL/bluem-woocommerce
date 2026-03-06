<?php
if (!defined('ABSPATH')) exit;
include_once __DIR__ . '/Bluem_Bank_Based_Payment_Gateway.php';

class Bluem_Bancontact_Payment_Gateway extends Bluem_Bank_Based_Payment_Gateway
{
    public function __construct()
    {
        parent::__construct(
            'bluem_payments_bancontact',
            esc_html__('Bluem payments via Bancontact', 'bluem'),
            esc_html__('Pay easily, quickly and safely via Bancontact', 'bluem'),
            null,
            plugins_url('../assets/payment-methods/bancontact.svg', __FILE__)
        );

        $options = get_option('bluem_woocommerce_options');
        if (!empty($options['paymentsBancontactBrandID'])) {
            $this->setBankSpecificBrandID($options['paymentsBancontactBrandID']);
        } elseif (!empty($options['paymentBrandID'])) {
            $this->setBankSpecificBrandID($options['paymentBrandID']); // legacy brandID support
        }
    }
}
