<?php

use App\Models\Gateway;
use Illuminate\Database\Seeder;

class PaymentLibrariesSeeder extends Seeder
{
    public function run()
    {
        Eloquent::unguard();

        $gateways = [
            ['name' => 'Authorize.Net AIM', 'provider' => 'AuthorizeNet_AIM', 'sort_order' => 5],
            ['name' => 'CardSave', 'provider' => 'CardSave'],
            ['name' => 'Eway Rapid', 'provider' => 'Eway_RapidShared', 'is_offsite' => true],
            ['name' => 'FirstData Connect', 'provider' => 'FirstData_Connect'],
            ['name' => 'Migs ThreeParty', 'provider' => 'Migs_ThreeParty'],
            ['name' => 'Migs TwoParty', 'provider' => 'Migs_TwoParty'],
            ['name' => 'Mollie', 'provider' => 'Mollie', 'is_offsite' => true, 'sort_order' => 8],
            ['name' => 'MultiSafepay', 'provider' => 'MultiSafepay'],
            ['name' => 'Netaxept', 'provider' => 'Netaxept'],
            ['name' => 'NetBanx', 'provider' => 'NetBanx'],
            ['name' => 'PayFast', 'provider' => 'PayFast', 'is_offsite' => true],
            ['name' => 'Payflow Pro', 'provider' => 'Payflow_Pro'],
            ['name' => 'PaymentExpress PxPay', 'provider' => 'PaymentExpress_PxPay'],
            ['name' => 'PaymentExpress PxPost', 'provider' => 'PaymentExpress_PxPost'],
            ['name' => 'PayPal Express', 'provider' => 'PayPal_Express', 'is_offsite' => true, 'sort_order' => 4],
            ['name' => 'PayPal Pro', 'provider' => 'PayPal_Pro'],
            ['name' => 'Pin', 'provider' => 'Pin'],
            ['name' => 'SagePay Direct', 'provider' => 'SagePay_Direct'],
            ['name' => 'SecurePay DirectPost', 'provider' => 'SecurePay_DirectPost'],
            ['name' => 'Stripe', 'provider' => 'Stripe', 'sort_order' => 1],
            ['name' => 'TargetPay Direct eBanking', 'provider' => 'TargetPay_Directebanking'],
            ['name' => 'TargetPay Ideal', 'provider' => 'TargetPay_Ideal'],
            ['name' => 'TargetPay Mr Cash', 'provider' => 'TargetPay_Mrcash'],
            ['name' => 'TwoCheckout', 'provider' => 'TwoCheckout', 'is_offsite' => true],
            ['name' => 'WorldPay', 'provider' => 'WorldPay'],
            ['name' => 'moolah', 'provider' => 'AuthorizeNet_AIM'],
            ['name' => 'Alipay', 'provider' => 'Alipay_Express'],
            ['name' => 'Buckaroo', 'provider' => 'Buckaroo_CreditCard'],
            ['name' => 'Coinbase', 'provider' => 'Coinbase', 'is_offsite' => true],
            ['name' => 'DataCash', 'provider' => 'DataCash'],
            ['name' => 'Pacnet', 'provider' => 'Pacnet'],
            ['name' => 'Realex', 'provider' => 'Realex_Remote'],
            ['name' => 'Sisow', 'provider' => 'Sisow'],
            ['name' => 'Skrill', 'provider' => 'Skrill', 'is_offsite' => true],
            ['name' => 'BitPay', 'provider' => 'BitPay', 'is_offsite' => true, 'sort_order' => 7],
            ['name' => 'AGMS', 'provider' => 'Agms'],
            ['name' => 'Barclays', 'provider' => 'BarclaysEpdq\Essential'],
            ['name' => 'Cardgate', 'provider' => 'Cardgate'],
            ['name' => 'Checkout.com', 'provider' => 'CheckoutCom'],
            ['name' => 'Creditcall', 'provider' => 'Creditcall'],
            ['name' => 'Cybersource', 'provider' => 'Cybersource'],
            ['name' => 'ecoPayz', 'provider' => 'Ecopayz'],
            ['name' => 'Fasapay', 'provider' => 'Fasapay'],
            ['name' => 'Komoju', 'provider' => 'Komoju'],
            ['name' => 'Paysafecard', 'provider' => 'Paysafecard'],
            ['name' => 'Paytrace', 'provider' => 'Paytrace_CreditCard'],
            ['name' => 'Secure Trading', 'provider' => 'SecureTrading'],
            ['name' => 'SecPay', 'provider' => 'SecPay'],
            ['name' => 'WePay', 'provider' => 'WePay', 'is_offsite' => false, 'sort_order' => 3],
            ['name' => 'Braintree', 'provider' => 'Braintree', 'sort_order' => 3],
            ['name' => 'Custom', 'provider' => 'Custom1', 'is_offsite' => true, 'sort_order' => 20],
            ['name' => 'FirstData Payeezy', 'provider' => 'FirstData_Payeezy'],
            ['name' => 'GoCardless', 'provider' => 'GoCardlessV2\Redirect', 'sort_order' => 9, 'is_offsite' => true],
            ['name' => 'PagSeguro', 'provider' => 'PagSeguro'],
            ['name' => 'PAYMILL', 'provider' => 'Paymill'],
            ['name' => 'Custom', 'provider' => 'Custom2', 'is_offsite' => true, 'sort_order' => 21],
            ['name' => 'Custom', 'provider' => 'Custom3', 'is_offsite' => true, 'sort_order' => 22],
        ];

        foreach ($gateways as $gateway) {
            $record = Gateway::whereName($gateway['name'])
                        ->whereProvider($gateway['provider'])
                        ->first();
            if ($record) {
                $record->fill($gateway);
                $record->save();
            } else {
                Gateway::create($gateway);
            }
        }
    }
}
